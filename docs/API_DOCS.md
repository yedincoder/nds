# NDS - API Documentation

**Version:** 1.0
**Base URL:** `https://skirmish-slighting-nicotine.ngrok-free.dev/api/v1`
**Auth:** Bearer Token (API Key) / Session Cookie

---

## 🔐 Authentication

### Login
```http
POST /api/v1/auth/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password123"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "user": {
      "id": 1,
      "username": "johndoe",
      "email": "john@example.com",
      "role": "customer"
    }
  }
}
```

---

### Register
```http
POST /api/v1/auth/register
Content-Type: application/json

{
  "full_name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirm": "password123"
}
```

---

### Logout
```http
POST /api/v1/auth/logout
Authorization: Bearer {token}
```

---

### Profile
```http
GET /api/v1/profile
Authorization: Bearer {token}
```

---

## 🛍️ Products

### List Products
```http
GET /api/v1/products?page=1&per_page=12&category=web-app&search=laravel
```

Query params:
- `page` (int): Page number (default 1)
- `per_page` (int): Items per page (default 12, max 50)
- `category` (string): Category slug
- `search` (string): Search keyword
- `sort` (string): `price_asc`, `price_desc`, `newest`, `popular`

**Response:**
```json
{
  "success": true,
  "data": {
    "products": [
      {
        "id": 1,
        "name": "Web App Starter Pack",
        "slug": "web-app-starter-pack",
        "short_description": "Starter kit untuk web app modern",
        "thumbnail": "https://cdn.ngappid.com/products/web-app-starter.jpg",
        "price": 5000000,
        "discount_price": 3500000,
        "category": {
          "id": 1,
          "name": "Web Application",
          "slug": "web-app"
        },
        "rating": 4.8,
        "sales_count": 156
      }
    ],
    "meta": {
      "current_page": 1,
      "per_page": 12,
      "total": 15,
      "last_page": 2
    }
  }
}
```

### Product Detail
```http
GET /api/v1/products/{slug}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Web App Starter Pack",
    "slug": "web-app-starter-pack",
    "description": "<p>Full description...</p>",
    "short_description": "Starter kit untuk web app modern",
    "thumbnail": "https://cdn.ngappid.com/products/web-app-starter.jpg",
    "price": 5000000,
    "discount_price": 3500000,
    "category": {
      "id": 1,
      "name": "Web Application",
      "slug": "web-app"
    },
    "tags": [
      {"id": 1, "name": "Laravel", "slug": "laravel"},
      {"id": 2, "name": "Vue.js", "slug": "vuejs"}
    ],
    "files": [
      {
        "id": 1,
        "name": "source-code.zip",
        "size": 5242880,
        "download_url": "https://ngappid.com/api/v1/download/abc123"
      }
    ]
  }
}
```

---

## 🛒 Cart

### Get Cart
```http
GET /api/v1/cart
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "items": [
      {
        "id": 1,
        "product": {
          "id": 1,
          "name": "Web App Starter Pack",
          "slug": "web-app-starter-pack",
          "price": 5000000,
          "discount_price": 3500000,
          "thumbnail": "https://cdn.ngappid.com/..."
        },
        "quantity": 2,
        "subtotal": 7000000
      }
    ],
    "summary": {
      "subtotal": 7000000,
      "discount": 0,
      "tax": 0,
      "total": 7000000
    }
  }
}
```

### Add to Cart
```http
POST /api/v1/cart/add
Authorization: Bearer {token}
Content-Type: application/json

{
  "product_id": 1,
  "quantity": 2
}
```

### Update Cart Item
```http
PUT /api/v1/cart/update/{item_id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "quantity": 3
}
```

### Remove from Cart
```http
DELETE /api/v1/cart/remove/{item_id}
Authorization: Bearer {token}
```

### Clear Cart
```http
DELETE /api/v1/cart/clear
Authorization: Bearer {token}
```

---

## 💳 Checkout

### Process Checkout
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

## 📦 Orders

### List Orders
```http
GET /api/v1/orders?page=1&per_page=10&status=paid
Authorization: Bearer {token}
```

### Order Detail
```http
GET /api/v1/orders/{uuid}
Authorization: Bearer {token}
```

### Cancel Order
```http
POST /api/v1/orders/{uuid}/cancel
Authorization: Bearer {token}
```

---

## 📄 Invoices

### List Invoices
```http
GET /api/v1/invoices?page=1&status=unpaid
Authorization: Bearer {token}
```

### Invoice Detail
```http
GET /api/v1/invoices/{uuid}
Authorization: Bearer {token}
```

### Download Invoice PDF
```http
GET /api/v1/invoices/{uuid}/download
Authorization: Bearer {token}
```

