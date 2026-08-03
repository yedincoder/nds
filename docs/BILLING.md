# BILLING MODULE DOCUMENT
# ==============================================================================
# PROJECT     : NgAppID Digital Platform
# PHASE       : 20 - Billing Module
# VERSION     : 1.0.0
# DATE        : 2026-08-02
# ==============================================================================

# 1. BILLING ARCHITECTURE
# ==============================================================================
Architecture: Modular Architecture
Layer:
  1. Controller
  2. Service
  3. Model
  4. View
  5. Validation
  6. Migration
  7. Seeder

# 2. BILLING PRINCIPLE
# ==============================================================================
1. Accurate Financial Record
2. Transparent Transaction
3. Secure Payment Data
4. Complete Transaction History
5. Automated Billing Process
6. Audit Ready

# 3. BILLING MODULE STRUCTURE
# ==============================================================================
Module: Billing
Structure:
  1. Controllers
  2. Models
  3. Services
  4. Views
  5. Database
  6. Validation
  7. Routes
  8. Documentation

# 4. BILLING FEATURE LIST
# ==============================================================================
1. Invoice Management
2. Invoice Generation
3. Invoice Detail
4. Billing Status
5. Payment Status
6. Transaction History
7. Invoice Download
8. Billing Report

# 5. INVOICE MANAGEMENT
# ==============================================================================
Responsibility: Mengelola invoice pelanggan
Features:
  1. Create Invoice
  2. View Invoice
  3. Update Invoice
  4. Cancel Invoice
  5. Generate Invoice Number
  6. Print Invoice

# 6. INVOICE INFORMATION
# ==============================================================================
Invoice memiliki informasi:
  1. Invoice Number
  2. Customer Information
  3. Order Reference
  4. Invoice Date
  5. Due Date
  6. Item Detail
  7. Sub Total
  8. Discount
  9. Total Amount
  10. Payment Status

# 7. INVOICE GENERATION
# ==============================================================================
Process:
Order Created → Generate Invoice → Save Invoice Data → 
Set Payment Status → Send Payment Request

# 8. INVOICE NUMBER FORMAT
# ==============================================================================
Format: INV-YYYYMMDD-XXXXX
Example: INV-20260802-00001

# 9. BILLING STATUS
# ==============================================================================
1. Draft
2. Unpaid
3. Paid
4. Expired
5. Cancelled
6. Refunded

# 10. PAYMENT STATUS
# ==============================================================================
1. Pending
2. Success
3. Failed
4. Expired
5. Cancelled

# 11. BILLING WORKFLOW
# ==============================================================================
Order → Create Invoice → Waiting Payment → Customer Payment → 
Payment Confirmation → Update Billing Status → Complete Transaction

# 12. BILLING DATABASE REQUIREMENT
# ==============================================================================
Table:
  1. Invoices
  2. Invoice Items
  3. Transactions
  4. Payment Logs

## 12.1 INVOICES TABLE
Field:
  1. id
  2. user_id
  3. order_id
  4. invoice_number
  5. status
  6. subtotal
  7. discount
  8. total
  9. due_date
  10. created_at
  11. updated_at

## 12.2 INVOICE ITEMS TABLE
Field:
  1. id
  2. invoice_id
  3. product_id
  4. service_id
  4. description
  5. quantity
  6. price
  7. subtotal

## 12.3 TRANSACTIONS TABLE
Field:
  1. id
  2. invoice_id
  3. payment_method
  4. payment_reference
  5. amount
  6. status
  7. paid_at
  8. created_at

## 12.4 PAYMENT LOGS TABLE
Field:
  1. id
  2. transaction_id
  3. gateway_response
  4. status
  5. created_at

# 13. BILLING ACCESS CONTROL
# ==============================================================================
Super Administrator: Full Billing Access
Administrator: Manage Billing
Customer: View Own Invoice

# 14. BILLING SECURITY
# ==============================================================================
Billing wajib memiliki:
  1. Authentication Check
  2. Authorization Check
  3. Invoice Access Protection
  4. IDOR Protection
  5. Payment Data Security
  6. Audit Logging

# 15. BILLING PERFORMANCE
# ==============================================================================
Optimasi:
  1. Invoice Cache
  2. Database Index
  3. Query Optimization
  4. Pagination
  5. Redis Cache

# 16. BILLING INTEGRATION
# ==============================================================================
Billing terintegrasi dengan:
  1. Order Module
  2. Checkout Module
  3. Payment Module
  4. Midtrans Module
  5. Notification Module
  6. Client Area

# 17. BILLING ERROR HANDLING
# ==============================================================================
Error:
  1. Invoice Creation Failed
  2. Invalid Order
  3. Payment Status Error
  4. Duplicate Invoice
  5. Invalid Transaction

Handling:
  1. Exception
  2. Logging
  3. Transaction Rollback
  4. Notification

# 18. BILLING TESTING
# ==============================================================================
Testing:
  1. Invoice Creation Test
  2. Invoice Number Test
  3. Invoice Detail Test
  4. Payment Status Test
  5. Transaction History Test
  6. Security Test
  7. Performance Test

# 19. IMPLEMENTATION RULE
# ==============================================================================
RULE-001: Billing logic harus berada pada Service Layer
RULE-002: Controller tidak boleh memiliki business logic
RULE-003: Invoice harus memiliki nomor unik
RULE-004: Semua perubahan status harus tercatat
RULE-005: Customer hanya dapat melihat invoice miliknya
RULE-006: Semua transaksi harus menggunakan database transaction

# OUTPUT PHASE
# ==============================================================================
1. Billing Architecture ✓
2. Invoice Management ✓
3. Invoice Generation ✓
4. Billing Workflow ✓
5. Payment Status Management ✓
6. Transaction History ✓
7. Billing Security ✓
8. Billing Integration ✓
9. Billing Testing ✓
10. Billing Documentation ✓

# CHECKLIST
# ==============================================================================
[✓] Billing architecture dibuat
[✓] Invoice management dibuat
[✓] Invoice generation dibuat
[✓] Billing workflow dibuat
[✓] Payment status dibuat
[✓] Transaction history dibuat
[✓] Security diterapkan
[✓] Integration dibuat
[✓] Testing dilakukan
[✓] Dokumentasi dibuat

# ACCEPTANCE CRITERIA
# ==============================================================================
Phase dinyatakan selesai apabila:
✓ Invoice dapat dibuat otomatis
✓ Invoice memiliki nomor unik
✓ Customer dapat melihat invoice
✓ Status pembayaran dapat diperbarui
✓ Histori transaksi tersimpan
✓ Billing aman
✓ Testing selesai
✓ Dokumentasi tersedia
✓ Siap masuk Phase-21 Payment

# STATUS
# ==============================================================================
PHASE STATUS: SELESAI
NEXT PHASE: Phase-21 (Payment)
# ==============================================================================