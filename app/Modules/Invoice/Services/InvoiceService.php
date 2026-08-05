<?php

namespace App\Modules\Invoice\Services;

use App\Modules\Invoice\Models\InvoiceModel;
use App\Modules\Invoice\Models\InvoiceItemModel;
use Dompdf\Dompdf;

class InvoiceService
{
    protected InvoiceModel $invoiceModel;
    protected InvoiceItemModel $invoiceItemModel;

    public function __construct()
    {
        $this->invoiceModel = new InvoiceModel();
        $this->invoiceItemModel = new InvoiceItemModel();
    }

    public function getInvoices(): array
    {
        $userId = session()->get('user_id');
        $invoices = $this->invoiceModel->getInvoicesByUser($userId);

        return [
            'success' => true,
            'message' => 'Invoices retrieved successfully.',
            'data' => ['invoices' => $invoices],
        ];
    }

    public function getInvoiceByUuid(string $uuid): array
    {
        $invoice = $this->invoiceModel->where('uuid', $uuid)
            ->orWhere('invoice_number', $uuid)
            ->first();

        if (!$invoice) {
            return [
                'success' => false,
                'message' => 'Invoice not found.',
            ];
        }

        $items = $this->invoiceItemModel->getByInvoice($invoice->id);

        // Merge items into invoice object
        $invoice->items = $items;

        // Fetch billing info from user profile
        $db = \Config\Database::connect();
        $userInfo = $db->table('users u')
            ->select('u.email, up.full_name, up.phone, up.address, up.city, up.province')
            ->join('user_profiles up', 'up.user_id = u.id', 'left')
            ->where('u.id', $invoice->user_id)
            ->get()
            ->getRow();

        $invoice->billing_name = $userInfo->full_name ?? 'Customer';
        $invoice->billing_email = $userInfo->email ?? '';
        $invoice->billing_phone = $userInfo->phone ?? '';
        $invoice->billing_address = $userInfo->address ?? '';
        $invoice->billing_city = $userInfo->city ?? '';
        $invoice->billing_province = $userInfo->province ?? '';

        return [
            'success' => true,
            'message' => 'Invoice retrieved successfully.',
            'data' => $invoice,
        ];
    }

    public function countByUser(int $userId): int
    {
        return $this->invoiceModel->countByUser($userId);
    }

    public function getInvoicesByUser(int $userId): array
    {
        $invoices = $this->invoiceModel->getInvoicesByUser($userId);

        return [
            'success' => true,
            'message' => 'Invoices retrieved successfully.',
            'data' => ['invoices' => $invoices],
        ];
    }

    public function getUnpaidByUser(int $userId): array
    {
        $invoices = $this->invoiceModel->getUnpaidByUser($userId);

        return [
            'success' => true,
            'data' => $invoices,
        ];
    }

    public function generateInvoicePDF(string $uuid): string
    {
        $result = $this->getInvoiceByUuid($uuid);
        
        if (!$result['success']) {
            throw new \RuntimeException($result['message']);
        }

        $invoice = $result['data'];

        // Load the print view with invoice data
        $html = view('invoice/print', [
            'title' => 'Invoice - ' . $invoice->invoice_number,
            'invoice' => $invoice,
        ])->getBody();

        // Create PDF using DomPDF
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        
        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
        
        // Render PDF
        $dompdf->render();
        
        // Return PDF as string
        return $dompdf->output();
    }
}
