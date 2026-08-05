# NgAppID Digital Platform (NDS)

Platform digital modern untuk **PT. YEDIN DIGITAL MANDIRI** (NgAppID Digital) — mencakup pengembangan aplikasi, penjualan produk digital, sistem billing, dan dukungan pelanggan terintegrasi.

---

## 🧱 Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Framework | CodeIgniter 4.7.4 |
| Language | PHP 8.3 |
| Database | MySQL / MariaDB (port 3307) |
| Admin Theme | Adminator Free (orange) |
| Text Editor | CKEditor 5 Classic |
| Chart | Chart.js |
| Payment | Midtrans (Snap) |

---

## 📦 Fitur

### FrontArea `/`
- Home, About, Services, Products, Portfolio, Blog, Contact
- Semua data dinamis dari database
- Add to Cart → Checkout → Payment (Midtrans)

### ClientArea `/client`
- Dashboard
- My Orders, My Invoices
- Downloads (produk digital)
- Support Tickets (create, reply, close)
- Profile & Addresses

### AdminArea `/admin`
- Dashboard dengan statistik real-time + revenue chart
- **CMS**: Pages, Articles, Categories, Tags
- **E-Commerce**: Products, Orders, Invoices, Payments
- **Pelanggan**: Customers, Auth Users
- **Layanan**: Services, Billing, Support, Testimonials
- **Sistem**: Media Manager, Portfolio, Reports, Settings
- Dark mode toggle

### Api `/api/v1`
- REST API: Auth, Products, Services, Cart, Orders, Tickets, Notifications

---

## 🚀 Instalasi

```bash
# 1. Clone
git clone git@github.com:yedincoder/nds.git
cd nds

# 2. Install dependencies
composer install
composer dump-autoload --optimize

# 3. Copy env & konfigurasi database
cp env .env
# edit .env: database, session, midtrans

# 4. Migrasi & seed
php spark migrate
php spark db:seed RolePermissionSeeder
php spark db:seed AdminUserSeeder
php spark db:seed DummyDataSeeder

# 5. Jalankan
php spark serve
```

---

## 🔐 Login Default

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@ngappid.id` | `admin123` |
| Customer | `customer@ngappid.id` | lihat seeder |

---

## 🗄️ Database

Database: `ngappid` · Tabel: ±45 tabel (users, orders, invoices, transactions, tickets, testimonials, media, dll).

---

## 🗂️ Struktur Project (Area-Based)

```
app/
├── Controllers/                    # Base Controllers (CI)
│   ├── BaseController.php          # CI default
│   ├── HomeController.php          # CI default
│   ├── FrontBaseController.php     # Base FrontArea
│   ├── AdminBaseController.php     # Base AdminArea
│   ├── ClientBaseController.php    # Base ClientArea
│   ├── MitraBaseController.php     # Base MitraArea (future)
│   └── Api/                        # API Controllers
│
├── Modules/                        # Modular area-based architecture
│   ├── Auth/                       # Autentikasi
│   │   ├── Config/
│   │   ├── Controllers/            # AuthController
│   │   ├── Database/Migrations/
│   │   ├── Database/Seeds/
│   │   ├── Helpers/
│   │   ├── Language/
│   │   ├── Libraries/
│   │   ├── Models/                 # UserModel
│   │   ├── Routes/
│   │   ├── Services/               # AuthService
│   │   └── Views/
│   ├── FrontArea/                  # Frontend publik
│   │   ├── Controllers/            # Products, Services, Blog, Portfolio, CMS, Cart, Checkout, Payment, Invoice, Billing, Midtrans
│   │   ├── Models/                 # Product, Service, CMS, Cart, Order, Invoice, Payment, Billing
│   │   ├── Services/               # ProductService, CartService, CheckoutService, PaymentService, dll
│   │   ├── Libraries/              # MidtransLibrary
│   │   └── Database/Migrations/
│   ├── ClientArea/                 # Dashboard customer
│   │   ├── Controllers/            # Dashboard, Download, Order, Profile, Support
│   │   ├── Models/                 # CustomerAddress, UserProfile
│   │   ├── Services/               # CustomerService
│   │   └── Database/Migrations/
│   ├── AdminArea/                  # Panel admin
│   │   ├── Controllers/            # AdminDashboard, CMSDashboard, Media, Testimonial, Ticket
│   │   ├── Models/                 # Ticket, Testimonial
│   │   ├── Services/               # SupportService
│   │   └── Database/Migrations/
│   ├── Api/                        # API (future)
│   └── MitraArea/                  # Mitra (future)
│
└── Views/
    ├── Layout/
    │   ├── layout_frontarea.php
    │   ├── layout_adminarea.php
    │   ├── layout_clientarea.php
    │   └── layout_mitraarea.php
    ├── Auth/
    ├── FrontArea/                  # home, products, services, blog, contact
    ├── AdminArea/                  # dashboard, cms
    ├── ClientArea/                 # dashboard, orders, invoices, downloads, tickets, profile
    └── errors/
```

---

## 🎯 Area Modules

| Area | Route Prefix | Fungsi | Base Controller |
|------|-------------|--------|-----------------|
| **Auth** | `/auth` | Login, Register, Logout | FrontBaseController |
| **FrontArea** | `/` | Halaman publik, produk, cart, checkout, payment | FrontBaseController |
| **ClientArea** | `/client` | Dashboard customer | ClientBaseController |
| **AdminArea** | `/admin` | Panel admin | AdminBaseController |
| **MitraArea** | `/mitra` | (future) | MitraBaseController |
| **Api** | `/api/v1` | REST API | - |

---

## 📚 Dokumentasi

| Dokumen | Deskripsi |
|---------|-----------|
| [docs/ARCHITECTURE.md](docs/ARCHITECTURE.md) | Arsitektur sistem |
| [docs/STRUCTURE.md](docs/STRUCTURE.md) | Struktur folder area-based |
| [docs/DATABASE_ARCHITECTURE.md](docs/DATABASE_ARCHITECTURE.md) | Struktur database |
| [docs/API_DOCS.md](docs/API_DOCS.md) | Dokumentasi REST API |
| [docs/PAYMENT.md](docs/PAYMENT.md) | Integrasi pembayaran Midtrans |
| [docs/CHECKOUT_FLOW.md](docs/CHECKOUT_FLOW.md) | Alur cart → payment |
| [docs/SUPPORT_TICKET.md](docs/SUPPORT_TICKET.md) | Sistem support ticket |
| [docs/CHANGELOG.md](docs/CHANGELOG.md) | Log pengembangan |

---

## 🔒 Keamanan

- Session: FileHandler
- CSRF protection aktif
- Password hashing: Bcrypt
- Secret key Midtrans **tidak** di-commit (hanya di `.env`)
- RBAC (Role-Based Access Control)
- Auth & Permission filters

---

## 📝 Lisensi

Kode aplikasi & dokumentasi project ini milik **PT. YEDIN DIGITAL MANDIRI**.

**Adminator Free** theme © ThemeWagon — lihat [sumber asli](https://github.com/themewagon/adminator-free) untuk lisensinya.

---

© 2026 NgAppID Digital · Jl. RA. Kartini No.23L, Rangkasbitung, Lebak, Banten 42314 · 08977487315 · info@ngappid.com
