# SOFTWARE REQUIREMENT SPECIFICATION (SRS)
# ==============================================================================
# PROJECT     : NgAppID Digital Platform
# PHASE       : 03 - Software Requirement
# VERSION     : 1.0.0
# DATE        : 2026-08-02
# ==============================================================================

# 1. SOFTWARE INFORMATION
# ==============================================================================
Software Name: NgAppID Digital Platform
Software Type: Web Application
Application Category:
  1. Business Website
  2. CMS Platform
  3. Ecommerce Platform
  4. Billing System
  5. Customer Management System
  6. Support System
  7. REST API Platform

# 2. SOFTWARE OBJECTIVE
# ==============================================================================
Software harus mampu:
1. Menyediakan platform digital bisnis
2. Mengelola informasi perusahaan
3. Mengelola produk dan layanan
4. Mengelola pelanggan
5. Mengelola transaksi
6. Mengelola pembayaran
7. Mengelola invoice
8. Menyediakan Client Area
9. Menyediakan Dashboard Administrator
10. Menyediakan REST API

# 3. SYSTEM ACTOR
# ==============================================================================
1. Guest
   Pengunjung yang mengakses website tanpa autentikasi

2. Customer
   Pengguna yang memiliki akun dan menggunakan layanan

3. Administrator
   Pengguna yang mengelola operasional aplikasi

4. Super Administrator
   Pengguna dengan akses penuh sistem

5. System Service
   Komponen otomatis yang menjalankan proses sistem

# 4. FUNCTIONAL REQUIREMENT
# ==============================================================================
FR-001: Authentication System
      Sistem harus menyediakan registrasi, login, logout, dan manajemen session

FR-002: Authorization System
      Sistem harus menyediakan pengaturan hak akses berdasarkan role

FR-003: CMS System
      Sistem harus menyediakan pengelolaan konten website

FR-004: Product System
      Sistem harus menyediakan pengelolaan produk digital

FR-005: Service System
      Sistem harus menyediakan pengelolaan layanan

FR-006: Portfolio System
      Sistem harus menyediakan pengelolaan portfolio

FR-007: Blog System
      Sistem harus menyediakan pengelolaan artikel

FR-008: Customer System
      Sistem harus menyediakan pengelolaan data pelanggan

FR-009: Order System
      Sistem harus menyediakan pengelolaan pesanan

FR-010: Cart System
      Sistem harus menyediakan keranjang belanja

FR-011: Checkout System
      Sistem harus menyediakan proses checkout

FR-012: Billing System
      Sistem harus menyediakan pengelolaan tagihan

FR-013: Invoice System
      Sistem harus menyediakan pembuatan invoice

FR-014: Payment System
      Sistem harus menyediakan proses pembayaran

FR-015: Midtrans Integration
      Sistem harus mendukung integrasi payment gateway Midtrans

FR-016: Client Area
      Sistem harus menyediakan dashboard pelanggan

FR-017: Support Ticket
      Sistem harus menyediakan sistem bantuan pelanggan

FR-018: Notification System
      Sistem harus menyediakan notifikasi sistem

FR-019: Media Manager
      Sistem harus menyediakan pengelolaan file media

FR-020: REST API
      Sistem harus menyediakan endpoint API

# 5. NON FUNCTIONAL REQUIREMENT
# ==============================================================================
NFR-001: Performance
       Sistem harus memiliki performa yang optimal

NFR-002: Security
       Sistem harus menerapkan standar keamanan aplikasi

NFR-003: Scalability
       Sistem harus dapat dikembangkan sesuai kebutuhan bisnis

NFR-004: Maintainability
       Sistem harus mudah dipelihara

NFR-005: Availability
       Sistem harus memiliki tingkat ketersediaan yang baik

NFR-006: Compatibility
       Sistem harus berjalan pada browser modern

NFR-007: Documentation
       Sistem harus memiliki dokumentasi lengkap

# 6. SYSTEM WORKFLOW
# ==============================================================================
User Access Flow:
Visitor → Landing Page → Browse Product/Service → Register/Login → Customer Area

Transaction Flow:
Customer → Select Product/Service → Create Order → Checkout → 
Generate Invoice → Payment → Payment Verification → Order Completed

Admin Workflow:
Administrator → Login Dashboard → Manage Content → Manage Product → 
Manage Customer → Manage Transaction → Generate Report

# 7. SYSTEM RULE
# ==============================================================================
RULE-001: Setiap user harus memiliki role
RULE-002: Setiap transaksi harus memiliki identifier unik
RULE-003: Setiap pembayaran harus memiliki status
RULE-004: Setiap akses harus melalui authentication dan authorization
RULE-005: Setiap perubahan data penting harus tercatat
RULE-006: File upload harus melalui validasi
RULE-007: Semua input pengguna harus melalui validation

# 8. TECHNICAL REQUIREMENT
# ==============================================================================
Framework: CodeIgniter 4
Programming Language: PHP 8.3+
Database: MariaDB 10.5+
Cache: Redis
Frontend: Bootstrap 5
Admin Dashboard: CoreUI
Payment Gateway: Midtrans
Web Server: Nginx
Operating System: Ubuntu Server
Version Control: Git

# 9. SECURITY REQUIREMENT
# ==============================================================================
Sistem wajib memiliki:
1. CSRF Protection
2. XSS Protection
3. SQL Injection Protection
4. Password Hashing
5. Session Security
6. Input Validation
7. File Upload Security
8. Access Control
9. Audit Log
10. Rate Limiting

# 10. PERFORMANCE REQUIREMENT
# ==============================================================================
Sistem harus menerapkan:
1. Database Index
2. Query Optimization
3. Pagination
4. Redis Cache
5. Asset Optimization
6. Lazy Loading
7. Efficient API Response

# 11. SOFTWARE CONSTRAINT
# ==============================================================================
1. Mengikuti NDS Development Standard
2. Menggunakan Clean Architecture
3. Menggunakan Version Control
4. Menggunakan Migration Database
5. Menggunakan Automated Testing
6. Menggunakan Documentation First

# OUTPUT PHASE
# ==============================================================================
1. Software Requirement Specification ✓
2. Functional Requirement ✓
3. Non Functional Requirement ✓
4. System Actor ✓
5. System Workflow ✓
6. System Rule ✓
7. Technical Requirement ✓
8. Security Requirement ✓
9. Performance Requirement ✓
10. Acceptance Criteria ✓

# CHECKLIST
# ==============================================================================
[✓] Software requirement dibuat
[✓] Functional requirement dibuat
[✓] Non functional requirement dibuat
[✓] System actor dibuat
[✓] Workflow dibuat
[✓] System rule dibuat
[✓] Technical requirement dibuat
[✓] Security requirement dibuat
[✓] Performance requirement dibuat
[✓] Acceptance criteria dibuat
[✓] Tidak ada coding
[✓] Tidak ada database implementation

# ACCEPTANCE CRITERIA
# ==============================================================================
Phase dinyatakan selesai apabila:
✓ Software requirement telah dibuat
✓ Functional requirement telah dibuat
✓ Non functional requirement telah dibuat
✓ System workflow telah dibuat
✓ Technical requirement telah ditentukan
✓ Security requirement telah ditentukan
✓ Performance requirement telah ditentukan
✓ Tidak terdapat coding
✓ Tidak terdapat database design
✓ Siap masuk Phase-04 Architecture

# STATUS
# ==============================================================================
PHASE STATUS: SELESAI
NEXT PHASE: Phase-04 (Architecture)
# ==============================================================================
