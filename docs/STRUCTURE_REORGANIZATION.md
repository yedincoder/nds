# NDS - NgAppID Digital Platform
## Struktur Folder Reorganisasi

**Version:** 1.1  
**Date:** 2026-08-05  
**Status:** Partial Restructure

---

## 🏗️ Struktur Baru

```
app/
├── Controllers/                          # Base Controllers
│   ├── Api/                              # API Controllers (existing)
│   ├── BaseController.php                # CI Default (tidak diubah)
│   ├── HomeController.php                # CI Default (tidak diubah)
│   ├── FrontBaseController.php           # Base untuk FrontArea
│   ├── AdminBaseController.php           # Base untuk AdminArea
│   ├── ClientBaseController.php          # Base untuk ClientArea
│   └── MitraBaseController.php           # Base untuk MitraArea (future)
│
├── Modules/
│   ├── Auth/                             # Autentikasi (rename dari Authentication)
│   │   └── Controllers/
│   │       └── AuthController.php
│   ├── Api/                              # API module
│   ├── AdminArea/                        # Area Admin
│   │   └── Controllers/                  # (sedang dibangun)
│   ├── ClientArea/                       # Area Client (existing)
│   │   └── Controllers/
│   │       ├── DashboardController.php
│   │       ├── DownloadController.php
│   │       ├── OrderController.php
│   │       ├── ProfileController.php
│   │       └── SupportController.php
│   ├── FrontArea/                        # Area Frontend
│   │   └── Controllers/
│   │       └── ProductsController.php
│   ├── MitraArea/                        # Area Mitra (future)
│   │   └── Controllers/                  # (placeholder)
│   └── [feature modules tetap ada]       # Cart, Checkout, Payment, dll
│       └── Models/, Services/            # dipakai oleh area controllers
│
└── Views/
    ├── Layout/
    │   ├── layout_frontarea.php          # Layout frontend (copy master.php)
    │   ├── layout_adminarea.php          # Layout admin baru
    │   ├── layout_clientarea.php         # Layout client (copy lama)
    │   └── layout_mitraarea.php          # Layout mitra (future)
    ├── Auth/                             # View auth (login, register)
    ├── FrontArea/
    │   ├── home/
    │   ├── products/
    │   │   ├── index.php
    │   │   └── detail.php
    │   ├── services/
    │   └── contact/
    ├── AdminArea/
    │   └── dashboard/
    ├── ClientArea/                       # View client (existing)
    ├── Api/                              # View API (future)
    ├── MitraArea/                        # (future)
    │   └── dashboard/
    └── errors/                           # View errors
```

---

## 🎯 Base Controllers

### 1. `BaseController.php` (CI Default)
- Tidak diubah, biarkan sebagai default bawaan CI
- Semua controller extend dari sini

### 2. `HomeController.php` (CI Default)
- Tetap di app/Controllers
- Landing page utama

### 3. `FrontBaseController.php`
**Untuk:** FrontArea controllers (public pages)
```php
namespace App\Controllers;

abstract class FrontBaseController extends BaseController
{
    protected $user;
    protected $isLoggedIn = false;
    
    // Load helpers (url, form, text, html)
    // Check authentication (optional)
    // Load common data: appName, meta, breadcrumb
    // Method: setActiveMenu(), setMeta(), render(), redirectSuccess()
}
```

### 4. `AdminBaseController.php`
**Untuk:** AdminArea controllers
```php
namespace App\Controllers;

abstract class AdminBaseController extends BaseController
{
    protected $user;
    protected $isAdmin = false;
    
    // Load helpers (url, form)
    // Check authentication (admin/super_admin role)
    // Method: setActiveMenu(), setBreadcrumb(), render(), hasPermission()
}
```

### 5. `ClientBaseController.php`
**Untuk:** ClientArea controllers
```php
namespace App\Controllers;

abstract class ClientBaseController extends BaseController
{
    protected $user;
    protected $clientProfile;
    
    // Check authentication (customer/client role)
    // Method: setActiveMenu(), render(), redirectSuccess()
}
```

