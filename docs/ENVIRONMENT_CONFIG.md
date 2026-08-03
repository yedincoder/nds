# ENVIRONMENT CONFIGURATION DOCUMENT
# ==============================================================================
# PROJECT     : NgAppID Digital Platform
# PHASE       : 10 - Development Environment
# VERSION     : 1.0.0
# DATE        : 2026-08-02
# ==============================================================================

# 1. ENVIRONMENT ARCHITECTURE
# ==============================================================================
Project memiliki tiga environment utama:
  1. Development - Digunakan untuk proses pengembangan lokal
  2. Testing - Digunakan untuk pengujian sistem
  3. Production - Digunakan untuk aplikasi berjalan secara publik

# 2. ENVIRONMENT PRINCIPLE
# ==============================================================================
1. Secure Configuration
2. Separation Environment
3. No Hardcode Configuration
4. Environment Variable Based
5. Easy Deployment
6. Maintainable Configuration

# 3. ENVIRONMENT STRUCTURE
# ==============================================================================
Environment File: .env
Configuration Directory: app/Config/
Deployment Configuration: server/
Documentation: docs/configuration/

# 4. DEVELOPMENT ENVIRONMENT
# ==============================================================================
Development digunakan untuk:
  1. Coding
  2. Debugging
  3. Feature Development
  4. Local Testing

Configuration:
  1. Error Display Active
  2. Debug Mode Active
  3. Development Database
  4. Development Cache

# 5. TESTING ENVIRONMENT
# ==============================================================================
Testing digunakan untuk:
  1. Automated Testing
  2. Validation Testing
  3. Security Testing

Configuration:
  1. Testing Database
  2. Testing Cache
  3. Testing Email
  4. Testing Storage

# 6. PRODUCTION ENVIRONMENT
# ==============================================================================
Production digunakan untuk:
  1. Customer Access
  2. Business Operation
  3. Real Transaction

Configuration:
  1. Error Display Disabled
  2. Production Database
  3. Production Cache
  4. SSL Enabled
  5. Security Mode Enabled

# 7. APPLICATION CONFIGURATION
# ==============================================================================
Konfigurasi aplikasi:
  1. Application Name
  2. Base URL
  3. Environment Mode
  4. Timezone
  5. Localization
  6. Encryption Key

# 8. DATABASE CONFIGURATION
# ==============================================================================
Database: MariaDB 10.5+
Configuration:
  1. Host
  2. Port
  3. Database Name
  4. Username
  5. Password
  6. Charset
  7. Collation

Rule: Database credential tidak boleh disimpan langsung pada source code

# 9. CACHE CONFIGURATION
# ==============================================================================
Cache: Redis
Digunakan untuk:
  1. Application Cache
  2. Session Cache
  3. Query Cache
  4. Temporary Data

Configuration:
  1. Redis Host
  2. Redis Port
  3. Redis Password
  4. Cache Lifetime

# 10. MAIL CONFIGURATION
# ==============================================================================
Mail System: SMTP
Configuration:
  1. SMTP Host
  2. SMTP Port
  3. SMTP Username
  4. SMTP Password
  5. Sender Identity

Digunakan untuk:
  1. Account Notification
  2. Transaction Notification
  3. Support Notification

# 11. STORAGE CONFIGURATION
# ==============================================================================
Storage digunakan untuk:
  1. Media File
  2. Product File
  3. Attachment
  4. Backup

Rule: File upload harus melalui validation dan storage management

# 12. SECURITY CONFIGURATION
# ==============================================================================
Security Environment:
  1. Application Key
  2. CSRF Protection
  3. Session Security
  4. Cookie Security
  5. HTTPS Configuration
  6. Access Permission

# 13. PHP CONFIGURATION
# ==============================================================================
PHP Requirement:
Version: PHP 8.3+
Extension:
  1. Intl
  2. Mbstring
  3. OpenSSL
  4. PDO MariaDB
  5. JSON
  6. Fileinfo
  7. CURL
  8. GD

# 14. COMPOSER CONFIGURATION
# ==============================================================================
Composer digunakan untuk:
  1. Dependency Management
  2. Package Installation
  3. Autoload Management

Rule:
  1. Dependency harus menggunakan version control
  2. Dependency harus terdokumentasi

# 15. NODE ENVIRONMENT
# ==============================================================================
Node.js digunakan untuk:
  1. Frontend Asset Management
  2. CSS Build
  3. JavaScript Build

Requirement:
  1. Node.js
  2. NPM
  3. Package Lock

# 16. SERVER ENVIRONMENT
# ==============================================================================
Production Server:
Operating System: Ubuntu Server
Web Server: Nginx
Application Server: PHP-FPM
Database: MariaDB
Cache: Redis

# 17. ENVIRONMENT CONFIGURATION RULE
# ==============================================================================
RULE-001: Tidak boleh menyimpan password pada source code
RULE-002: Semua konfigurasi menggunakan environment variable
RULE-003: Development dan Production harus terpisah
RULE-004: Production configuration tidak boleh digunakan pada development
RULE-005: Semua perubahan environment harus terdokumentasi

# 18. ENVIRONMENT VALIDATION
# ==============================================================================
Validasi:
  1. PHP Version Check
  2. Composer Check
  3. Database Connection Check
  4. Redis Connection Check
  5. Mail Connection Check
  6. Storage Permission Check

# OUTPUT PHASE
# ==============================================================================
1. Environment Architecture ✓
2. Environment Configuration ✓
3. Database Configuration ✓
4. Cache Configuration ✓
5. Mail Configuration ✓
6. Storage Configuration ✓
7. Security Configuration ✓
8. Server Configuration ✓
9. Environment Documentation ✓

# CHECKLIST
# ==============================================================================
[✓] Development environment dibuat
[✓] Testing environment dibuat
[✓] Production environment dibuat
[✓] .env configuration dibuat
[✓] Database configuration dibuat
[✓] Redis configuration dibuat
[✓] Mail configuration dibuat
[✓] Storage configuration dibuat
[✓] Security configuration dibuat
[✓] Environment documentation dibuat

# ACCEPTANCE CRITERIA
# ==============================================================================
Phase dinyatakan selesai apabila:
✓ Environment telah ditentukan
✓ Configuration telah dibuat
✓ Database connection siap
✓ Redis configuration siap
✓ Mail configuration siap
✓ Security configuration siap
✓ Development environment siap
✓ Production environment siap
✓ Siap masuk Phase-11 Authentication

# STATUS
# ==============================================================================
PHASE STATUS: SELESAI
NEXT PHASE: Phase-11 (Authentication)
# ==============================================================================
