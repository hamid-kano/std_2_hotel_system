# Database Setup — إعداد قاعدة البيانات
# نظام فندق فانا - Vana Hotel System

## ⚡ Quick Start (Recommended) — البدء السريع (موصى به)

### One-Command Installation ⭐
```bash
# 1. Create database
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS homework_std_ro_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 2. Install everything (schema + translations + data)
mysql -u root -p homework_std_ro_db < database/install.sql
```

**✅ Done! See `database/INSTALL.md` for detailed guide.**

---

## 📁 Files — الملفات

### Main Installation File (Recommended) ⭐
| File | Description |
|------|-------------|
| `install.sql` | **Complete installation** (schema + translations + data) — **التثبيت الكامل** |
| `INSTALL.md` | Quick installation guide — دليل التثبيت السريع |

### Individual Files (For Reference)
| File | Description |
|------|-------------|
| `schema.sql` | Base database structure (17 tables) — البنية الأساسية |
| `seeder.sql` | Demo data — البيانات التجريبية |
| `schema_translations.sql` | Translation tables (3 tables) — جداول الترجمة |
| `seeder_translations.sql` | Translation data (72 records) — بيانات الترجمة |
| `TRANSLATIONS_README.md` | Translation system guide — دليل نظام الترجمة |
| `QUICK_START.md` | Quick start guide — دليل البدء السريع |

---

## 🔧 Alternative: Step-by-Step Installation

If you prefer to install components separately:

```bash
# 1. Create database
mysql -u root -p -e "CREATE DATABASE homework_std_ro_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 2. Import base schema
mysql -u root -p homework_std_ro_db < database/schema.sql

# 3. Import demo data
mysql -u root -p homework_std_ro_db < database/seeder.sql

# 4. Import translation schema
mysql -u root -p homework_std_ro_db < database/schema_translations.sql

# 5. Import translation data
mysql -u root -p homework_std_ro_db < database/seeder_translations.sql
```

---

## 📊 Database Structure — بنية قاعدة البيانات

### Base Tables (17) — الجداول الأساسية
1. `admin_cred` - Admin credentials
2. `settings` - General settings
3. `contact_details` - Contact information
4. `user_cred` - User accounts
5. `balances` - User balances
6. `user_queries` - Contact form submissions
7. `team_members` - Management team
8. `carousel` - Homepage carousel images
9. `facilities` - Hotel facilities
10. `features` - Room features
11. `rooms` - Room types
12. `room_features` - Room-feature relationships
13. `room_facilities` - Room-facility relationships
14. `room_images` - Room photos
15. `booking_order` - Booking orders
16. `booking_details` - Booking details
17. `rating_review` - Reviews and ratings

### Translation Tables (3) — جداول الترجمة
18. `features_translations` - Feature translations (ar, en, ku)
19. `facilities_translations` - Facility translations (ar, en, ku)
20. `rooms_translations` - Room translations (ar, en, ku)

**Total: 20 tables**

---

## 🔐 Demo Credentials — بيانات الدخول التجريبية

### Admin — المدير
```
URL:      http://localhost/std_2_hotel_system/admin/login
Username: admin
Password: admin123
```

### Users — المستخدمون (Password: password123)
```
ahmed@demo.com   - Ahmed Ali    - Balance: $5,000
sara@demo.com    - Sara Hassan  - Balance: $3,200
omar@demo.com    - Omar Khalid  - Balance: $8,500
layla@demo.com   - Layla Nouri  - Balance: $1,200
karwan@demo.com  - Karwan Aziz  - Balance: $9,999
```

---

## ✅ Verification — التحقق

### Check Tables
```sql
USE homework_std_ro_db;
SHOW TABLES;  -- Should show 20 tables
```

### Check Data
```sql
SELECT COUNT(*) FROM rooms;                    -- 6
SELECT COUNT(*) FROM features;                 -- 10
SELECT COUNT(*) FROM facilities;               -- 8
SELECT COUNT(*) FROM user_cred;                -- 5
SELECT COUNT(*) FROM features_translations;    -- 30
SELECT COUNT(*) FROM facilities_translations;  -- 24
SELECT COUNT(*) FROM rooms_translations;       -- 18
```

### Run Tests
```bash
php tests/automated_tests.php
# Expected: 15/15 tests passed (100%)
```

---

## 📝 Table Changes — التغييرات على الجداول

Fixed table names:
- ✅ `team_detalis3` → `team_members` (spelling correction)
- ✅ `user_queries1` → `user_queries` (removed unnecessary number)

---

## 🌍 Translation System — نظام الترجمة

The database supports 3 languages:
- 🇸🇦 Arabic (ar)
- 🇬🇧 English (en)
- 🇮🇶 Kurdish (ku)

Translation data:
- 30 feature translations (10 features × 3 languages)
- 24 facility translations (8 facilities × 3 languages)
- 18 room translations (6 rooms × 3 languages)

**Total: 72 translation records**

See `database/TRANSLATIONS_README.md` for details.

---

## 🔄 Reset Database — إعادة تعيين قاعدة البيانات

To start fresh:

```bash
# Drop and recreate
mysql -u root -p -e "DROP DATABASE IF EXISTS homework_std_ro_db; CREATE DATABASE homework_std_ro_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Reinstall
mysql -u root -p homework_std_ro_db < database/install.sql
```

---

## 📚 Additional Documentation — وثائق إضافية

- `INSTALL.md` - Quick installation guide
- `TRANSLATIONS_README.md` - Translation system documentation
- `QUICK_START.md` - Quick start guide
- `../PROJECT_STRUCTURE.md` - Complete project structure
- `../tests/TEST_PLAN.md` - Testing documentation

---

**Database Name**: `homework_std_ro_db`  
**Charset**: `utf8mb4`  
**Collation**: `utf8mb4_unicode_ci`  
**Version**: 1.0.0  
**Last Updated**: 2026-05-09
