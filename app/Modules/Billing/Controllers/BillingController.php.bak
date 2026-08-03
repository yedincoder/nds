<?php

namespace App\Modules\Billing\Controllers;

use App\Controllers\BaseController;
use App\Modules\Billing\Services\BillingService;
use CodeIgniter\HTTP\ResponseInterface;

class BillingController extends BaseController
{
    protected BillingService $billingService;

    public function __construct()
    {
        $this->billingService = new BillingService();
    }

    public function index()
    {
        $result = $this->billingService->getBillings();

        $data = [
            'title' => 'Billing',
            'billings' => $result['data']['billings'] ?? [],
            'summary' => $result['data']['summary'] ?? [],
        ];

        return view('invoice/index', $data);
    }

    public function detail(string $uuid)
    {
        $result = $this->billingService->getBillingByUuid($uuid);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Billing - ' . $result['data']['uuid'],
            'billing' => $result['data'],
        ];

        return view('invoice/detail', $data);
    }
}
