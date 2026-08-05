<?php

namespace App\Modules\FrontArea\Controllers;

use App\Controllers\BaseController;
use App\Modules\FrontArea\Services\MidtransService;
use CodeIgniter\HTTP\ResponseInterface;

class MidtransController extends BaseController
{
    protected MidtransService $midtransService;

    public function __construct()
    {
        $this->midtransService = new MidtransService();
    }

    /**
     * Initiate Midtrans payment
     */
    public function initiate(string $invoiceId): string|ResponseInterface
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('auth/login')
                ->with('error', 'Please login to continue payment.');
        }

        // Get invoice
        $db = \Config\Database::connect();
        $invoice = $db->table('invoices')
            ->where('id', $invoiceId)
            ->orWhere('uuid', $invoiceId)
            ->get()
            ->getRow();

        if (!$invoice) {
            return redirect()->to('cart')
                ->with('error', 'Invoice not found.');
        }

        // Check ownership
        if ($invoice->user_id != session()->get('user_id')) {
            return redirect()->to('client/dashboard')
                ->with('error', 'Unauthorized access.');
        }

        // Get existing pending transaction or initiate new payment
        $existingTxn = $db->table('midtrans_transactions')
            ->where('invoice_id', $invoice->id)
            ->where('status', 'pending')
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();

        if ($existingTxn && !empty($existingTxn->snap_token)) {
            $snapToken = $existingTxn->snap_token;
        } else {
            $result = $this->midtransService->initiatePayment($invoice->id);

            if (!$result['success']) {
                return redirect()->back()
                    ->with('error', $result['message']);
            }

            $snapToken = $result['data']['snap_token'];
        }

        // Get Midtrans configuration
        $midtransConfig = config('MidtransConfig');
        $clientKey = $midtransConfig->clientKey ?? getenv('MIDTRANS_CLIENT_KEY');
        $isProduction = $midtransConfig->isProduction ?? (getenv('MIDTRANS_IS_PRODUCTION') === 'true');
        
        $snapUrl = $isProduction 
            ? 'https://app.midtrans.com/snap/snap.js' 
            : 'https://app.sandbox.midtrans.com/snap/snap.js';

        // Display payment page
        $data = [
            'title' => 'Payment',
            'invoice' => $invoice,
            'snap_token' => $snapToken,
            'snap_url' => $snapUrl,
            'client_key' => $clientKey,
        ];

        return view('FrontArea/midtrans/payment', $data);
    }

    /**
     * Handle Midtrans notification webhook
     */
    public function notification(): ResponseInterface
    {
        try {
            $json = $this->request->getJSON(true);
            
            if (!$json) {
                return $this->response
                    ->setStatusCode(400)
                    ->setJSON(['status' => 'error', 'message' => 'Invalid JSON']);
            }

            log_message('info', 'Midtrans notification received: ' . json_encode($json));

            $result = $this->midtransService->handleWebhook($json);

            return $this->response
                ->setStatusCode(200)
                ->setJSON([
                    'status' => $result['success'] ? 'success' : 'error',
                    'message' => $result['message']
                ]);

        } catch (\Throwable $e) {
            log_message('error', 'Midtrans notification error: ' . $e->getMessage());
            
            return $this->response
                ->setStatusCode(500)
                ->setJSON(['status' => 'error', 'message' => 'Internal server error']);
        }
    }

    /**
     * Check payment status
     */
    public function status(string $orderId): ResponseInterface
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $result = $this->midtransService->verifyPayment($orderId);

        if ($result['success']) {
            return $this->response
                ->setStatusCode(200)
                ->setJSON($result);
        }

        return $this->response
            ->setStatusCode(400)
            ->setJSON($result);
    }

    /**
     * Payment success callback
     */
    public function success(): string|ResponseInterface
    {
        $orderId = $this->request->getGet('order_id');
        $transactionStatus = $this->request->getGet('transaction_status');

        if ($orderId) {
            $this->midtransService->verifyPayment($orderId);
        }

        $data = [
            'title' => 'Payment Success',
            'order_id' => $orderId,
            'status' => $transactionStatus,
        ];

        return view('FrontArea/midtrans/success', $data);
    }

    /**
     * Payment pending callback
     */
    public function pending(): string|ResponseInterface
    {
        $orderId = $this->request->getGet('order_id');

        $data = [
            'title' => 'Payment Pending',
            'order_id' => $orderId,
        ];

        return view('FrontArea/midtrans/pending', $data);
    }

    /**
     * Payment failed callback
     */
    public function error(): string|ResponseInterface
    {
        $orderId = $this->request->getGet('order_id');

        $data = [
            'title' => 'Payment Failed',
            'order_id' => $orderId,
        ];

        return view('FrontArea/midtrans/error', $data);
    }

}
