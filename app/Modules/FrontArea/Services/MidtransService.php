<?php

namespace App\Modules\FrontArea\Services;

use App\Modules\FrontArea\Libraries\MidtransLibrary;
use App\Modules\FrontArea\Models\TransactionModel;
use App\Modules\FrontArea\Models\PaymentModel;

class MidtransService
{
    protected $midtransLibrary;
    protected $transactionModel;
    protected $paymentModel;
    protected $db;

    public function __construct()
    {
        $this->midtransLibrary = new MidtransLibrary();
        $this->transactionModel = new TransactionModel();
        $this->paymentModel = new PaymentModel();
        $this->db = \Config\Database::connect();
    }

    /**
     * Initiate Midtrans payment and get Snap token
     */
    public function initiatePayment(int $invoiceId, int $paymentMethodId = null): array
    {
        try {
            log_message('debug', 'MidtransService::initiatePayment() - invoiceId: ' . $invoiceId);
            
            // Get invoice
            $invoice = $this->db->table('invoices')
                ->where('id', $invoiceId)
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

            // Get order
            $order = $this->db->table('orders')
                ->where('id', $invoice->order_id)
                ->get()
                ->getRow();

            // Get user
            $user = $this->db->table('users')
                ->where('id', $invoice->user_id)
                ->get()
                ->getRow();

            // Prepare transaction details
            $transactionDetails = [
                'order_id' => $invoice->invoice_number,
                'gross_amount' => (float) $invoice->total,
            ];

            // Prepare customer details
            $customerDetails = [
                'first_name' => $user->full_name ?? 'Customer',
                'email' => $user->email ?? 'customer@ngappid.id',
                'phone' => $user->phone ?? '081234567890',
            ];

// Get billing address
            $billingAddress = $this->db->table('customer_addresses')
                ->where('user_id', $invoice->user_id)
                ->orderBy('is_default', 'DESC')
                ->get()
                ->getRow();

            if ($billingAddress) {
                $customerDetails['address'] = $billingAddress->address;
                $customerDetails['city'] = $billingAddress->city;
                $customerDetails['postal_code'] = $billingAddress->postal_code ?? '';
                $customerDetails['country_code'] = 'IDN';
            }

            // Prepare item details
            $itemDetails = [];
            $orderItems = $this->db->table('order_items')
                ->where('order_id', $order->id)
                ->get()
                ->getResult();

            foreach ($orderItems as $index => $item) {
                $itemDetails[] = [
                    'id' => $item->product_id ?? $item->service_id ?? $index + 1,
                    'price' => (float) $item->price,
                    'quantity' => (int) $item->quantity,
                    'name' => $item->name,
                ];
            }

            // Prepare transaction
            $midtransData = [
                'transaction_details' => $transactionDetails,
                'customer_details' => $customerDetails,
                'item_details' => $itemDetails,
            ];

            // Get Snap transaction (token + redirect_url)
            log_message('error', 'MidtransService: Calling createSnapTransaction with data: ' . json_encode($midtransData));
            $snapTransaction = $this->midtransLibrary->createSnapTransaction($midtransData);

            if (!$snapTransaction || empty($snapTransaction['token'])) {
                log_message('error', 'MidtransService: snapTransaction result: ' . json_encode($snapTransaction));
                return [
                    'success' => false,
                    'message' => 'Failed to generate payment transaction. Please try again.'
                ];
            }

            $snapToken = $snapTransaction['token'];
            $redirectUrl = $snapTransaction['redirect_url'] ?? null;

            log_message('error', 'MidtransService: GOT TOKEN (' . strlen($snapToken) . ' chars), redirect_url: ' . ($redirectUrl ?? 'null'));

            // Save transaction record
            $transactionData = [
                'uuid' => $this->generateUuid(),
                'invoice_id' => $invoiceId,
                'order_id' => $order->id,
                'transaction_id' => $invoice->invoice_number,
                'midtrans_order_id' => $transactionDetails['order_id'],
                'gross_amount' => $transactionDetails['gross_amount'],
                'snap_token' => $snapToken,
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->table('midtrans_transactions')->insert($transactionData);

            // Update invoice status
            $this->db->table('invoices')
                ->where('id', $invoiceId)
                ->update(['status' => 'unpaid']);

            return [
                'success' => true,
                'message' => 'Payment initiated successfully.',
                'data' => [
                    'snap_token' => $snapToken,
                    'redirect_url' => $redirectUrl,
                    'invoice_uuid' => $invoice->uuid,
                    'order_id' => $order->id,
                ]
            ];

        } catch (\Throwable $e) {
            log_message('error', 'Midtrans payment initiation error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Payment processing failed. Please try again.'
            ];
        }
    }

    /**
     * Verify payment status from Midtrans
     */
    public function verifyPayment(string $orderId): array
    {
        try {
            // Find transaction
            $transaction = $this->db->table('midtrans_transactions')
                ->where('midtrans_order_id', $orderId)
                ->orWhere('transaction_id', $orderId)
                ->get()
                ->getRow();

            if (!$transaction) {
                return [
                    'success' => false,
                    'message' => 'Transaction not found.'
                ];
            }

            // Get payment status from Midtrans
            $paymentStatus = $this->midtransLibrary->verifyPayment($orderId);

            if (!$paymentStatus) {
                return [
                    'success' => false,
                    'message' => 'Unable to verify payment status.'
                ];
            }

            // Update transaction status
            $statusMap = [
                'capture' => 'success',
                'settlement' => 'success',
                'pending' => 'pending',
                'deny' => 'failed',
                'expire' => 'expired',
                'cancel' => 'cancelled',
            ];

            $newStatus = $statusMap[$paymentStatus['transaction_status'] ?? 'pending'] ?? 'pending';
            $paymentType = $paymentStatus['payment_type'] ?? '';

            $updateData = [
                'transaction_status' => $paymentStatus['transaction_status'] ?? null,
                'payment_type' => $paymentType,
                'status' => $newStatus,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->table('midtrans_transactions')
                ->where('midtrans_order_id', $orderId)
                ->update($updateData);

            // Update invoice & order status berdasarkan status transaksi
            $invoice = $this->db->table('invoices')
                ->where('invoice_number', $orderId)
                ->get()
                ->getRow();

            if ($invoice) {
                switch ($newStatus) {
                    case 'success':
                        $this->db->table('invoices')
                            ->where('id', $invoice->id)
                            ->update([
                                'status' => 'paid',
                                'paid_at' => date('Y-m-d H:i:s'),
                            ]);

                        $this->db->table('orders')
                            ->where('id', $invoice->order_id)
                            ->update([
                                'payment_status' => 'paid',
                                'status' => 'paid',
                            ]);
                        break;

                    case 'expired':
                        $this->db->table('invoices')
                            ->where('id', $invoice->id)
                            ->update([
                                'status' => 'expired',
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);

                        $this->db->table('orders')
                            ->where('id', $invoice->order_id)
                            ->update([
                                'payment_status' => 'failed',
                                'status' => 'expired',
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                        break;

                    case 'cancelled':
                        $this->db->table('invoices')
                            ->where('id', $invoice->id)
                            ->update([
                                'status' => 'cancelled',
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);

                        $this->db->table('orders')
                            ->where('id', $invoice->order_id)
                            ->update([
                                'payment_status' => 'failed',
                                'status' => 'cancelled',
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                        break;

                    case 'failed':
                        $this->db->table('invoices')
                            ->where('id', $invoice->id)
                            ->update([
                                'status' => 'failed',
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);

                        $this->db->table('orders')
                            ->where('id', $invoice->order_id)
                            ->update([
                                'payment_status' => 'failed',
                                'status' => 'cancelled',
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                        break;
                }
            }

            log_message('info', 'Midtrans verification: ' . $newStatus . ' for ' . $orderId);

            return [
                'success' => true,
                'message' => $newStatus === 'success' ? 'Payment verified successfully.' : 'Payment status: ' . $newStatus,
                'data' => [
                    'status' => $newStatus,
                    'order_id' => $orderId,
                ]
            ];

        } catch (\Throwable $e) {
            log_message('error', 'Midtrans payment verification error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Payment verification failed.'
            ];
        }
    }

    /**
     * Handle Midtrans webhook notification
     */
    public function handleWebhook(array $payload): array
    {
        try {
            $notification = $payload;

            // Get transaction data
            $transaction = $this->db->table('midtrans_transactions')
                ->where('transaction_id', $notification['transaction_id'] ?? '')
                ->orWhere('midtrans_order_id', $notification['order_id'] ?? '')
                ->get()
                ->getRow();

            if (!$transaction) {
                return [
                    'success' => false,
                    'message' => 'Transaction not found for webhook.'
                ];
            }

            // Save notification
            $this->db->table('midtrans_notifications')->insert([
                'uuid' => $this->generateUuid(),
                'transaction_id' => $notification['transaction_id'] ?? '',
                'notification_payload' => json_encode($notification),
                'signature_key' => $notification['signature_key'] ?? '',
                'status' => $notification['transaction_status'] ?? '',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            // Update transaction status
            $statusMap = [
                'capture' => 'success',
                'settlement' => 'success',
                'pending' => 'pending',
                'deny' => 'failed',
                'expire' => 'expired',
                'cancel' => 'cancelled',
            ];

            $newStatus = $statusMap[$notification['transaction_status'] ?? 'pending'] ?? 'pending';
            $paymentType = $notification['payment_type'] ?? '';

            $updateData = [
                'transaction_status' => $notification['transaction_status'] ?? null,
                'payment_type' => $paymentType,
                'status' => $newStatus,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->table('midtrans_transactions')
                ->where('id', $transaction->id)
                ->update($updateData);

            // Update invoice & order status berdasarkan status transaksi
            $invoice = $this->db->table('invoices')
                ->where('invoice_number', $notification['order_id'] ?? '')
                ->get()
                ->getRow();

            if ($invoice) {
                switch ($newStatus) {
                    case 'success':
                        $this->db->table('invoices')
                            ->where('id', $invoice->id)
                            ->update([
                                'status' => 'paid',
                                'paid_at' => date('Y-m-d H:i:s'),
                            ]);

                        $this->db->table('orders')
                            ->where('id', $invoice->order_id)
                            ->update([
                                'payment_status' => 'paid',
                                'status' => 'paid',
                            ]);
                        break;

                    case 'expired':
                        $this->db->table('invoices')
                            ->where('id', $invoice->id)
                            ->update([
                                'status' => 'expired',
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);

                        $this->db->table('orders')
                            ->where('id', $invoice->order_id)
                            ->update([
                                'payment_status' => 'failed',
                                'status' => 'expired',
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                        break;

                    case 'cancelled':
                        $this->db->table('invoices')
                            ->where('id', $invoice->id)
                            ->update([
                                'status' => 'cancelled',
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);

                        $this->db->table('orders')
                            ->where('id', $invoice->order_id)
                            ->update([
                                'payment_status' => 'failed',
                                'status' => 'cancelled',
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                        break;

                    case 'failed':
                        $this->db->table('invoices')
                            ->where('id', $invoice->id)
                            ->update([
                                'status' => 'failed',
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);

                        $this->db->table('orders')
                            ->where('id', $invoice->order_id)
                            ->update([
                                'payment_status' => 'failed',
                                'status' => 'cancelled',
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                        break;
                }
            }

            log_message('info', 'Midtrans webhook processed: ' . $newStatus . ' for ' . ($notification['order_id'] ?? 'unknown'));

            return [
                'success' => true,
                'message' => 'Webhook processed successfully.',
                'data' => ['status' => $newStatus]
            ];

        } catch (\Throwable $e) {
            log_message('error', 'Midtrans webhook error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Webhook processing failed.'
            ];
        }
    }

    /**
     * Generate UUID (Windows-compatible)
     */
    protected function generateUuid(): string
    {
        // Simple implementation dengan timestamp dan random number
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(100000, 999999)), 0, 8);
    }
}
