# Support Ticket System

**Version:** 1.0
**Date:** 2026-08-05

---

## 🎫 Fitur

| Fitur | Client | Admin |
|-------|--------|-------|
| Buat tiket | ✅ | ✅ |
| Lihat list tiket | ✅ | ✅ |
| Lihat detail & percakapan | ✅ | ✅ |
| Balas tiket | ✅ | ✅ |
| Tutup tiket | ✅ | ✅ |
| Ganti status | ❌ | ✅ |
| Assign ke staff | ❌ | ✅ |

---

## 📁 Struktur

```
app/Modules/
├── ClientArea/
│   ├── Controllers/SupportController.php     # Client support
│   └── Views/support/                        # tickets, create, detail
└── AdminArea/
    ├── Controllers/TicketController.php      # Admin support
    └── Views/                                # admin ticket views
```

## 🔗 Routes

### Client Area (`/client/support`)
| Method | URL | Action |
|--------|-----|--------|
| GET | `/client/support/tickets` | List tiket user |
| GET | `/client/support/ticket/create` | Form buat tiket |
| POST | `/client/support/ticket/create` | Simpan tiket |
| GET | `/client/support/ticket/{ref}` | Detail tiket |
| POST | `/client/support/ticket/{ref}` | Balas tiket |
| GET | `/client/support/ticket/{ref}/close` | Tutup tiket |

### Admin Area (`/support`)
| Method | URL | Action |
|--------|-----|--------|
| GET | `/support/tickets` | List semua tiket |
| GET | `/support/ticket/create` | Form buat tiket |
| POST | `/support/ticket/create` | Simpan tiket |
| GET | `/support/ticket/{id}` | Detail tiket |
| POST | `/support/ticket/{id}` | Balas tiket |
| GET | `/support/ticket/close/{id}` | Tutup tiket |

---

## 🗄️ Database

### `tickets`
```sql
CREATE TABLE tickets (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  uuid CHAR(36) NOT NULL UNIQUE,
  user_id BIGINT UNSIGNED NOT NULL,
  category_id BIGINT UNSIGNED NULL,
  assigned_to BIGINT UNSIGNED NULL,
  ticket_number VARCHAR(50) NOT NULL,
  subject VARCHAR(255) NOT NULL,
  priority ENUM('low','medium','high','critical') DEFAULT 'medium',
  status ENUM('open','waiting_response','in_progress','resolved','closed') DEFAULT 'open',
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);
```

### `ticket_messages`
```sql
CREATE TABLE ticket_messages (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  uuid CHAR(36) NOT NULL UNIQUE,
  ticket_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NULL,
  message TEXT NOT NULL,
  attachment VARCHAR(255) NULL,
  created_at DATETIME NULL
);
```

---

## 🏷️ Kategori Ticket

Categories disimpan di tabel `categories` dengan `type = 'ticket'`.

| ID | Nama | Slug |
|----|------|------|
| 1 | Teknis | teknis |
| 2 | Billing | billing |
| 3 | Akun | akun |
| 4 | Pesanan | pesanan |
| 5 | Produk | produk |
| 6 | Lainnya | lainnya |

---

## 🔄 Status Ticket

| Status | Deskripsi |
|--------|-----------|
| `open` | Tiket baru dibuat |
| `waiting_response` | Menunggu balasan customer |
| `in_progress` | Sedang diproses admin |
| `resolved` | Masalah telah diselesaikan |
| `closed` | Tiket ditutup |

---

## 👨‍💻 API

### Buat Ticket (Client)
```http
POST /api/v1/tickets
Authorization: Bearer {token}
Content-Type: application/json

{
  "category_id": 2,
  "subject": "Tagihan tidak muncul",
  "message": "Saya sudah bayar tapi invoice tidak terupdate...",
  "priority": "high"
}
```

### List Ticket (Client)
```http
GET /api/v1/tickets?status=open&page=1
Authorization: Bearer {token}
```

### Detail Ticket
```http
GET /api/v1/tickets/{uuid}
Authorization: Bearer {token}
```

### Balas Ticket
```http
POST /api/v1/tickets/{uuid}/reply
Authorization: Bearer {token}
Content-Type: application/json

{
  "message": "Sudah saya coba, tapi tetap error"
}
```

### Tutup Ticket
```http
POST /api/v1/tickets/{uuid}/close
Authorization: Bearer {token}
Content-Type: application/json

{
  "resolution": "Sudah dibantu, terima kasih"
}
```

---

## 🔒 Security

1. **Ownership Check** - User hanya bisa akses tiket miliknya
2. **CSRF** - Form menggunakan `csrf_field()`
3. **Validation** - Validasi input (subject min 5 char, message min 10 char)
4. **Status Guard** - Tidak bisa balas tiket yang sudah closed/resolved

---

## 🧪 Test Cases

| No | Test | Expected |
|----|------|----------|
| 1 | Buat tiket tanpa login | Redirect ke login |
| 2 | Buat tiket valid | Success, redirect ke list |
| 3 | Akses tiket user lain | 404 Not Found |
| 4 | Balas tiket closed | Error message |
| 5 | Tutup tiket user lain | Error message |
| 6 | Buat tiket tanpa kategori | Validation error |
| 7 | List tiket kosong | Tampilkan empty state |
