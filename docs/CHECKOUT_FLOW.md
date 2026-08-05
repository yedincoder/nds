# Checkout Flow Documentation

**Version:** 1.0
**Date:** 2026-08-05

---

## 🛒 Alur Checkout Lengkap

```
User → Cart → Checkout → Payment → Midtrans → Webhook → Order Created → Email/Notif
```

---

## 1. Add to Cart

```http
POST /api/v1/cart/add
Authorization: Bearer {token}
Content-Type: application/json

{
  "product_id": 1,
  "quantity": 2
}
```

**Response:**
```json
{
  "success": true,
  "message": "Produk ditambahkan ke keranjang",
  "data": {
    "cart_count": 2,
    "subtotal": 7000000
  }
}
```

---

## 2. View Cart

```http
GET /cart
Authorization: Bearer {token}
```

---

## 3. Update / Remove Cart Item

```http
PUT /api/v1/cart/update/{item_id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "quantity": 3
}
```

```http
DELETE /api/v1/cart/remove/{item_id}
Authorization: Bearer {token}
```

---

## 4. Checkout Process

### Step 1: Submit Checkout Form
```http
POST /api/v1/checkout/process
Authorization: Bearer {token}
Content-Type: application/json

{
  "billing_name": "John Doe",
  "billing_email": "john@example.com",
  "billing_phone": "081234567890",
  "billing_address": "Jl. Sudirman No. 123",
  "billing_city": "Jakarta",
  "billing_province": "DKI Jakarta",
  "billing_postal_code": "10220",
  "notes": "Catatan tambahan"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Checkout berhasil. Silakan lanjutkan pembayaran.",
  "data": {
    "order_id": 123,
    "order_number": "ORD-20260805-ABC123",
    "invoice_uuid": "abc123-def456-7890",
    "total": 3500000,
    "payment_url": "https://app.sandbox.midtrans.com/snap/v4/redirection/abc123..."
  }
}
```

---

## 2. Payment (Midtrans Snap)

### Client Side (Frontend)
```javascript
// Response dari checkout di atas
const snap_token = response.data.payment_url; // atau token dari Midtrans

// Initialize Snap
snap.pay(snap_token, {
  onSuccess: function(result) {
    console.log('Payment success:', result);
    window.location.href = '/checkout/success/' + orderId;
  },
  onPending: function(result) {
    console.log('Payment pending:', result);
    window.location.href = '/checkout/pending/' + orderId;
  },
  onError: function(result) {
    console.log('Payment error:', result);
    window.location.href = '/checkout/failed/' + orderId;
  },
  onClose: function() {
    console.log('User closed popup');
    window.location.href = '/cart';
  }
});
```

---

## 4. Midtrans Webhook (Server-to-Server)

### Endpoint: `POST /midtrans/notification`

```http
POST /midtrans/notification
Content-Type: application/json

{
  "transaction_status": "settlement",
  "order_id": "ORD-20260805-ABC123",
  "payment_type": "gopay",
  "transaction_status": "settlement",
  "fraud_status": "accept",
  "signature_key": "sha512_hash..."
}
```

### Handler Flow (MidtransService::handleWebhook)

```php
public function handleWebhook(array $payload): array
{
    $orderId = $payload['order_id'];
    $transactionStatus = $payload['transaction_status'];
    $fraudStatus = $payload['fraud_status'] ?? 'accept';
    
    // Verify signature
    if (!$this->verifySignature($payload)) {
        return ['success' => false, 'message' => 'Invalid signature'];
    }

    // Update transaction
    $this->db->table('transactions')
        ->where('order_id', $orderId)
        ->update([
            'transaction_status' => $transactionStatus,
            'payment_type' => $payload['payment_type'] ?? null,
            'fraud_status' => $fraudStatus,
            'payment_response' => json_encode($payload),
            'paid_at' => date('Y-m-d H:i:s'),
        ]);

    // Update invoice & order status
    if (in_array($transactionStatus, ['settlement', 'capture'])) {
        $this->updateInvoiceStatus($orderId, 'paid');
        $this->updateOrderStatus($orderId, 'paid');
        $this->sendPaymentSuccessEmail($orderId);
        
        // Update download records (if digital product)
        $this->createDownloadRecords($orderId);
    }
    
    if ($transactionStatus === 'cancel' || $transactionStatus === 'deny' || $transactionStatus === 'expire') {
        $this->updateOrderStatus($orderId, 'cancelled');
    }
    
    return ['success' => true];
}
```

