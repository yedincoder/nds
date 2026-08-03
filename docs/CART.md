# CART MODULE DOCUMENT
# ==============================================================================
# PROJECT     : NgAppID Digital Platform
# PHASE       : 18 - Shopping Cart Module
# VERSION     : 1.0.0
# DATE        : 2026-08-02
# ==============================================================================

# 1. CART ARCHITECTURE
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

# 2. CART PRINCIPLE
# ==============================================================================
1. Simple Shopping Experience
2. Accurate Price Calculation
3. Secure Transaction Preparation
4. Data Consistency
5. Performance Optimization
6. Easy Checkout Process

# 3. CART MODULE STRUCTURE
# ==============================================================================
Module: Cart
Structure:
  1. Controllers
  2. Models
  3. Services
  4. Views
  5. Database
  6. Validation
  7. Routes
  8. Documentation

# 4. CART FEATURE LIST
# ==============================================================================
1. Add To Cart
2. View Cart
3. Update Cart
4. Remove Cart Item
5. Clear Cart
6. Cart Summary
7. Price Calculation
8. Cart Validation

# 5. ADD TO CART
# ==============================================================================
Responsibility: Menambahkan produk atau service ke dalam keranjang
Features:
  1. Select Product
  2. Select Service
  3. Add Item
  4. Validate Item
  5. Save Cart Data

# 6. CART ITEM MANAGEMENT
# ==============================================================================
Features:
  1. View Cart Item
  2. Update Quantity
  3. Remove Item
  4. Change Selection
  5. Refresh Cart

# 7. CART CALCULATION
# ==============================================================================
Cart melakukan perhitungan:
  1. Item Price
  2. Quantity
  3. Sub Total
  4. Discount
  5. Grand Total

Calculation:
Item Price x Quantity = Sub Total

# 8. CART VALIDATION
# ==============================================================================
1. Product Availability
2. Product Status
3. Price Validation
4. Quantity Validation
5. Customer Session Validation

# 9. CART SESSION MANAGEMENT
# ==============================================================================
Cart dapat menggunakan:
  1. Guest Session
  2. Customer Session
  3. Database Cart

Rule: Guest Cart dapat dipindahkan ke Customer Cart setelah login

# 10. CART WORKFLOW
# ==============================================================================
Customer → Select Product/Service → Add To Cart → Validate Item → 
Calculate Total → Checkout

# 11. CART DATABASE REQUIREMENT
# ==============================================================================
Table:
  1. Carts
  2. Cart Items

## 11.1 CARTS TABLE
Field:
  1. id
  2. user_id
  3. session_id
  4. status
  5. created_at
  6. updated_at

## 11.2 CART ITEMS TABLE
Field:
  1. id
  2. cart_id
  3. product_id
  4. service_id
  5. quantity
  6. price
  7. subtotal
  8. created_at
  9. updated_at

# 12. CART ACCESS CONTROL
# ==============================================================================
Super Administrator: Full Cart Monitoring
Administrator: View Cart Data
Customer: Manage Own Cart
Guest: Temporary Cart Access

# 13. CART SECURITY
# ==============================================================================
Cart wajib memiliki:
  1. Authorization Check
  2. CSRF Protection
  3. Input Validation
  4. Price Verification
  5. IDOR Protection
  6. Session Security
  7. Transaction Validation

# 14. CART PERFORMANCE
# ==============================================================================
Optimasi:
  1. Session Cache
  2. Redis Cache
  3. Database Index
  4. Query Optimization
  5. Lazy Loading

# 15. CART INTEGRATION
# ==============================================================================
Cart dapat terintegrasi dengan:
  1. Product Module
  2. Service Module
  3. Checkout Module
  4. Billing Module
  5. Payment Module

# 16. CART ERROR HANDLING
# ==============================================================================
Error:
  1. Product Not Found
  2. Product Inactive
  3. Invalid Quantity
  4. Price Changed
  5. Session Expired

Handling:
  1. Exception
  2. Logging
  3. User Notification

# 17. CART TESTING
# ==============================================================================
Testing:
  1. Add Cart Test
  2. Update Cart Test
  3. Remove Cart Test
  4. Quantity Test
  5. Price Calculation Test
  6. Session Cart Test
  7. Security Test
  8. Performance Test

# 18. IMPLEMENTATION RULE
# ==============================================================================
RULE-001: Cart logic harus berada pada Service Layer
RULE-002: Controller tidak boleh memiliki business logic
RULE-003: Harga harus selalu diverifikasi sebelum checkout
RULE-004: Cart item harus memiliki validasi
RULE-005: User hanya dapat mengakses cart miliknya
RULE-006: Cart harus mendukung caching

# OUTPUT PHASE
# ==============================================================================
1. Cart Architecture ✓
2. Shopping Cart System ✓
3. Cart Item Management ✓
4. Price Calculation ✓
5. Cart Validation ✓
6. Cart Security ✓
7. Cart Integration ✓
8. Cart Testing ✓
9. Cart Documentation ✓

# CHECKLIST
# ==============================================================================
[✓] Cart architecture dibuat
[✓] Add cart dibuat
[✓] Cart item management dibuat
[✓] Quantity management dibuat
[✓] Price calculation dibuat
[✓] Validation dibuat
[✓] Security diterapkan
[✓] Integration dibuat
[✓] Testing dilakukan
[✓] Dokumentasi dibuat

# ACCEPTANCE CRITERIA
# ==============================================================================
Phase dinyatakan selesai apabila:
✓ Customer dapat menambahkan item ke cart
✓ Customer dapat mengubah cart
✓ Customer dapat menghapus item
✓ Total harga dihitung dengan benar
✓ Cart aman dari manipulasi
✓ Integration siap ke checkout
✓ Security review selesai
✓ Testing selesai
✓ Dokumentasi tersedia
✓ Siap masuk Phase-19 Checkout

# STATUS
# ==============================================================================
PHASE STATUS: SELESAI
NEXT PHASE: Phase-19 (Checkout)
# ==============================================================================
