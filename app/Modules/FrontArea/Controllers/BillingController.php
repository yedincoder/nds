<?php
namespace App\Modules\FrontArea\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class BillingController extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();
        
        $billings = $db->table('invoices i')
            ->select('i.*, u.username')
            ->join('users u', 'u.id = i.user_id', 'left')
            ->orderBy('i.created_at', 'DESC')
            ->get()
            ->getResult();

        $data = [
            'title' => 'Billing',
            'billings' => $billings ?? [],
            'summary' => [],
        ];

        return view('FrontArea/Dashboard/billing', $data);
    }

    public function detail(string $uuid): string
    {
        $db = \Config\Database::connect();
        $billing = $db->table('invoices')
            ->where('uuid', $uuid)
            ->get()
            ->getRow();

        if (!$billing) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Billing - ' . $billing->uuid,
            'billing' => $billing,
        ];

        return view('FrontArea/Dashboard/billing_detail', $data);
    }
}
