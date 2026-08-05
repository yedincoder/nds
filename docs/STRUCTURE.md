# NDS - Struktur Folder

**Version:** 2.0
**Date:** 2026-08-05

---

## 🗂️ Struktur Area-Based

Setiap area memiliki template lengkap:
`Config, Controllers, Database/Migrations, Database/Seeds, Helpers, Language, Libraries, Models, Routes, Services, Views`

```
app/
├── Controllers/
│   ├── BaseController.php          # CI Default
│   ├── HomeController.php          # CI Default
│   ├── FrontBaseController.php     # Base FrontArea
│   ├── AdminBaseController.php     # Base AdminArea
│   ├── ClientBaseController.php    # Base ClientArea
│   ├── MitraBaseController.php     # Base MitraArea (future)
│   └── Api/                        # API Controllers
│       ├── AuthApiController.php
│       ├── ProductApiController.php
│       ├── ServiceApiController.php
│       ├── OrderApiController.php
│       └── ...
│
├── Modules/
│   ├── Auth/                       # Autentikasi
│   │   ├── Controllers/AuthController.php
│   │   ├── Models/UserModel.php
│   │   ├── Services/AuthService.php
│   │   └── Database/Migrations/2026-08-02-000001_CreateUsersTable.php
│   │
│   ├── FrontArea/                  # Frontend publik
│   │   ├── Controllers/
│   │   │   ├── ProductsController.php
│   │   │   ├── ProductController.php
│   │   │   ├── ServiceController.php
│   │   │   ├── BlogController.php
│   │   │   ├── PortfolioController.php
│   │   │   ├── ArticleController.php
│   │   │   ├── PageController.php
│   │   │   ├── CartController.php
│   │   │   ├── CheckoutController.php
│   │   │   ├── PaymentController.php
│   │   │   ├── InvoiceController.php
│   │   │   ├── BillingController.php
│   │   │   └── MidtransController.php
│   │   ├── Models/                 # Product, Service, CMS, Cart, Order, Invoice, Payment, Billing
│   │   ├── Services/               # ProductService, CartService, CheckoutService, dll
│   │   ├── Libraries/MidtransLibrary.php
│   │   └── Database/Migrations/    # CreateProduct, CreateCMS, CreateEcommerce, dll
│   │
│   ├── ClientArea/                 # Dashboard customer
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php
│   │   │   ├── DownloadController.php
│   │   │   ├── OrderController.php
│   │   │   ├── ProfileController.php
│   │   │   └── SupportController.php
│   │   ├── Models/                 # CustomerAddressModel, UserProfileModel
│   │   ├── Services/CustomerService.php
│   │   └── Database/Migrations/
│   │
│   ├── AdminArea/                  # Panel admin
│   │   ├── Controllers/
│   │   │   ├── AdminDashboardController.php
│   │   │   ├── CMSDashboardController.php
│   │   │   ├── MediaController.php
│   │   │   ├── TestimonialController.php
│   │   │   └── TicketController.php
│   │   ├── Models/                 # TicketModel, TestimonialModel
│   │   ├── Services/SupportService.php
│   │   └── Database/Migrations/
│   │
│   ├── Api/                        # API module
│   └── MitraArea/                  # Mitra (future)
│
└── Views/
    ├── Layout/
    │   ├── layout_frontarea.php    # Frontend public
    │   ├── layout_adminarea.php    # Admin panel
    │   ├── layout_clientarea.php   # Client dashboard
    │   └── layout_mitraarea.php    # Mitra panel (future)
    ├── Auth/                       # login, register
    ├── FrontArea/                  # home, products, services, blog, contact
    ├── AdminArea/                  # dashboard, cms
    ├── ClientArea/                 # dashboard, orders, invoices, downloads, tickets, profile
    ├── Api/                        # (future)
    └── errors/
```

## 📄 Struktur Template Area

Setiap area (Auth, FrontArea, ClientArea, AdminArea, MitraArea) memiliki:

```
AreaName/
├── Config/            # Konfigurasi spesifik area
├── Controllers/       # Controller area
├── Database/
│   ├── Migrations/    # Migration area
│   └── Seeds/         # Seeder area
├── Helpers/           # Helper fungsi area
├── Language/          # File language area
├── Libraries/         # Library spesifik area
├── Models/            # Model area
├── Routes/            # Route modular area
├── Services/          # Business logic area
└── Views/             # View area
```

## 🎯 Mapping Modul Lama → Area Baru

| Modul Lama | Area Baru |
|-----------|-----------|
| Authentication | Auth |
| Product, Service, Blog, Portfolio, CMS, Cart, Checkout, Payment, Invoice, Billing, Midtrans, Notification, Order | FrontArea |
| Customer | ClientArea |
| Dashboard, MediaManager, Support, Testimonial | AdminArea |
| API | Api |

## ⚙️ Autoload Namespace

```php
// app/Config/Autoload.php
public $psr4 = [
    APP_NAMESPACE => APPPATH,
    'Modules' => APPPATH . 'Modules',
    'Config' => APPPATH . 'Config',
];

// Contoh namespace:
// App\Modules\FrontArea\Controllers\ProductsController
// App\Modules\Auth\Controllers\AuthController
// App\Modules\AdminArea\Controllers\AdminDashboardController
```