---

## 💳 Payments (Midtrans)

### Get Payment Methods
```http
GET /api/v1/payment/methods
Authorization: Bearer {token}
```

### Create Payment
```http
POST /api/v1/payment/process
Authorization: Bearer {token}
Content-Type: application/json

{
  "invoice_uuid": "abc123-def456",
  "payment_method_id": "gopay"
}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "payment_url": "https://app.sandbox.midtrans.com/snap/v4/redirection/abc123...",
    "token": "abc123-def456-7890",
    "expired_at": "2026-08-06 14:30:00"
  }
}
```

---

## 📥 Downloads

### List Downloads
```http
GET /api/v1/downloads
Authorization: Bearer {token}
```

### Download File
```http
GET /api/v1/downloads/{token}
Authorization: Bearer {token}
```

---

## 🎫 Support Tickets

### List Tickets
```http
GET /api/v1/tickets?page=1&status=open
Authorization: Bearer {token}
```

### Create Ticket
```http
POST /api/v1/tickets
Authorization: Bearer {token}
Content-Type: application/json

{
  "category_id": 1,
  "subject": "Tidak bisa login",
  "message": "Saya tidak bisa login ke dashboard...",
  "priority": "high"
}
```

### Ticket Detail
```http
GET /api/v1/tickets/{uuid}
Authorization: Bearer {token}
```

### Reply Ticket
```http
POST /api/v1/tickets/{uuid}/reply
Authorization: Bearer {token}
Content-Type: application/json

{
  "message": "Sudah saya coba reset password tapi tetap tidak bisa"
}
```

### Close Ticket
```http
POST /api/v1/tickets/{uuid}/close
Authorization: Bearer {token}
Content-Type: application/json

{
  "resolution": "Password sudah direset, silakan coba login ulang"
}
```

---

## 🔔 Notifications

### List Notifications
```http
GET /api/v1/notifications?unread_only=true
Authorization: Bearer {token}
```

### Mark as Read
```http
POST /api/v1/notifications/{id}/read
Authorization: Bearer {token}
```

---

## 🛡️ Error Responses

### 400 Bad Request
```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "email": "Email harus valid",
    "password": "Password minimal 8 karakter"
  }
}
```

### 401 Unauthorized
```json
{
  "success": false,
  "message": "Unauthorized. Token tidak valid atau expired."
}
```

### 403 Forbidden
```json
{
  "success": false,
  "message": "Akses ditolak. Anda tidak memiliki akses ke resource ini."
}
```

### 404 Not Found
```json
{
  "success": false,
  "message": "Resource tidak ditemukan"
}
```

### 422 Unprocessable Entity
```json
{
  "success": false,
  "message": "Data tidak valid",
  "errors": {
    "email": "Email sudah terdaftar",
    "password": "Password minimal 8 karakter"
  }
}
```

### 500 Internal Server Error
```json
{
  "success": false,
  "message": "Terjadi kesalahan server. Silakan coba lagi nanti."
}
```

---

## 📋 Rate Limiting

| Endpoint | Limit |
|----------|-------|
| Auth (login/register) | 5 req/min |
| API (authenticated) | 60 req/min |
| Payment/Checkout | 10 req/min |
| File Upload | 5 req/min |

Headers:
```
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
X-RateLimit-Reset: 1691234567
```

---

## 📝 Webhooks

### Midtrans Payment Notification
```http
POST /midtrans/notification
Content-Type: application/json

{
  "transaction_status": "settlement",
  "order_id": "ORD-20260805-ABC123",
  "transaction_status": "settlement",
  "fraud_status": "accept",
  "signature_key": "sha512_hash..."
}
```

---

## 📚 SDK / Client Library

### PHP (Coming Soon)
```php
$client = new NgAppID\Client('your-api-key');
$products = $client->products()->list(['category' => 'web-app']);
$order = $client->checkout()->process([
    'items' => [['product_id' => 1, 'quantity' => 2]],
    'billing' => ['name' => 'John', 'email' => 'john@example.com']
]);
```

### JavaScript (Coming Soon)
```javascript
const client = new NgAppIDClient({ apiKey: 'your-key' });
const products = await client.products.list({ category: 'web-app' });
const order = await client.checkout.process({
  items: [{ product_id: 1, quantity: 2 }],
  billing: { name: 'John', email: 'john@example.com' }
);
```

---

## 📞 Support

- **Email:** api-support@ngappid.com
- **Documentation:** https://docs.ngappid.com
- **Status Page:** https://status.ngappid.com

---

**Last Updated:** 2026-08-05
**API Version:** v1.0.0