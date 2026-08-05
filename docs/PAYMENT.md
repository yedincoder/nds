# NDS - Payment Integration (Midtrans)

**Version:** 2.0
**Date:** 2026-08-05
**Status:** Production Ready

---

## 🏗️ Arsitektur

```
Frontend (Snap.js) ⇄ Backend ⇄ Midtrans API
                         │
                         ▼
                   Webhook → Update Status
```

## 🧩 Komponen

| File | Lokasi | Fungsi |
|------|--------|--------|
| MidtransLibrary | `app/Modules/FrontArea/Libraries/` | API wrapper (Snap, Status) |
| MidtransService | `app/Modules/FrontArea/Services/` | Business logic (initiate, verify, webhook) |
| MidtransController | `app/Modules/FrontArea/Controllers/` | HTTP endpoints |
| PaymentController | `app/Modules/FrontArea/Controllers/` | Payment flow |

---

## ⚙️ Konfigurasi (.env)

```env
MIDTRANS_MERCHANT_ID = G404327453
MIDTRANS_SERVER_KEY = SB-Mid-server-xxxxxxxx
MIDTRANS_CLIENT_KEY = SB-Mid-client-xxxxxxx
MIDTRANS_IS_PRODUCTION = false
```

---

## 🔄 Alur

1. User checkout → order + invoice dibuat
2. Payment page → initiate payment → snap token
3. User bayar di Midtrans Snap
4. Midtrans kirim webhook → update status
5. Redirect ke success/pending/failed page

---

## 🔗 Endpoints

| Method | URL | Fungsi |
|--------|-----|--------|
| GET | `/payment/{invoice}` | Halaman pilih metode |
| POST | `/payment/{invoice}` | Initiate payment |
| POST | `/midtrans/notification` | Webhook |
| GET | `/midtrans/success` | Halaman sukses |
| GET | `/midtrans/pending` | Halaman pending |
| GET | `/midtrans/error` | Halaman error |

---

## 📊 Status Mapping

| Midtrans | System |
|----------|--------|
| settlement/capture | paid |
| pending | waiting_payment |
| deny/cancel | cancelled |
| expire | expired |

---

## 🔒 Keamanan

- Verify signature webhook
- Server key hanya di `.env`
- SSL verification sandbox (Windows dev)
- CSRF untuk form payment
- Ownership check invoice
