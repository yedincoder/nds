# NDS - Database Architecture

**Version:** 2.0
**Date:** 2026-08-05
**Engine:** MariaDB 10.5+
**Database:** ngappid

---

## 📊 Tabel Utama (±45)

### Core / Auth
| Tabel | Keterangan |
|-------|-----------|
| users | Data pengguna |
| user_profiles | Profil lengkap pengguna |
| user_roles | Relasi user ↔ role |
| roles | Role (super-admin, admin, customer) |
| permissions | Daftar permission |
| role_permissions | Relasi role ↔ permission |
| login_attempts | Log percobaan login |
| activity_logs | Log aktivitas |

### FrontArea / E-commerce
| Tabel | Keterangan |
|-------|-----------|
| products | Produk |
| product_categories | Kategori produk |
| product_prices | Harga produk (termasuk tax_rate, discount) |
| product_files | File produk (untuk download) |
| product_images | Gambar produk |
| services | Layanan |
| service_categories | Kategori layanan |
| service_packages | Paket layanan |
| carts | Keranjang |
| cart_items | Item keranjang |
| orders | Pesanan |
| order_items | Item pesanan |
| invoices | Invoice |
| invoice_items | Item invoice |
| transactions | Transaksi pembayaran |
| payments | Pembayaran |
| payment_methods | Metode pembayaran |
| payment_logs | Log pembayaran |
| midtrans_transactions | Transaksi Midtrans |
| midtrans_notifications | Notifikasi webhook Midtrans |

### Content / CMS
| Tabel | Keterangan |
|-------|-----------|
| articles | Artikel/blog |
| categories | Kategori (article, ticket) |
| tags | Tag |
| article_tags | Relasi artikel ↔ tag |
| pages | Halaman statis |
| portfolios | Portofolio |
| testimonials | Testimoni |

### ClientArea / Customer
| Tabel | Keterangan |
|-------|-----------|
| customer_addresses | Alamat pelanggan |
| downloads | Data download produk |
| download_logs | Log download |

### AdminArea / Support
| Tabel | Keterangan |
|-------|-----------|
| tickets | Tiket support |
| ticket_messages | Pesan tiket |
| contacts | Pesan kontak |
| notifications | Notifikasi |

### System
| Tabel | Keterangan |
|-------|-----------|
| settings | Konfigurasi sistem |
| media | Media manager |
| audit_logs | Log audit |

---

## 🔗 Relasi Utama

```
users 1─∞ user_roles ∞─1 roles
users 1─∞ user_profiles
users 1─∞ orders ∞─1 invoices
users 1─∞ tickets ∞─∞ ticket_messages
users 1─∞ customer_addresses

products 1─∞ product_prices
products 1─∞ product_files
products 1─∞ order_items ∞─1 orders
products 1─∞ cart_items ∞─1 carts

invoices 1─∞ invoice_items
invoices 1─∞ transactions ∞─1 payments

orders 1─∞ downloads
products 1─∞ downloads
```

---

## 📝 Naming Convention

| Item | Aturan | Contoh |
|------|--------|--------|
| Tabel | plural snake_case | `order_items` |
| Kolom | snake_case | `invoice_number` |
| Primary Key | `id` | `id` |
| Foreign Key | `table_id` | `order_id` |
| Timestamp | `created_at`, `updated_at` | - |
| Soft Delete | `deleted_at` | - |
| UUID | unique per record | - |

---

## 🔑 Standard Field

Setiap tabel utama memiliki:
```php
'id'          => BIGINT UNSIGNED AUTO_INCREMENT
'uuid'        => CHAR(36) UNIQUE
'created_at'  => DATETIME
'updated_at'  => DATETIME
```

Tabel dengan soft delete:
```php
'deleted_at'  => DATETIME NULL
```

---

## 🛡️ Keamanan Database

- Prepared Statement (Query Builder)
- Input validation
- Access control (RBAC)
- Database backup berkala
- Audit logging

---

## 🗃️ Migrasi

Migrations berada di masing-masing area:
```
app/Modules/
├── Auth/Database/Migrations/
├── FrontArea/Database/Migrations/
├── AdminArea/Database/Migrations/
├── ClientArea/Database/Migrations/
└── app/Database/Migrations/
```

Jalankan:
```bash
php spark migrate
```
