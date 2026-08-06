<?php

namespace App\Modules\AdminArea\Controllers;

use App\Modules\Auth\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class UsersController extends \App\Controllers\AdminBaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index(): string
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');

        $builder = $this->userModel->orderBy('created_at', 'DESC');
        if (!empty($search)) {
            $builder->groupStart()
                ->like('username', $search)
                ->orLike('email', $search)
            ->groupEnd();
        }
        if (!empty($status) && in_array($status, ['active', 'inactive', 'suspended'], true)) {
            $builder->where('status', $status);
        }

        $users = $builder->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Manage Users',
            'page'  => 'admin/auth',
            'users' => $users,
            'pager' => $this->userModel->pager,
            'search' => $search,
            'current_status' => $status ?? 'all',
            'stats' => [
                'total' => $this->userModel->countAllResults(),
                'active' => $this->userModel->where('status', 'active')->countAllResults(),
                'inactive' => $this->userModel->where('status', 'inactive')->countAllResults(),
                'suspended' => $this->userModel->where('status', 'suspended')->countAllResults(),
            ],
        ];

        return view('AdminArea/dashboard/users', $data);
    }

    public function create(): string
    {
        $data = [
            'title' => 'Create User',
            'page'  => 'admin/auth',
        ];
        return view('AdminArea/dashboard/user_form', $data);
    }

    public function store(): RedirectResponse
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
            'email'    => 'required|valid_email|max_length[255]|is_unique[users.email]',
            'password' => 'required|min_length[8]|max_length[255]',
            'status'   => 'required|in_list[active,inactive,suspended]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $this->userModel->save([
            'username'    => $this->request->getPost('username'),
            'email'       => $this->request->getPost('email'),
            'password'    => $this->request->getPost('password'),
            'status'      => $this->request->getPost('status'),
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/auth')
            ->with('success', 'User created successfully.');
    }

    public function edit(int $id): string|RedirectResponse
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/auth')
                ->with('error', 'User not found.');
        }

        $data = [
            'title' => 'Edit User',
            'page'  => 'admin/auth',
            'user' => $user,
        ];
        return view('AdminArea/dashboard/user_form', $data);
    }

    public function update(int $id): RedirectResponse
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/auth')
                ->with('error', 'User not found.');
        }

        $rules = [
            'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username,id,{id}]',
            'email'    => 'required|valid_email|max_length[255]|is_unique[users.email,id,{id}]',
            'status'   => 'required|in_list[active,inactive,suspended]',
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[8]|max_length[255]';
        }

        if (!$this->validate($rules, [], $this->request->getPost() + ['id' => $id])) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'status'   => $this->request->getPost('status'),
        ];

        if (!empty($password)) {
            $data['password'] = $password;
        }

        $this->userModel->update($id, $data);

        return redirect()->to('/admin/auth')
            ->with('success', 'User updated successfully.');
    }

    public function delete(int $id): RedirectResponse
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/auth')
                ->with('error', 'User not found.');
        }

        $this->userModel->delete($id, true);

        return redirect()->to('/admin/auth')
            ->with('success', 'User deleted successfully.');
    }

    public function toggleStatus(int $id): RedirectResponse
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/auth')
                ->with('error', 'User not found.');
        }

        $statuses = ['active', 'inactive', 'suspended'];
        $currentIndex = array_search($user->status, $statuses);
        $nextIndex = ($currentIndex + 1) % count($statuses);
        $newStatus = $statuses[$nextIndex];

        $this->userModel->update($id, ['status' => $newStatus]);

        return redirect()->back()
            ->with('success', "User status changed to {$newStatus}.");
    }
}