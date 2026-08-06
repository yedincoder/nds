<?php

namespace App\Modules\FrontArea\Controllers;

use App\Controllers\BaseController;
use App\Modules\FrontArea\Services\PaymentService;
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
        log_message('error', 'PaymentController::process() REACHED - method: ' . $this->request->getMethod() . ', invoiceId: ' . $invoiceId);

        $result = $this->paymentService->getInvoiceById($invoiceId);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->getMethod() === 'POST') {
            $paymentMethodId = $this->request->getPost('payment_method_id');

            log_message('error', 'PaymentController::process() POST - invoiceId: ' . $invoiceId . ', method: ' . ($paymentMethodId ?? 'none'));

            try {
                $paymentResult = $this->paymentService->initiatePayment($invoiceId);
                log_message('error', 'PaymentController::process() - initiatePayment result: ' . json_encode($paymentResult));
            } catch (\Throwable $e) {
                log_message('error', 'PaymentController::process() EXCEPTION: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
                $paymentResult = ['success' => false, 'message' => 'Payment initiation exception: ' . $e->getMessage()];
            }

            if (!$paymentResult['success']) {
                // Show error on the same page instead of redirecting back
                $data = [
                    'title' => 'Payment - Invoice ' . $result['data']->invoice_number,
                    'invoice' => $result['data'],
                    'paymentMethods' => $this->paymentService->getPaymentMethods()['data'] ?? [],
                    'error' => $paymentResult['message'],
                ];

                return view('FrontArea/payment/process', $data);
            }

            // Redirect user DIRECTLY to Midtrans hosted payment page
            if (!empty($paymentResult['data']['redirect_url'])) {
                return redirect()->to($paymentResult['data']['redirect_url']);
            }

            // Fallback: if no redirect_url, render Midtrans payment page with snap token
            if (!empty($paymentResult['data']['snap_token'])) {
                $midtransConfig = config('MidtransConfig');
                $clientKey = $midtransConfig->clientKey ?? getenv('MIDTRANS_CLIENT_KEY');
                $isProduction = $midtransConfig->isProduction ?? (getenv('MIDTRANS_IS_PRODUCTION') === 'true');
                
                $snapUrl = $isProduction 
                    ? 'https://app.midtrans.com/snap/snap.js' 
                    : 'https://app.sandbox.midtrans.com/snap/snap.js';

                $data = [
                    'title' => 'Payment',
                    'invoice' => $result['data'],
                    'snap_token' => $paymentResult['data']['snap_token'],
                    'snap_url' => $snapUrl,
                    'client_key' => $clientKey,
                ];

                return view('FrontArea/midtrans/payment', $data);
            }

            return redirect()->back()
                ->with('success', $paymentResult['message']);
        }

        $data = [
            'title' => 'Payment - Invoice ' . $result['data']->invoice_number,
            'invoice' => $result['data'],
            'paymentMethods' => $this->paymentService->getPaymentMethods()['data'] ?? [],
        ];

        return view('FrontArea/payment/process', $data);
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