### 6. `MitraBaseController.php`
**Untuk:** MitraArea (pengembangan masa depan)
```php
namespace App\Controllers;

abstract class MitraBaseController extends BaseController
{
    protected $user;
    protected $mitraProfile;
    
    // Check authentication (mitra/partner role)
    // Method: setActiveMenu(), render()
}
```

---

## 🗂️ Area Modules

### 1. **Auth** (rename dari Authentication)
- `Modules/Auth/Controllers/AuthController.php`
- Login, Register, Logout
- Routes: `/auth/login`, `/auth/register`, `/auth/logout`

### 2. **FrontArea** (public-facing)
- `Modules/FrontArea/Controllers/`
- **ProductsController**: index, detail, category, search
- **Next**: Services, Blog, Portfolio, Contact, Home

### 3. **ClientArea** (customer dashboard)
- `Modules/ClientArea/Controllers/`
- **DashboardController**: dashboard, orders, invoices, downloads
- **DownloadController**: file download
- **OrderController**: order detail
- **ProfileController**: profile management
- **SupportController**: support tickets

### 4. **AdminArea** (admin panel)
- `Modules/AdminArea/Controllers/` (sedang dibangun)
- **Next**: Dashboard, CMS, Products, Orders, dll

### 5. **MitraArea** (future)
- `Modules/MitraArea/Controllers/` (placeholder)

### 6. **Api**
- `Modules/Api/` (existing)

---

## 🖥️ Layout Files

| Layout | Path | Fungsi |
|--------|------|--------|
| `layout_frontarea.php` | `Views/Layout/` | Frontend public pages |
| `layout_adminarea.php` | `Views/Layout/` | Admin panel |
| `layout_clientarea.php` | `Views/Layout/` | Client dashboard |
| `layout_mitraarea.php` | `Views/Layout/` | Mitra panel (future) |

---

## 🔄 Routes yang Diupdate

```php
// PRODUCT (FrontArea)
$routes->get('products', '\App\Modules\FrontArea\Controllers\ProductsController::index');
$routes->get('product/category/(:any)', '\App\Modules\FrontArea\Controllers\ProductsController::category/$1');
$routes->get('product/search', '\App\Modules\FrontArea\Controllers\ProductsController::search');
$routes->get('product/(:any)', '\App\Modules\FrontArea\Controllers\ProductsController::detail/$1');

// AUTH
$routes->group('auth', function ($routes) {
    $routes->get('login', '\App\Modules\Auth\Controllers\AuthController::showLogin');
    // ...
});
```

---

## 📊 Status Restrukturisasi

| Komponen | Status |
|----------|--------|
| Base Controllers | ✅ Selesai (5 controller) |
| Auth module | ✅ Controller dipindah ke Modules/Auth |
| FrontArea Products | ✅ Controller + Views dibuat |
| Layout files | ✅ 4 layout dibuat |
| Views struktur | 🔄 Partial (FrontArea products selesai) |
| AdminArea | 🔄 Struktur dibuat, controller menyusul |
| MitraArea | ✅ Placeholder dibuat |
| Routes | ✅ Product & Auth diupdate |
| Docs | ✅ Ini |

---

## 🧪 Test URL

```
https://skirmish-slighting-nicotine.ngrok-free.dev/products
https://skirmish-slighting-nicotine.ngrok-free.dev/product/{slug}
https://skirmish-slighting-nicotine.ngrok-free.dev/auth/login
```

---

## 📌 Catatan

1. Feature modules (Cart, Checkout, Payment, dll) **tetap ada** karena Models/Services dipakai banyak controller
2. Migrasi bertahap: FrontArea → ClientArea → AdminArea
3. Nama folder area menggunakan **CamelCase** (FrontArea, AdminArea)
4. Views menggunakan **Layout/** folder untuk layout terpusat
5. HomeController & BaseController tetap di app/Controllers untuk kompatibilitas update CI

---

**Dokumen terakhir update: 2026-08-05**  
**Status: Partial Restructure - lanjut bertahap**