---

## 4. Status Mapping Midtrans → System

| Midtrans Status | System Invoice Status | System Order Status |
|----------------|----------------------|---------------------|
| `pending` | `unpaid` | `waiting_payment` |
| `settlement` / `capture` | `paid` | `paid` |
| `pending` | `unpaid` | `waiting_payment` |
| `deny` | `failed` | `cancelled` |
| `cancel` | `cancelled` | `cancelled` |
| `expire` | `expired` | `expired` |
| `deny` | `failed` | `cancelled` |

---

## 5. Frontend Integration (React/Vue/Vanilla JS)

### Install Midtrans Client
```bash
npm install midtrans-client
```

```javascript
import MidtransClient from 'midtrans-client';

const snap = new MidtransClient.Snap({
  isProduction: false,
  clientKey: 'SB-Mid-client-xxxxxxxx',
});

async function handlePayment(orderId) {
  try {
    const response = await fetch('/api/v1/checkout/process', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        billing_name: 'John Doe',
        billing_email: 'john@example.com',
        billing_phone: '081234567890',
        billing_address: 'Jl. Sudirman No. 123',
        billing_city: 'Jakarta',
        billing_province: 'DKI Jakarta',
        billing_postal_code: '10220',
      }
    });
    
    const result = await response.json();
    
    if (result.success && result.data.payment_url) {
      // Redirect to Midtrans
      window.location.href = result.data.payment_url;
    } else {
      // Handle Snap Token
      if (result.data.snap_token) {
        window.snap.pay(result.data.snap_token, {
          onSuccess: (result) => {
            window.location.href = `/checkout/success/${orderId}`;
          },
          onPending: (result) => {
            window.location.href = `/checkout/pending/${orderId}`;
          },
          onError: (result) => {
            window.location.href = `/checkout/failed/${orderId}`;
          }
        });
      }
    }
  } catch (error) {
    console.error('Payment error:', error);
    alert('Pembayaran gagal: ' + error.message);
  }
}
```

---

## 5. Webhook Endpoint (Server)

### Route
```php
$routes->post('midtrans/notification', '\App\Modules\Midtrans\Controllers\MidtransController::notification');
```

### Controller
```php
public function notification(): ResponseInterface
{
    try {
        $json = $this->request->getJSON(true);
        
        if (!$json) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Invalid JSON'
            ]);
        }
        
        $result = $this->midtransService->handleWebhook($json);
        
        return $this->response->setJSON($result);
    } catch (\Throwable $e) {
        log_message('error', 'Midtrans webhook error: ' . $e->getMessage());
        return $this->response->setStatusCode(500)->setJSON([
            'success' => false,
            'message' => 'Webhook processing failed'
        ]);
    }
}
```

---

## 🔒 Security

1. **Verify Signature** - Selalu verifikasi `signature_key` dari Midtrans
2. **HTTPS Only** - Production harus HTTPS
3. **Idempotency** - Handle duplicate webhook
4. **Timeout** - Timeout webhook 30 detik

```php
private function verifySignature(array $payload): bool
{
    $serverKey = getenv('MIDTRANS_SERVER_KEY');
    $signatureKey = $payload['signature_key'] ?? '';
    
    $rawString = $payload['order_id'] . $payload['status_code'] . 
                 $payload['gross_amount'] . $serverKey;
    
    $expectedSignature = hash('sha512', $rawString);
    
    return hash_equals($expectedSignature, $signatureKey);
}
```

---

## 🧪 Testing (Sandbox)

1. Gunakan **Sandbox Credentials** dari Midtrans Dashboard
2. Test dengan kartu simulasi:
   - **Success**: 4811 1111 1111 1114 (Visa)
   - **Pending**: 4811 1111 1111 1115
   - **Failed**: 4811 1111 1111 1116
3. Test webhook dengan **ngrok** untuk local development:
   ```bash
   ngrok http 8080
   # Set notification URL di Midtrans: https://xxx.ngrok.io/midtrans/notification
   ```

---

## 📝 Checklist Production

- [ ] Server Key & Client Key Production
- [ ] Webhook URL production
- [ ] HTTPS enforced
- [ ] SSL certificate valid
- [ ] Webhook timeout 30s
- [ ] Idempotency check (duplicate webhook handling)
- [ ] Error logging & monitoring
- [ ] Test semua status pembayaran