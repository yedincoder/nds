<?php

namespace App\Modules\Payment\Services;

use App\Modules\Payment\Models\PaymentMethodModel;
use App\Modules\Payment\Models\TransactionModel;
use App\Modules\Payment\Models\PaymentLogModel;

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

    public function verifyPayment(int $transactionId, string $status): array
    {
        try {
            $transaction = $this->transactionModel->find($transactionId);
            if (!$transaction) {
                return ['success' => false, 'message' => 'Transaction not found.'];
            }

            $db = \Config\Database::connect();
            $db->transBegin();

            try {
                // Update transaction status
                $updateData = ['status' => $status];
                if ($status === 'success') {
                    $updateData['paid_at'] = date('Y-m-d H:i:s');
                }
                $this->transactionModel->update($transactionId, $updateData);

                // Log payment result
                $logData = [
                    'uuid' => $this->generateUuidString(),
                    'transaction_id' => $transactionId,
                    'status' => $status,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->paymentLogModel->insert($logData);

                // Update invoice status if payment successful
                if ($status === 'success') {
                    $invoice = $db->table('invoices')->where('id', $transaction->invoice_id)->get()->getRow();
                    if ($invoice) {
                        $db->table('invoices')->where('id', $invoice->id)->update([
                            'status' => 'paid',
                            'paid_at' => date('Y-m-d H:i:s'),
                        ]);

                        // Update order status
                        $db->table('orders')->where('id', $invoice->order_id)->update([
                            'payment_status' => 'paid',
                            'status' => 'paid',
                        ]);
                    }
                }

                if ($db->transStatus() === false) {
                    $db->transRollback();
                    return ['success' => false, 'message' => 'Payment verification failed.'];
                }

                $db->transCommit();

                return [
                    'success' => true,
                    'message' => 'Payment verified successfully.',
                    'data' => $this->transactionModel->find($transactionId)
                ];
            } catch (\Throwable $e) {
                $db->transRollback();
                throw $e;
            }
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error verifying payment: ' . $e->getMessage()
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

    protected function generateUuidString(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return sprintf('%02x%02x%02x%02x-%02x%02x-%02x%02x-%02x%02x-%02x%02x%02x%02x%02x%02x',
            $data[0], $data[1], $data[2], $data[3],
            $data[4], $data[5], $data[6], $data[7],
            $data[8], $data[9], $data[10], $data[11],
            $data[12], $data[13], $data[14], $data[15]
        );
    }
}