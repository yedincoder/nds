# ==============================================================================
# PROJECT CHANGELOG / DEVELOPMENT LOG
# ==============================================================================
# PROJECT     : NgAppID Digital Platform (NDS)
# COMPANY     : PT. YEDIN DIGITAL MANDIRI (NgAppID Digital)
# THEME       : Adminator Free (ThemeWagon)
# TECHNOLOGY  : CodeIgniter 4.7.4 · PHP 8.3 · MySQL/MariaDB
# REPOSITORY  : https://github.com/yedincoder/nds
# ==============================================================================

## 2026-08-03

### 1. Repository Init
- Inisialisasi git repository, commit awal 361 files.

### 2. Syntax Fixes
- CMS DashboardController: array closing `]);` (line 185).
- AdminDashboardController: `sum()` -> `selectSum()`, `leftJoin()` -> `join(..., 'left')`.
- PageModel/ArticleModel: tambah `'id' => 'permit_empty'` untuk `is_unique` placeholder.
- TicketController: `ticket_replies` -> `ticket_messages`.
- CMS Forms: tambah `csrf_field()`.
- Session: RedisHandler -> FileHandler (`.env`).

### 3. Admin Dashboard Overhaul
- 8 stat cards dinamis dari database.
- Revenue chart (Chart.js, 6 bulan terakhir).
- Order & payment status breakdown.
- Recent orders/invoices/payments/tickets/testimonials/activity.
- Top products, quick actions.
- Semua data real-time dari database.

### 4. Admin Menu (Sidebar)
- Grouped: Utama, Konten, E-Commerce, Pelanggan, Layanan, Dukungan, Sistem.
- CMS submenu collapsible (Pages, Articles, Categories, Tags).

### 5. CMS Module
- Pages, Articles, Categories, Tags - CRUD lengkap.
- CKEditor 5 Classic untuk text editor.
- CSRF protection.

### 6. Testimonials Module
- Migration, Model, Controller, Views, Routes.
- 5 dummy testimonials.

### 7. Client Area
- Views: Dashboard, Orders, Invoices, Downloads, Tickets, Profile, Addresses.
- Services ditambah: `getInvoicesByUser`, `countByUser`, `getTicketsByUser`, `getDownloads`, `getAddresses`, `changePassword`, `downloadFile`.

### 8. Frontend (Landing Page)
- Semua data dinamis dari database via HomeController.
- Halaman: Home, About, Services, Products, Portfolio, Blog, Contact.

### 9. Company Info
- PT. YEDIN DIGITAL MANDIRI, Jl. RA. Kartini No.23L Rangkasbitung.

### 10. Midtrans Integration
- Credentials di `.env` (tidak di-commit).

### 11. Dummy Data
- `DummyDataSeeder`: 3 products, 3 services, 3 portfolios, 5 pages, 2 categories, 6 articles, 5 testimonials.

### 12. Theme Adminator Free
- CSS/JS/images dari Adminator di-copy ke `public/assets/adminator/`.
- Admin layout: `aside.d-sidebar` + `header.d-topbar` + `main.content`.
- Client layout: struktur sama.
- Login/Register: `auth-shell` + `auth-aside` + `auth-main`.
- Primary color: biru (#2563eb) -> orange (#E65C00).
- Custom minimal helpers untuk row/col/btn/card/table (Bootstrap removed).
- Dark mode toggle.
