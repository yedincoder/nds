# NgAppID Digital Platform (NDS)

Platform digital modern untuk **PT. YEDIN DIGITAL MANDIRI** (NgAppID Digital) — mencakup pengembangan aplikasi, penjualan produk digital, sistem billing, dan dukungan pelanggan terintegrasi.

---

## 🎨 Tema

Project ini menggunakan **Adminator Free** admin dashboard template.

- **Template**: [Adminator Free](https://github.com/themewagon/adminator-free)
- **Lisensi**: Free (MIT-style, untuk penggunaan komersial)
- **Lokasi asset**: `public/assets/adminator/`
- **Modifikasi**: warna primary diubah dari biru (`#2563eb`) ke **orange** (`#E65C00`) sesuai logo NgAppID
- **Struktur**: `.shell` grid → `aside.d-sidebar` (sidebar) + `.main` (`.d-topbar` + `main.content`)

> ⚠️ **Kredit**: Tema Adminator adalah karya [ThemeWagon](https://themewagon.com/). Lisensi/copyright asli tetap dimiliki ThemeWagon; project ini hanya menggunakan sebagai tema admin.

---

## 🧱 Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Framework | CodeIgniter 4.7.4 |
| Language | PHP 8.3 |
| Database | MySQL / MariaDB (port 3307) |
| Theme | Adminator Free (orange) |
| Text Editor | CKEditor 5 Classic |
| Chart | Chart.js |
| Payment | Midtrans (Snap) |

---

## 📦 Fitur

### Admin Panel (`/admin`)
- Dashboard dengan statistik real-time + revenue chart
- **CMS**: Pages, Articles, Categories, Tags
- **E-Commerce**: Products, Orders, Invoices, Payments
- **Pelanggan**: Customers, Auth Users
- **Layanan**: Services, Billing, Support, Testimonials
- **Sistem**: Media Manager, Portfolio, Reports, Settings
- Dark mode toggle

### Client Area (`/client`)
- Dashboard
- My Orders, My Invoices
- Downloads
- Support Tickets
- Profile & Addresses

### Frontend (`/`)
- Home, About, Services, Products, Portfolio, Blog, Contact
- Semua data dinamis dari database

### Integrasi
- **Midtrans** payment gateway (Snap)
- Invoice & billing system
- Support ticket system
- REST API v1

---

## 🚀 Instalasi

```bash
# 1. Clone
git clone git@github.com:yedincoder/nds.git
cd nds

# 2. Install dependencies
composer install

# 3. Copy env & konfigurasi database
cp env .env
# edit .env: database, session, midtrans

# 4. Set app key (encryption)
# edit .env → encryption.key

# 5. Migrasi & seed
php spark migrate
php spark db:seed RolePermissionSeeder
php spark db:seed AdminUserSeeder
php spark db:seed DummyDataSeeder

# 6. Jalankan
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

Dokumentasi lengkap di [docs/DATABASE_ARCHITECTURE.md](docs/DATABASE_ARCHITECTURE.md).

---

## 📁 Struktur Project

```
app/
├── Config/          # Routes, Database, Session, Midtrans, Filters
├── Controllers/     # HomeController, API controllers
├── Database/        # Migrations + Seeds
├── Filters/         # Auth, Permission, ApiAuth
├── Modules/         # Modular architecture
│   ├── Authentication/  CMS/   Dashboard/   Product/
│   ├── Order/   Invoice/   Payment/   Testimonial/
│   └── Support/  MediaManager/  ClientArea/  ...
└── Views/
    ├── layouts/     # master.php (frontend), admin.php (Adminator)
    ├── Dashboard/   # view admin
    ├── ClientArea/  # view client (Adminator)
    └── ...
public/
├── assets/adminator/  # CSS/JS/fonts Adminator
└── images/            # gambar tema
```

---

## 📚 Dokumentasi

| Dokumen | Deskripsi |
|---------|-----------|
| [docs/CHANGELOG.md](docs/CHANGELOG.md) | Log pengembangan project |
| [docs/ARCHITECTURE.md](docs/ARCHITECTURE.md) | Arsitektur sistem |
| [docs/DATABASE_ARCHITECTURE.md](docs/DATABASE_ARCHITECTURE.md) | Struktur database |
| [docs/API_DOCS.md](docs/API_DOCS.md) | Dokumentasi REST API |
| [docs/PAYMENT.md](docs/PAYMENT.md) | Integrasi pembayaran |
| [docs/CMS.md](docs/CMS.md) | Modul CMS |

---

## 🔒 Keamanan

- Session: FileHandler
- CSRF protection aktif
- Password hashing: Bcrypt
- Secret key Midtrans **tidak** di-commit (hanya di `.env`)

---

## 📝 Lisensi

Kode aplikasi & dokumentasi project ini milik **PT. YEDIN DIGITAL MANDIRI**.

**Adminator Free** theme © ThemeWagon — lihat [sumber asli](https://github.com/themewagon/adminator-free) untuk lisensinya.

---

© 2026 PT. YEDIN DIGITAL MANDIRI · Jl. RA. Kartini No.23L, Rangkasbitung, Lebak, Banten 42314 · 08977487315 · info@ngappid.com
