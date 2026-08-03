<?php

namespace App\Modules\Invoice\Controllers;

use App\Controllers\BaseController;
use App\Modules\Invoice\Services\InvoiceService;
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

        return view('invoice/index', $data);
    }

    public function detail(string $uuid)
    {
        $result = $this->invoiceService->getInvoiceByUuid($uuid);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Invoice - ' . $result['data']['invoice_number'],
            'invoice' => $result['data'],
        ];

        return view('invoice/detail', $data);
    }

    public function download(string $uuid)
    {
        $result = $this->invoiceService->getInvoiceByUuid($uuid);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->invoiceService->generateInvoicePDF($result['data']);
    }

    public function print(string $uuid)
    {
        $result = $this->invoiceService->getInvoiceByUuid($uuid);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Invoice - ' . $result['data']['invoice_number'],
            'invoice' => $result['data'],
        ];

        return view('invoice/print', $data);
    }
}
