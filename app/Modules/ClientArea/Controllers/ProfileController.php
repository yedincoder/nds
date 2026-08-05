<?php

namespace App\Modules\ClientArea\Controllers;

use App\Controllers\BaseController;
use App\Modules\ClientArea\Services\CustomerService;
use CodeIgniter\HTTP\ResponseInterface;

class ProfileController extends BaseController
{
    protected CustomerService $customerService;

    public function __construct()
    {
        $this->customerService = new CustomerService();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $result = $this->customerService->getProfile($userId);

        $data = [
            'title' => 'My Profile',
            'profile' => $result['data'] ?? null,
        ];

        return view('ClientArea/profile', $data);
    }

    public function update(): ResponseInterface
    {
        $userId = session()->get('user_id');

        $validation = $this->validate([
            'full_name' => 'required|min_length[3]|max_length[255]',
            'phone' => 'permit_empty|max_length[30]',
        ]);

        if (!$validation) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $result = $this->customerService->updateProfile($userId, [
            'full_name' => $this->request->getPost('full_name'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'province' => $this->request->getPost('province'),
        ]);

        if ($result['success']) {
            return redirect()->back()
                ->with('success', $result['message']);
        }

        return redirect()->back()
            ->with('error', $result['message'])
            ->withInput();
    }

    public function changePassword(): ResponseInterface
    {
        $userId = session()->get('user_id');

        $validation = $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]',
        ]);

        if (!$validation) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors());
        }

        $result = $this->customerService->changePassword($userId, [
            'current_password' => $this->request->getPost('current_password'),
            'new_password' => $this->request->getPost('new_password'),
        ]);

        if ($result['success']) {
            return redirect()->back()
                ->with('success', $result['message']);
        }

        return redirect()->back()
            ->with('error', $result['message']);
    }

    public function addresses()
    {
        $userId = session()->get('user_id');
        $result = $this->customerService->getAddresses($userId);

        $data = [
            'title' => 'My Addresses',
            'addresses' => $result['data']['addresses'] ?? [],
        ];

        return view('ClientArea/addresses', $data);
    }

    public function addAddress(): ResponseInterface
    {
        $userId = session()->get('user_id');

        $validation = $this->validate([
            'name' => 'required|min_length[3]',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
        ]);

        if (!$validation) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $result = $this->customerService->addAddress($userId, [
            'name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'province' => $this->request->getPost('province'),
            'postal_code' => $this->request->getPost('postal_code'),
            'is_default' => $this->request->getPost('is_default') ? 1 : 0,
        ]);

        if ($result['success']) {
            return redirect()->to('client/addresses')
                ->with('success', $result['message']);
        }

        return redirect()->back()
            ->with('error', $result['message'])
            ->withInput();
    }

    public function deleteAddress(string $addressId): ResponseInterface
    {
        $userId = session()->get('user_id');
        $result = $this->customerService->deleteAddress($userId, $addressId);

        if ($result['success']) {
            return redirect()->to('client/addresses')
                ->with('success', $result['message']);
        }

        return redirect()->back()
            ->with('error', $result['message']);
    }
}
