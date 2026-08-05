<?php

namespace App\Modules\FrontArea\Controllers;

use App\Controllers\BaseController;
use App\Modules\FrontArea\Services\InvoiceService;
use CodeIgniter\HTTP\ResponseInterface;

class InvoiceController extends BaseController
{
    protected InvoiceService $invoiceService;

    public function __construct()
    {
        $this->invoiceService = new InvoiceService();
    }

    public function index()
    {
        $result = $this->invoiceService->getInvoices();

        $data = [
            'title' => 'Invoices',
            'invoices' => $result['data']['invoices'] ?? [],
        ];

        return view('FrontArea/invoice/index', $data);
    }

    public function detail(string $uuid)
    {
        $result = $this->invoiceService->getInvoiceByUuid($uuid);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $invoice = $result['data'];

        $data = [
            'title' => 'Invoice - ' . $invoice->invoice_number,
            'invoice' => $invoice,
        ];

        return view('FrontArea/invoice/detail', $data);
    }

    public function download(string $uuid)
    {
        $result = $this->invoiceService->getInvoiceByUuid($uuid);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Generate PDF
        $pdfContent = $this->invoiceService->generateInvoicePDF($uuid);

        $filename = 'Invoice-' . $result['data']->invoice_number . '.pdf';

        // Return PDF response
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($pdfContent);
    }

    public function print(string $uuid)
    {
        $result = $this->invoiceService->getInvoiceByUuid($uuid);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $invoice = $result['data'];

        $data = [
            'title' => 'Invoice - ' . $invoice->invoice_number,
            'invoice' => $invoice,
        ];

        return view('FrontArea/invoice/print', $data);
    }
}
