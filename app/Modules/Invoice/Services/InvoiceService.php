<?php

namespace App\Modules\Invoice\Services;

use App\Modules\Invoice\Models\InvoiceModel;
use App\Modules\Invoice\Models\InvoiceItemModel;

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
        $invoice = $this->invoiceModel->getInvoiceByUuid($uuid);

        if (!$invoice) {
            return [
                'success' => false,
                'message' => 'Invoice not found.',
            ];
        }

        $items = $this->invoiceItemModel->getByInvoice($invoice->id);

        return [
            'success' => true,
            'message' => 'Invoice retrieved successfully.',
            'data' => [
                'invoice' => $invoice,
                'items' => $items,
            ],
        ];
    }

    public function countByUser(int $userId): int
    {
        return $this->invoiceModel->countByUser($userId);
    }

    public function getUnpaidByUser(int $userId): array
    {
        $invoices = $this->invoiceModel->getUnpaidByUser($userId);

        return [
            'success' => true,
            'data' => $invoices,
        ];
    }

    public function generateInvoicePDF($invoice)
    {
        return redirect()->back()->with('error', 'PDF generation not implemented yet.');
    }
}
