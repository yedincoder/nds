<?php

namespace App\Modules\Authentication\Services;

use App\Modules\Authentication\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Session\Session;
use Config\Services;
use RuntimeException;

class AuthService
{
    protected UserModel $userModel;
    protected Session $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = Services::session();
    }

    /**
     * Register a new customer account.
     *
     * @return array{success: bool, message: string, user?: object}
     */
    public function register(array $data): array
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $uuid = $this->generateUuid();

            $user = [
                'uuid'          => $uuid,
                'username'      => $data['username'] ?? $this->generateUsername($data['email']),
                'email'         => $data['email'],
                'password'      => $data['password'],
                'status'        => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ];

            if (!$this->userModel->insert($user)) {
                throw new RuntimeException('Registration failed: ' . implode(', ', $this->userModel->errors()));
            }

            $userId = $this->userModel->getInsertID();

            // Assign Customer role
            $role = $db->table('roles')->where('slug', 'customer')->get()->getRow();
            if ($role) {
                $db->table('user_roles')->insert([
                    'user_id'    => $userId,
                    'role_id'    => $role->id,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }

            // Create profile
            $db->table('user_profiles')->insert([
                'uuid'       => $this->generateUuid(),
                'user_id'    => $userId,
                'full_name'  => $data['full_name'] ?? $data['username'] ?? $data['email'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            if ($db->transStatus() === false) {
                $db->transRollback();
                return ['success' => false, 'message' => 'Registration failed. Please try again.'];
            }

            $db->transCommit();

            return [
                'success' => true,
                'message' => 'Account created successfully.',
                'user'    => $this->userModel->find($userId),
            ];
        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', 'Register failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Registration failed. Please try again.'];
        }
    }

    /**
     * Attempt to authenticate a user.
     *
     * @return array{success: bool, message: string, redirect?: string}
     */
    public function attemptLogin(array $credentials): array
    {
        $identifier = $credentials['login'] ?? '';
        $password   = $credentials['password'] ?? '';

        // Brute force check
        if ($this->isLockedOut($identifier)) {
            return ['success' => false, 'message' => 'Too many failed attempts. Please try again in 15 minutes.'];
        }

        $user = $this->userModel->findByLogin($identifier);

        if (!$user || !password_verify($password, $user->password_hash)) {
            $this->logAttempt($identifier, 'failed');
            return ['success' => false, 'message' => 'Invalid credentials.'];
        }

        if ($user->status !== 'active') {
            $this->logAttempt($identifier, 'failed');
            return ['success' => false, 'message' => 'Your account is not active. Please contact support.'];
        }

        $this->userModel->update($user->id, [
            'last_login_at' => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);

        $this->logAttempt($identifier, 'success');

        $roles  = $this->userModel->getRoles($user->id);
        $perms  = $this->userModel->getPermissions($user->id);

        $this->session->regenerate();

        $this->session->set([
            'isLoggedIn' => true,
            'user_id'    => $user->id,
            'uuid'       => $user->uuid,
            'username'   => $user->username,
            'email'      => $user->email,
            'roles'      => array_column($roles, 'slug'),
            'permissions'=> array_column($perms, 'name'),
        ]);

        // Record activity
        $this->recordActivity($user->id, 'login', 'User logged in');

        $isAdmin = in_array('super-administrator', $this->session->get('roles'), true)
            || in_array('administrator', $this->session->get('roles'), true);

        return [
            'success'  => true,
            'message'  => 'Login successful.',
            'redirect' => $isAdmin ? 'admin/dashboard' : 'client/dashboard',
        ];
    }

    public function logout(): void
    {
        $userId = $this->session->get('user_id');
        if ($userId) {
            $this->recordActivity($userId, 'logout', 'User logged out');
        }

        $this->session->destroy();
    }

    public function isLoggedIn(): bool
    {
        return (bool) $this->session->get('isLoggedIn');
    }

    public function currentUserId(): ?int
    {
        return $this->session->get('user_id') ? (int) $this->session->get('user_id') : null;
    }

    public function currentUser(): ?object
    {
        $id = $this->currentUserId();

        return $id ? $this->userModel->find($id) : null;
    }

    public function hasPermission(string $permission): bool
    {
        $permissions = $this->session->get('permissions') ?? [];

        return in_array('*', $permissions, true) || in_array($permission, $permissions, true);
    }

    public function hasRole(string $roleSlug): bool
    {
        $roles = $this->session->get('roles') ?? [];

        return in_array($roleSlug, $roles, true);
    }

    protected function logAttempt(string $identifier, string $status): void
    {
        try {
            $user = $this->userModel->findByLogin($identifier);
            $db = \Config\Database::connect();
            $db->table('login_attempts')->insert([
                'user_id'    => $user->id ?? null,
                'email'      => $identifier,
                'ip_address' => service('request')->getIPAddress(),
                'status'     => $status,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Login attempt log failed: ' . $e->getMessage());
        }
    }

    protected function isLockedOut(string $identifier): bool
    {
        $db = \Config\Database::connect();
        $attempts = $db->table('login_attempts')
            ->where('email', $identifier)
            ->where('status', 'failed')
            ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-15 minutes')))
            ->countAllResults();

        return $attempts >= 5;
    }

    protected function recordActivity(int $userId, string $type, string $description): void
    {
        try {
            $db = \Config\Database::connect();
            $db->table('activity_logs')->insert([
                'uuid'          => $this->generateUuid(),
                'user_id'       => $userId,
                'activity_type' => $type,
                'description'   => $description,
                'ip_address'    => service('request')->getIPAddress(),
                'user_agent'    => service('request')->getUserAgent()->getAgentString(),
                'created_at'    => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Activity log failed: ' . $e->getMessage());
        }
    }

    protected function generateUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        $uuid = sprintf('%02x%02x%02x%02x-%02x%02x-%02x%02x-%02x%02x-%02x%02x%02x%02x%02x%02x',
            $data[0], $data[1], $data[2], $data[3],
            $data[4], $data[5], $data[6], $data[7],
            $data[8], $data[9], $data[10], $data[11],
            $data[12], $data[13], $data[14], $data[15]
        );

        return $uuid;
    }

    protected function generateUsername(string $email): string
    {
        $base = strtolower(explode('@', $email)[0]);
        $base = preg_replace('/[^a-z0-9_]/', '', $base);
        $base = substr($base, 0, 50);

        if ($this->userModel->where('username', $base)->countAllResults() > 0) {
            $base .= '_' . random_int(1000, 9999);
        }

        return $base;
    }
}