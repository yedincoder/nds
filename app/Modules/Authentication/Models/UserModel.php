<?php

namespace App\Modules\Authentication\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'uuid',
        'username',
        'email',
        'password_hash',
        'status',
        'last_login_at',
        'email_verified_at',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username,id,{id}]',
        'email'    => 'required|valid_email|max_length[255]|is_unique[users.email,id,{id}]',
        'password_hash' => 'required|min_length[8]|max_length[255]',
    ];

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data): array
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
            unset($data['data']['password']);
        }

        return $data;
    }

    public function findByEmail(string $email): ?object
    {
        return $this->where('email', $email)->first();
    }

    public function findByUsername(string $username): ?object
    {
        return $this->where('username', $username)->first();
    }

    public function findByLogin(string $identifier): ?object
    {
        return $this->groupStart()
            ->where('email', $identifier)
            ->orWhere('username', $identifier)
            ->groupEnd()
            ->first();
    }

    public function getRoles(int $userId): array
    {
        return $this->db->table('roles')
            ->select('roles.*')
            ->join('user_roles', 'user_roles.role_id = roles.id')
            ->where('user_roles.user_id', $userId)
            ->get()
            ->getResultArray();
    }

    public function getPermissions(int $userId): array
    {
        return $this->db->table('permissions')
            ->select('permissions.name')
            ->join('role_permissions', 'role_permissions.permission_id = permissions.id')
            ->join('user_roles', 'user_roles.role_id = role_permissions.role_id')
            ->where('user_roles.user_id', $userId)
            ->distinct()
            ->get()
            ->getResultArray();
    }

    public function hasRole(int $userId, string $roleSlug): bool
    {
        $role = $this->db->table('roles')
            ->join('user_roles', 'user_roles.role_id = roles.id')
            ->where('user_roles.user_id', $userId)
            ->where('roles.slug', $roleSlug)
            ->countAllResults();

        return $role > 0;
    }

    public function isActive(object $user): bool
    {
        return $user->status === 'active';
    }
}