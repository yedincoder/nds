<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Modules\Authentication\Services\AuthService;
use CodeIgniter\HTTP\ResponseInterface;

class AuthApiController extends BaseController
{
    protected AuthService $auth;

    public function __construct()
    {
        $this->auth = new AuthService();
    }

    public function login(): ResponseInterface
    {
        $rules = [
            'login'    => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->respond([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $this->validator->getErrors(),
            ], 422);
        }

        $result = $this->auth->attemptLogin([
            'login'    => $this->request->getJSON()->login ?? $this->request->getPost('login'),
            'password' => $this->request->getJSON()->password ?? $this->request->getPost('password'),
        ]);

        if (!$result['success']) {
            return $this->respond([
                'status'  => false,
                'message' => $result['message'],
            ], 401);
        }

        return $this->respond([
            'status'  => true,
            'message' => 'Login successful',
            'data'    => [
                'user'    => $this->auth->currentUser(),
                'roles'   => session('roles'),
                'permissions' => session('permissions'),
            ],
        ]);
    }

    public function register(): ResponseInterface
    {
        $rules = [
            'full_name' => 'required|min_length[3]|max_length[255]',
            'email'     => 'required|valid_email|is_unique[users.email]',
            'password'  => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return $this->respond([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $this->validator->getErrors(),
            ], 422);
        }

        $result = $this->auth->register([
            'full_name' => $this->request->getJSON()->full_name ?? $this->request->getPost('full_name'),
            'email'     => $this->request->getJSON()->email ?? $this->request->getPost('email'),
            'password'  => $this->request->getJSON()->password ?? $this->request->getPost('password'),
        ]);

        if (!$result['success']) {
            return $this->respond([
                'status'  => false,
                'message' => $result['message'],
            ], 400);
        }

        return $this->respond([
            'status'  => true,
            'message' => 'Account created successfully',
            'data'    => $result['user'],
        ], 201);
    }

    public function profile(): ResponseInterface
    {
        if (!$this->auth->isLoggedIn()) {
            return $this->respond([
                'status'  => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        return $this->respond([
            'status'  => true,
            'message' => 'User profile',
            'data'    => $this->auth->currentUser(),
        ]);
    }

    public function logout(): ResponseInterface
    {
        $this->auth->logout();

        return $this->respond([
            'status'  => true,
            'message' => 'Logged out successfully',
        ]);
    }
}