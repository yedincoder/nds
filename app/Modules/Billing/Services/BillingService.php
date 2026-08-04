<?php

namespace App\Modules\Billing\Services;

class BillingService
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function getUserInvoices(int $userId, int $perPage = 10, int $page = 1): array
    {
        $builder = $this->db->table('invoices i');
        $builder->select('i.*, o.order_number');
        $builder->join('orders o', 'o.id = i.order_id', 'left');
        $builder->where('i.user_id', $userId);
        $total = $builder->countAllResults(false);

        $invoices = $builder->orderBy('i.created_at', 'DESC')
            ->limit($perPage, ($page - 1) * $perPage)
            ->get()
            ->getResult();

        return [
            'invoices'   => $invoices,
            'total'      => $total,
            'perPage'    => $perPage,
            'page'       => $page,
            'totalPages' => (int) ceil($total / $perPage),
        ];
    }

    public function getInvoice(int $invoiceId): ?object
    {
        return $this->db->table('invoices i')
            ->select('i.*, o.order_number, u.full_name as user_name, u.email as user_email')
            ->join('orders o', 'o.id = i.order_id', 'left')
            ->join('users u', 'u.id = i.user_id', 'left')
            ->where('i.id', $invoiceId)
            ->get()
            ->getRow();
    }

    public function getInvoiceByNumber(string $invoiceNumber): ?object
    {
        return $this->db->table('invoices')
            ->where('invoice_number', $invoiceNumber)
            ->get()
            ->getRow();
    }

    public function getInvoiceItems(int $invoiceId): array
    {
        return $this->db->table('invoice_items')
            ->where('invoice_id', $invoiceId)
            ->orderBy('created_at', 'ASC')
            ->get()
            ->getResult();
    }

    public function getTransactions(int $invoiceId): array
    {
        return $this->db->table('transactions')
            ->where('invoice_id', $invoiceId)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResult();
    }

    public function createInvoice(int $orderId, int $userId, array $data): ?int
    {
        $this->db->transBegin();

        $invoiceNumber = $this->generateInvoiceNumber();

        $this->db->table('invoices')->insert([
            'uuid'           => $this->generateUuid(),
            'user_id'        => $userId,
            'order_id'       => $orderId,
            'invoice_number' => $invoiceNumber,
            'status'         => $data['status'] ?? 'draft',
            'subtotal'       => $data['subtotal'] ?? 0,
            'discount'       => $data['discount'] ?? 0,
            'tax'            => $data['tax'] ?? 0,
            'total'          => $data['total'] ?? 0,
            'due_date'       => $data['due_date'] ?? null,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ]);

        $invoiceId = $this->db->insertID();

        if ($invoiceId && !empty($data['items'])) {
            foreach ($data['items'] as $item) {
                $this->db->table('invoice_items')->insert([
                    'uuid'        => $this->generateUuid(),
                    'invoice_id'  => $invoiceId,
                    'product_id'  => $item['product_id'] ?? null,
                    'service_id'  => $item['service_id'] ?? null,
                    'description' => $item['description'] ?? '',
                    'quantity'    => $item['quantity'] ?? 1,
                    'price'       => $item['price'] ?? 0,
                    'subtotal'    => $item['subtotal'] ?? 0,
                    'created_at'  => date('Y-m-d H:i:s'),
                ]);
            }
        }

        $this->db->transComplete();

        return $this->db->transStatus() ? $invoiceId : null;
    }

    public function updateInvoiceStatus(int $invoiceId, string $status): bool
    {
        $updateData = ['status' => $status, 'updated_at' => date('Y-m-d H:i:s')];

        if ($status === 'paid') {
            $updateData['paid_at'] = date('Y-m-d H:i:s');
        }

        return $this->db->table('invoices')
            ->where('id', $invoiceId)
            ->update($updateData);
    }

    // ── Admin methods ──────────────────────────────────────

    public function getAllInvoices(array $filters = [], int $perPage = 20, int $page = 1): array
    {
        $builder = $this->db->table('invoices i');
        $builder->select('i.*, u.full_name as user_name, o.order_number');
        $builder->join('users u', 'u.id = i.user_id', 'left');
        $builder->join('orders o', 'o.id = i.order_id', 'left');

        if (!empty($filters['status'])) {
            $builder->where('i.status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $builder->groupStart();
            $builder->like('i.invoice_number', $filters['search']);
            $builder->orLike('u.full_name', $filters['search']);
            $builder->groupEnd();
        }

        $total = $builder->countAllResults(false);
        $invoices = $builder->orderBy('i.created_at', 'DESC')
            ->limit($perPage, ($page - 1) * $perPage)
            ->get()
            ->getResult();

        return [
            'invoices'   => $invoices,
            'total'      => $total,
            'perPage'    => $perPage,
            'page'       => $page,
            'totalPages' => (int) ceil($total / $perPage),
        ];
    }

    public function getBillingStats(): array
    {
        return [
            'total_invoices'  => $this->db->table('invoices')->countAllResults(),
            'unpaid_invoices'  => $this->db->table('invoices')->where('status', 'unpaid')->countAllResults(),
            'paid_invoices'    => $this->db->table('invoices')->where('status', 'paid')->countAllResults(),
            'total_revenue'    => $this->db->table('invoices')->where('status', 'paid')->selectSum('total')->get()->getRow()->total ?? 0,
        ];
    }

    public function getBillings()
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return [
                'success' => false,
                'message' => 'Unauthorized',
                'data' => []
            ];
        }

        $invoices = $this->getUserInvoices($userId);

        return [
            'success' => true,
            'message' => 'Billings retrieved successfully',
            'data' => [
                'billings' => $invoices['invoices'],
                'summary' => [
                    'total' => $invoices['total'],
                    'unpaid_count' => $this->db->table('invoices')->where('user_id', $userId)->where('status', 'unpaid')->countAllResults(),
                ]
            ]
        ];
    }

    public function getBillingByUuid(string $uuid)
    {
        $invoice = $this->db->table('invoices')
            ->where('uuid', $uuid)
            ->get()
            ->getRow();

        if (!$invoice) {
            return [
                'success' => false,
                'message' => 'Billing not found',
            ];
        }

        $items = $this->getInvoiceItems($invoice->id);

        return [
            'success' => true,
            'message' => 'Billing retrieved successfully',
            'data' => [
                'uuid' => $invoice->uuid,
                'invoice_number' => $invoice->invoice_number,
                'status' => $invoice->status,
                'total' => $invoice->total,
                'items' => $items,
            ]
        ];
    }

    protected function generateInvoiceNumber(): string
    {
        return 'INV-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }

    protected function generateUuid(): string
    {
        // Simple implementation dengan timestamp dan random number (Windows compatible)
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(100000, 999999)), 0, 8);
    }
}
