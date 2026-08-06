<?php

namespace App\Modules\Auth\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

class AuthController extends BaseController
{
    public function index(): string|RedirectResponse
    {
        // Just redirect to login
        return redirect()->to('auth/login');
    }

    public function showLogin(): string|RedirectResponse
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to($this->redirectAfterLogin());
        }

        $data = [
            'title' => 'Login',
            'page'  => 'auth/login',
        ];

        return view('auth/login', $data);
    }

    public function login(): RedirectResponse
    {
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        if (empty($login) || empty($password)) {
            return redirect()->back()
                ->with('error', 'Email/username and password required')
                ->withInput();
        }

        $db = \Config\Database::connect();
        $user = $db->table('users')
            ->where('email', $login)
            ->orWhere('username', $login)
            ->get()
            ->getRow();

        if (!$user || !password_verify($password, $user->password_hash ?? '')) {
            return redirect()->back()
                ->with('error', 'Invalid credentials')
                ->withInput();
        }

        if ($user->status !== 'active') {
            return redirect()->back()
                ->with('error', 'Account is not active')
                ->withInput();
        }

        session()->regenerate();

        // Determine user role
        $role = $db->table('user_roles ur')
            ->select('r.slug')
            ->join('roles r', 'r.id = ur.role_id')
            ->where('ur.user_id', $user->id)
            ->get()
            ->getRow();

        $roleSlug = $role->slug ?? 'customer';

        session()->set([
            'isLoggedIn' => true,
            'user_id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'role' => $roleSlug,
            'user_role' => $roleSlug,
        ]);

        $db->table('users')->where('id', $user->id)->update([
            'last_login_at' => date('Y-m-d H:i:s'),
        ]);

        $isAdmin = in_array($roleSlug, ['super-administrator', 'administrator', 'mitra'], true);

        return redirect()->to($isAdmin ? ($roleSlug === 'mitra' ? 'mitra/dashboard' : 'admin/dashboard') : 'client/dashboard')
            ->with('success', 'Login successful');
    }

    public function showRegister(): string|RedirectResponse
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to($this->redirectAfterLogin());
        }

        return view('auth/register', ['title' => 'Register']);
    }

    public function register(): RedirectResponse
    {
        $full_name = $this->request->getPost('full_name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $password_confirm = $this->request->getPost('password_confirm');

        if (empty($full_name) || empty($email) || empty($password) || empty($password_confirm)) {
            return redirect()->back()
                ->with('error', 'All fields required')
                ->withInput();
        }

        if ($password !== $password_confirm) {
            return redirect()->back()
                ->with('error', 'Passwords do not match')
                ->withInput();
        }

        if (strlen($password) < 8) {
            return redirect()->back()
                ->with('error', 'Password must be at least 8 characters')
                ->withInput();
        }

        $db = \Config\Database::connect();
        $existing = $db->table('users')->where('email', $email)->get()->getRow();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Email already registered')
                ->withInput();
        }

        $db->table('users')->insert([
            'username' => strtolower(explode('@', $email)[0]),
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT),
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('auth/login')
            ->with('success', 'Account created. Please login.');
    }

    public function logout(): RedirectResponse
    {
        session()->destroy();
        return redirect()->to('auth/login')
            ->with('success', 'Logged out successfully');
    }

    private function redirectAfterLogin(): string
    {
        $role = session()->get('role') ?? 'customer';
        return in_array($role, ['super-administrator', 'administrator'], true) ? 'admin/dashboard' : 'client/dashboard';
    }
}