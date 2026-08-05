# NDS - System Architecture

**Version:** 2.0
**Date:** 2026-08-05
**Status:** Production Ready

---

## 1. Arsitektur

```
┌─────────────────────────────────────────────────────────────────┐
│                     PRESENTATION LAYER                          │
│  FrontArea (public)  │  ClientArea (customer)  │  AdminArea    │
│  Views + Layouts     │  Views + Layouts       │  Views+Layout  │
└──────────────────────────┬──────────────────────────────────────┘
                           │
┌──────────────────────────▼──────────────────────────────────────┐
│                    APPLICATION LAYER                            │
│  Controllers (FrontArea/ClientArea/AdminArea)                   │
│  Auth & Permission Filters                                      │
└──────────────────────────┬──────────────────────────────────────┘
                           │
┌──────────────────────────▼──────────────────────────────────────┐
│                      BUSINESS LAYER                             │
│  Services (Auth, Cart, Checkout, Payment, Invoice, Support...)  │
│  MidtransLibrary                                                │
└──────────────────────────┬──────────────────────────────────────┘
                           │
┌──────────────────────────▼──────────────────────────────────────┐
│                      DATA LAYER                                 │
│  Models  │  Query Builder  │  Migrations  │  Seeds             │
└──────────────────────────┬──────────────────────────────────────┘
                           │
┌──────────────────────────▼──────────────────────────────────────┐
│                  INFRASTRUCTURE LAYER                           │
│  Database (MariaDB)  │  Midtrans API  │  Email  │  Cache       │
└─────────────────────────────────────────────────────────────────┘
```

## 2. Alur Request

```
User → URL → Routes → Filter (auth/permission) → Controller
→ Service → Model → Database → Response → View → User
```

## 3. Area Modules

| Area | Route | Base Controller | Fungsi |
|------|-------|----------------|--------|
| Auth | /auth | FrontBaseController | Login, Register, Logout |
| FrontArea | / | FrontBaseController | Landing, Produk, Cart, Checkout, Payment |
| ClientArea | /client | ClientBaseController | Dashboard, Order, Invoice, Download, Support |
| AdminArea | /admin | AdminBaseController | CMS, Product, Order, Billing, Support |
| MitraArea | /mitra | MitraBaseController | (future) |
| Api | /api/v1 | - | REST API |

## 4. Layer Components

### FrontBaseController
- Load helpers (url, form, text, html)
- Optional auth check
- `render()`, `setActiveMenu()`, `setMeta()`, `redirectSuccess()`

### AdminBaseController
- Auth check (admin/super_admin)
- `render()`, `hasPermission()`, `setBreadcrumb()`

### ClientBaseController
- Auth check (customer/client)
- `render()`, `setActiveMenu()`, `redirectValidationError()`

### MitraBaseController
- Auth check (mitra/partner) - future

## 5. Arsitektur Rule

- Controller tidak boleh memiliki business logic
- Business logic wajib di Service
- Model hanya menangani database
- Database wajib menggunakan Migration
- Semua module harus modular (area-based)
- Semua fitur harus memiliki dokumentasi

## 6. Security

- Session: FileHandler
- CSRF Protection
- Password: Bcrypt
- RBAC (Roles & Permissions)
- Auth Filter & Permission Filter
- Midtrans Secret Key di .env

## 7. Integrasi

| Integrasi | Library | Status |
|-----------|---------|--------|
| Midtrans Snap | MidtransLibrary | ✅ Active |
| DomPDF | dompdf/dompdf | ✅ Active |
| Email (SMTP) | CodeIgniter Email | 🟡 Config |
| Cache (Redis) | RedisHandler | 🟡 Config |
