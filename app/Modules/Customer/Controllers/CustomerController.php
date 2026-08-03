<?php

namespace App\Modules\Customer\Controllers;

use App\Controllers\BaseController;
use App\Modules\Customer\Services\CustomerService;
use CodeIgniter\HTTP\ResponseInterface;

class CustomerController extends BaseController
{
    protected CustomerService $customerService;

    public function __construct()
    {
        $this->customerService = new CustomerService();
    }

    public function index()
    {
        $result = $this->customerService->getCustomers();

        $data = [
            'title' => 'Customers',
            'customers' => $result['data']['customers'] ?? [],
        ];

        return view('Customer/index', $data);
    }

    public function detail(string $uuid)
    {
        $result = $this->customerService->getCustomerByUuid($uuid);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Customer - ' . $result['data']['full_name'],
            'customer' => $result['data'],
        ];

        return view('Customer/detail', $data);
    }
}