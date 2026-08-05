# NDS - Changelog

**Versi terakhir:** 2.0.0  
**Tanggal:** 2026-08-05

---

## v2.0.0 (2026-08-05) - Restrukturisasi Area-Based

### 🏗️ Arsitektur
- ✅ Restrukturisasi `app/Modules` menjadi area-based:
  - `Auth`, `Api`, `AdminArea`, `ClientArea`, `FrontArea`, `MitraArea`
- ✅ Setiap area memiliki template lengkap:
  - Config, Controllers, Database/Migrations, Database/Seeds, Helpers, Language, Libraries, Models, Routes, Services, Views
- ✅ Hapus 22 modul feature lama (Product, Service, Cart, Payment, dll)
- ✅ Buat Base Controllers:
  - `FrontBaseController`, `AdminBaseController`, `ClientBaseController`, `MitraBaseController`
- ✅ Buat Layout files:
  - `layout_frontarea.php`, `layout_adminarea.php`, `layout_clientarea.php`, `layout_mitraarea.php`

### 🗂️ Pindahan Modul
| Modul Lama | Area Baru |
|-----------|-----------|
| Authentication | Auth |
| Product, Service, Blog, Portfolio, CMS | FrontArea |
| Cart, Checkout, Payment, Invoice, Billing | FrontArea |
| Midtrans, Notification, Order | FrontArea |
| Customer | ClientArea |
| Dashboard, MediaManager, Support, Testimonial | AdminArea |

### 🐛 Perbaikan
- ✅ CSRF protection untuk payment & support routes
- ✅ UUID generation Windows-compatible
- ✅ PDF Invoice (DomPDF)
- ✅ Contact form POST handler
- ✅ Blog detail & category
- ✅ Portfolio detail
- ✅ Client Area orders & downloads
- ✅ Support ticket create/reply/close
- ✅ Route deduplication & syntax fix

---

## v1.x (2026-08-04) - Payment Integration

### 🎯 Fitur Baru
- ✅ Midtrans Snap integration
- ✅ Payment methods: QRIS, VA, Bank, E-Wallet, CStore
- ✅ Webhook handler (success, pending, expired, cancelled, failed)
- ✅ Auto-fill billing data untuk logged-in user
- ✅ Dynamic nav menu (Login → Client Area)

### 🔧 Teknis
- ✅ DomPDF untuk invoice PDF
- ✅ Helper: format_price, format_date
- ✅ Tax & discount dari database (product_prices)
- ✅ Auto-generate UUID Windows-compatible

---

## v1.0 (2026-08-02) - Initial Release

### 🏗️ Foundation
- ✅ CodeIgniter 4.7.4 setup
- ✅ Adminator theme
- ✅ Database migrations (±45 tabel)
- ✅ Role & Permission system
- ✅ Authentication (login, register)
- ✅ Admin dashboard
- ✅ Client area
