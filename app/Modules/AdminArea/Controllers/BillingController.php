<?php

namespace App\Modules\AdminArea\Controllers;

use App\Modules\FrontArea\Models\InvoiceModel;
use CodeIgniter\HTTP\RedirectResponse;

class BillingController extends \App\Controllers\AdminBaseController
{
    protected InvoiceModel $invoiceModel;

    public function __construct()
    {
        $this->invoiceModel = new InvoiceModel();
    }

    public function index(): string
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');

        $builder = $this->invoiceModel
            ->select('invoices.*, users.username, users.email')
            ->join('users', 'users.id = invoices.user_id', 'left')
            ->orderBy('invoices.created_at', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('invoices.invoice_number', $search)
                ->orLike('users.username', $search)
                ->orLike('users.email', $search)
            ->groupEnd();
        }

        if (!empty($status)) {
            $builder->where('invoices.status', $status);
        }

        $billings = $builder->paginate($perPage, 'default', $page);
        $pager = $this->invoiceModel->pager;

        // Recalculate stats (separate queries to avoid affecting pagination)
        $db = \Config\Database::connect();
        $stats = [
            'total' => $db->table('invoices')->countAllResults(),
            'paid' => $db->table('invoices')->where('status', 'paid')->countAllResults(),
            'unpaid' => $db->table('invoices')->where('status', 'unpaid')->countAllResults(),
            'expired' => $db->table('invoices')->where('status', 'expired')->countAllResults(),
            'total_revenue' => $db->table('invoices')->where('status', 'paid')->selectSum('total')->get()->getRow()->total ?? 0,
        ];

        $data = [
            'title' => 'Billing',
            'page'  => 'admin/billing',
            'billings' => $billings,
            'pager' => $pager,
            'search' => $search,
            'current_status' => $status ?? 'all',
            'stats' => $stats,
        ];

        return view('AdminArea/dashboard/billing', $data);
    }

    public function detail(string $uuid): string
    {
        $billing = $this->invoiceModel
            ->select('invoices.*, users.username, users.email, users.phone')
            ->join('users', 'users.id = invoices.user_id', 'left')
            ->where('invoices.uuid', $uuid)
            ->first();

        if (!$billing) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $db = \Config\Database::connect();

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