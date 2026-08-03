# INVOICE CLIENT MODULE DOCUMENT
# ==============================================================================
# PROJECT     : NgAppID Digital Platform
# PHASE       : 25 - Invoice Management System
# VERSION     : 1.0.0
# DATE        : 2026-08-02
# ==============================================================================

# 1. INVOICE ARCHITECTURE
# ==============================================================================
Architecture: Modular Architecture
Layer:
  1. Controller
  2. Service
  3. Model
  4. View
  5. Validation
  6. Migration
  7. Documentation

# 2. INVOICE PRINCIPLE
# ==============================================================================
1. Accurate Billing Document
2. Secure Customer Information
3. Unique Invoice Number
4. Complete Transaction History
5. Professional Invoice Format
6. Easy Customer Access

# 3. INVOICE MODULE STRUCTURE
# ==============================================================================
Module: Invoice
Structure:
  1. Controllers
  2. Models
  3. Services
  4. Views
  5. Validation
  6. Database
  7. Routes
  8. Documentation

# 4. INVOICE FEATURE LIST
# ==============================================================================
1. Invoice Generation
2. Invoice Detail
3. Invoice List
4. Invoice Status
5. Invoice Download
6. Invoice Print
7. Invoice History
8. Invoice Search

# 5. INVOICE GENERATION
# ==============================================================================
Responsibility: Membuat invoice berdasarkan Order
Process:
  Order Completed → Generate Invoice → Create Invoice Number → Save Invoice Data → Display Invoice

# 6. INVOICE NUMBER
# ==============================================================================
Format: INV-YYYYMMDD-XXXXX
Example: INV-20260802-00001

# 7. INVOICE INFORMATION
# ==============================================================================
Invoice memiliki:
  1. Invoice Number
  2. Customer Name
  3. Customer Email
  4. Billing Address
  5. Order Reference
  6. Product Detail
  7. Service Detail
  8. Subtotal
  9. Discount
  10. Total Amount
  11. Payment Status
  12. Invoice Date
  13. Due Date

# 8. INVOICE STATUS
# ==============================================================================
Invoice memiliki status:
  1. Draft
  2. Unpaid
  3. Paid
  4. Expired
  5. Cancelled
  6. Refunded

# 9. INVOICE WORKFLOW
# ==============================================================================
Order Created → Generate Invoice → Waiting Payment → Customer Payment → Payment Verified → Invoice Paid → Archive Invoice

# 10. INVOICE DETAIL
# ==============================================================================
Invoice Detail menampilkan:
  1. Item Name
  2. Description
  3. Quantity
  4. Price
  5. Subtotal
  6. Tax
  7. Total

# 11. INVOICE DOWNLOAD
# ==============================================================================
Feature:
  1. Download PDF
  2. Print Invoice
  3. Invoice Preview
  4. Secure File Access
  5. Invoice History

# 12. INVOICE PDF REQUIREMENT
# ==============================================================================
PDF harus memiliki:
  1. Company Logo
  2. Company Information
  3. Customer Information
  4. Invoice Number
  5. Transaction Detail
  6. Payment Information
  7. Footer Information

# 13. INVOICE DATABASE REQUIREMENT
# ==============================================================================
Table:
  1. Invoices
  2. Invoice Items
  3. Invoice Logs

## 13.1 INVOICES TABLE
Field:
  1. id
  2. user_id
  3. order_id
  4. invoice_number
  5. status
  6. subtotal
  7. discount
  8. tax
  9. total
  10. due_date
  11. created_at
  12. updated_at

## 13.2 INVOICE ITEMS TABLE
Field:
  1. id
  2. invoice_id
  3. product_id
  4. service_id
  5. description
  6. quantity
  7. price
  8. subtotal

## 13.3 INVOICE LOGS TABLE
Field:
  1. id
  2. invoice_id
  3. action
  4. description
  5. created_by
  6. created_at

# 14. INVOICE ACCESS CONTROL
# ==============================================================================
Super Administrator: Full Invoice Access
Administrator: Manage Invoice
Customer: View Own Invoice

# 15. INVOICE SECURITY
# ==============================================================================
Invoice wajib memiliki:
  1. Authentication Check
  2. Authorization Check
  3. IDOR Protection
  4. Secure Download
  5. File Access Validation
  6. Customer Data Protection
  7. Audit Logging

# 16. INVOICE PERFORMANCE
# ==============================================================================
Optimasi:
  1. PDF Cache
  2. Database Index
  3. Query Optimization
  4. Pagination
  5. Redis Cache

# 17. INVOICE INTEGRATION
# ==============================================================================
Invoice terintegrasi dengan:
  1. Order Module
  2. Billing Module
  3. Payment Module
  4. Midtrans Module
  5. Client Dashboard
  6. Download Module

# 18. INVOICE ERROR HANDLING
# ==============================================================================
Error:
  1. Invoice Generation Failed
  2. PDF Creation Failed
  3. Invalid Invoice Access
  4. File Not Found
  5. Payment Status Error

Handling:
  1. Exception
  2. Logging
  3. User Notification

# 19. INVOICE TESTING
# ==============================================================================
Testing:
  1. Invoice Creation Test
  2. Invoice Number Test
  3. Invoice Detail Test
  4. PDF Generation Test
  5. Download Permission Test
  6. Security Test
  7. Performance Test

# 20. IMPLEMENTATION RULE
# ==============================================================================
RULE-001: Invoice logic harus berada pada Service Layer
RULE-002: Controller tidak boleh memiliki business logic
RULE-003: Invoice number harus unik
RULE-004: Customer hanya dapat mengakses invoice miliknya
RULE-005: PDF generation harus menggunakan service
RULE-006: Semua perubahan invoice harus tercatat

# OUTPUT PHASE
# ==============================================================================
1. Invoice Architecture ✓
2. Invoice Management System ✓
3. Invoice Generation ✓
4. Invoice Detail ✓
5. Invoice PDF System ✓
6. Invoice Security ✓
7. Invoice Integration ✓
8. Invoice Testing ✓
9. Invoice Documentation ✓

# CHECKLIST
# ==============================================================================
[✓] Invoice architecture dibuat
[✓] Invoice generation dibuat
[✓] Invoice number dibuat
[✓] Invoice detail dibuat
[✓] PDF invoice dibuat
[✓] Download security dibuat
[✓] Integration dibuat
[✓] Testing dilakukan
[✓] Dokumentasi dibuat

# ACCEPTANCE CRITERIA
# ==============================================================================
Phase dinyatakan selesai apabila:
✓ Invoice otomatis dibuat
✓ Invoice number unik
✓ Customer dapat melihat invoice
✓ PDF invoice tersedia
✓ Download aman
✓ Status invoice berjalan
✓ Integrasi payment berjalan
✓ Security review selesai
✓ Testing selesai
✓ Dokumentasi tersedia
✓ Siap masuk Phase-26 Download

# STATUS
# ==============================================================================
PHASE STATUS: SELESAI
NEXT PHASE: Phase-26 (Download)
# ==============================================================================