<?php

namespace App\Modules\Payment\Controllers;

use App\Controllers\BaseController;
use App\Modules\Payment\Services\PaymentService;
use CodeIgniter\HTTP\ResponseInterface;

class PaymentController extends BaseController
{
    protected PaymentService $paymentService;

    public function __construct()
    {
        $this->paymentService = new PaymentService();
    }

    public function index()
    {
        $result = $this->paymentService->getPayments();

        $data = [
            'title' => 'Payment History',
            'payments' => $result['data']['payments'] ?? [],
        ];

        return view('payment/index', $data);
    }

    public function process(string $invoiceId)
    {
        $result = $this->paymentService->getInvoiceById($invoiceId);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->getMethod() === 'post') {
            $paymentMethodId = $this->request->getPost('payment_method_id');

            $result = $this->paymentService->initiatePayment($invoiceId, $paymentMethodId);

            if (!$result['success']) {
                return redirect()->back()
                    ->with('error', $result['message']);
            }

            if (isset($result['data']['redirect_url'])) {
                return redirect()->to($result['data']['redirect_url']);
            }

            return redirect()->back()
                ->with('success', $result['message']);
        }

        $data = [
            'title' => 'Payment - Invoice ' . $result['data']['invoice_number'],
            'invoice' => $result['data'],
            'paymentMethods' => $this->paymentService->getPaymentMethods()['data'] ?? [],
        ];

        return view('payment/process', $data);
    }

    public function success(string $transactionId)
    {
        $result = $this->paymentService->verifyPayment($transactionId);

        if ($result['success']) {
            return redirect()->to('invoice/' . $result['data']['invoice_uuid'])
                ->with('success', 'Payment verified successfully.');
        }

        return redirect()->to('payment')
            ->with('error', $result['message']);
    }

    public function failed(string $transactionId)
    {
        return redirect()->to('payment')
            ->with('error', 'Payment failed. Please try again.');
    }
}
