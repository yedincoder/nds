<?php

namespace App\Modules\FrontArea\Services;

use App\Modules\FrontArea\Models\PaymentMethodModel;
use App\Modules\FrontArea\Models\TransactionModel;
use App\Modules\FrontArea\Models\PaymentLogModel;

class PaymentService
{
    protected $paymentMethodModel;
    protected $transactionModel;
    protected $paymentLogModel;

    public function __construct()
    {
        $this->paymentMethodModel = new PaymentMethodModel();
        $this->transactionModel = new TransactionModel();
        $this->paymentLogModel = new PaymentLogModel();
    }

    public function processPayment(int $invoiceId, array $data): array
    {
        try {
            $db = \Config\Database::connect();
            $db->transBegin();

            try {
                // Get invoice
                $invoice = $db->table('invoices')->where('id', $invoiceId)->get()->getRow();
                if (!$invoice) {
                    return ['success' => false, 'message' => 'Invoice not found.'];
                }

                if ($invoice->status === 'paid') {
                    return ['success' => false, 'message' => 'Invoice already paid.'];
                }

                // Create transaction
                $transactionData = [
                    'uuid' => $this->generateUuidString(),
                    'invoice_id' => $invoiceId,
                    'payment_method' => $data['payment_method'] ?? 'cod',
                    'payment_reference' => $data['payment_reference'] ?? null,
                    'amount' => $data['amount'] ?? $invoice->total,
                    'status' => 'pending',
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                $transactionId = $this->transactionModel->insert($transactionData);
                if (!$transactionId) {
                    throw new \Exception('Failed to create transaction');
                }

                // Log payment attempt
                $logData = [
                    'uuid' => $this->generateUuidString(),
                    'transaction_id' => $transactionId,
                    'gateway_response' => $data['gateway_response'] ?? null,
                    'status' => 'pending',
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->paymentLogModel->insert($logData);

                if ($db->transStatus() === false) {
                    $db->transRollback();
                    return ['success' => false, 'message' => 'Payment processing failed.'];
                }

                $db->transCommit();

                return [
                    'success' => true,
                    'message' => 'Payment initiated successfully.',
                    'data' => [
                        'transaction_id' => $transactionId,
                        'payment_reference' => $transactionData['payment_reference'],
                        'amount' => $transactionData['amount']
                    ]
                ];
            } catch (\Throwable $e) {
                $db->transRollback();
                throw $e;
            }
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error processing payment: ' . $e->getMessage()
            ];
        }
    }

    public function logPayment(int $transactionId, array $data): array
    {
        try {
            $transaction = $this->transactionModel->find($transactionId);
            if (!$transaction) {
                return ['success' => false, 'message' => 'Transaction not found.'];
            }

            $logData = [
                'uuid' => $this->generateUuidString(),
                'transaction_id' => $transactionId,
                'gateway_response' => $data['gateway_response'] ?? null,
                'status' => $data['status'] ?? 'processed',
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $logId = $this->paymentLogModel->insert($logData);

            return [
                'success' => true,
                'message' => 'Payment log created successfully.',
                'data' => $this->paymentLogModel->find($logId)
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error logging payment: ' . $e->getMessage()
            ];
        }
    }

    public function getPaymentHistory(int $invoiceId): array
    {
        try {
            $transaction = $this->transactionModel->getByInvoice($invoiceId);
            if (!$transaction) {
                return [
                    'success' => true,
                    'message' => 'No payment found.',
                    'data' => []
                ];
            }

            $logs = $this->paymentLogModel->getByTransaction($transaction->id);

            return [
                'success' => true,
                'message' => 'Payment history retrieved successfully.',
                'data' => [
                    'transaction' => $transaction,
                    'logs' => $logs
                ]
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error retrieving payment history: ' . $e->getMessage()
            ];
        }
    }

    public function getPaymentMethods(): array
    {
        try {
            $methods = $this->paymentMethodModel->getActive();
            return [
                'success' => true,
                'message' => 'Payment methods retrieved successfully.',
                'data' => $methods
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error retrieving payment methods: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Initiate Midtrans payment for invoice
     */
    public function initiatePayment(string $invoiceId): array
    {
        try {
            $db = \Config\Database::connect();
            
            // Get invoice by uuid, invoice_number, or id
            $invoice = $db->table('invoices')
                ->where('uuid', $invoiceId)
                ->orWhere('invoice_number', $invoiceId)
                ->orWhere('id', $invoiceId)
                ->get()
                ->getRow();

            if (!$invoice) {
                return [
                    'success' => false,
                    'message' => 'Invoice not found.'
                ];
            }

            if ($invoice->status === 'paid') {
                return [
                    'success' => false,
                    'message' => 'Invoice already paid.'
                ];
            }

            // Use MidtransService for payment
            $midtransService = new \App\Modules\FrontArea\Services\MidtransService();
            
            $result = $midtransService->initiatePayment($invoice->id);

            return $result;

        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error initiating payment: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get invoice by UUID or invoice number
     */
    public function getInvoiceById(string $invoiceId): array
    {
        try {
            $db = \Config\Database::connect();
            
            // Try to find by uuid first, then by invoice_number
            $invoice = $db->table('invoices')
                ->where('uuid', $invoiceId)
                ->orWhere('invoice_number', $invoiceId)
                ->get()
                ->getRow();

            if (!$invoice) {
                return [
                    'success' => false,
                    'message' => 'Invoice not found.'
                ];
            }

            return [
                'success' => true,
                'message' => 'Invoice retrieved successfully.',
                'data' => $invoice
            ];

        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error retrieving invoice: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Verify payment by transaction ID
     */
    public function verifyPayment(string $transactionId): array
    {
        try {
            $midtransService = new \App\Modules\FrontArea\Services\MidtransService();
            
            $result = $midtransService->verifyPayment($transactionId);

            return $result;

        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error verifying payment: ' . $e->getMessage()
            ];
        }
    }

    protected function generateUuidString(): string
    {
        // Simple implementation dengan timestamp dan random number
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(100000, 999999)), 0, 8);
    }
}