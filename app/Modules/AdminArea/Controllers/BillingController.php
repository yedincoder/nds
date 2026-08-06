<?php

namespace App\Modules\AdminArea\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class BillingController extends \App\Controllers\AdminBaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');

        $builder = $db->table('invoices i')
            ->select('i.*, u.username, u.email')
            ->join('users u', 'u.id = i.user_id', 'left')
            ->orderBy('i.created_at', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('i.invoice_number', $search)
                ->orLike('u.username', $search)
                ->orLike('u.email', $search)
            ->groupEnd();
        }

        if (!empty($status)) {
            $builder->where('i.status', $status);
        }

        $billings = $builder->paginate($perPage, 'default', $page);
        $pager = $db->table('invoices')->pager;

        $data = [
            'title' => 'Billing',
            'page'  => 'admin/billing',
            'billings' => $billings,
            'pager' => $pager,
            'search' => $search,
            'current_status' => $status ?? 'all',
            'stats' => [
                'total' => $db->table('invoices')->countAllResults(),
                'paid' => $db->table('invoices')->where('status', 'paid')->countAllResults(),
                'unpaid' => $db->table('invoices')->where('status', 'unpaid')->countAllResults(),
                'expired' => $db->table('invoices')->where('status', 'expired')->countAllResults(),
                'total_revenue' => $db->table('invoices')->where('status', 'paid')->selectSum('total')->get()->getRow()->total ?? 0,
            ],
        ];

        return view('AdminArea/dashboard/billing', $data);
    }

    public function detail(string $uuid): string
    {
        $db = \Config\Database::connect();
        $billing = $db->table('invoices i')
            ->select('i.*, u.username, u.email, u.phone')
            ->join('users u', 'u.id = i.user_id', 'left')
            ->where('i.uuid', $uuid)
            ->get()
            ->getRow();

        if (!$billing) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Get invoice items
        $items = $db->table('invoice_items')
            ->where('invoice_id', $billing->id)
            ->get()
            ->getResult();

        // Get payments for this invoice
        $payments = $db->table('transactions')
            ->where('invoice_id', $billing->id)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResult();

        $data = [
            'title' => 'Billing - ' . $billing->invoice_number,
            'page'  => 'admin/billing',
            'billing' => $billing,
            'items' => $items,
            'payments' => $payments,
        ];

        return view('AdminArea/dashboard/billing_detail', $data);
    }
}