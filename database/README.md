# Database Setup — إعداد قاعدة البيانات

This directory contains database-related files for the Vana Hotel project.

## Files — الملفات

| File | Description |
|------|-------------|
| `schema.sql` | Database structure (tables, indexes, foreign keys) — بنية قاعدة البيانات |
| `seeder.sql` | Sample data for testing and development — بيانات تجريبية للاختبار |
| `../m_hotel.sql` | Legacy schema file (replaced by schema.sql) |

## Setup Instructions — تعليمات الإعداد

### Method 1: Command Line — الطريقة الأولى: سطر الأوامر

```bash
# 1. Create database — إنشاء قاعدة البيانات
mysql -u root -p -e "CREATE DATABASE vana_hotel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 2. Import schema — استيراد البنية
mysql -u root -p vana_hotel < database/schema.sql

# 3. Import sample data — استيراد البيانات التجريبية
mysql -u root -p vana_hotel < database/seeder.sql
```

### Method 2: phpMyAdmin — الطريقة الثانية: phpMyAdmin

1. Open phpMyAdmin — افتح phpMyAdmin
2. Create new database: `vana_hotel` with collation `utf8mb4_unicode_ci`
3. Select the database — اختر قاعدة البيانات
4. Go to "Import" tab — اذهب إلى تبويب "استيراد"
5. Import `schema.sql` first — استورد schema.sql أولاً
6. Then import `seeder.sql` — ثم استورد seeder.sql

## Table Changes — التغييرات على الجداول

تم تحسين أسماء الجداول التالية:

- ✅ `team_detalis3` → `team_members` (تصحيح الإملاء)
- ✅ `user_queries1` → `user_queries` (إزالة الرقم غير الضروري)

## Demo Credentials — بيانات الدخول الافتراضية

### Admin — المدير
| Field | Value |
|-------|-------|
| Username | `admin` |
| Password | `admin123` |

### Test Users — المستخدمين التجريبيين
All users use password: `password123` — جميع المستخدمين يستخدمون كلمة المرور: `password123`

| Name | Email |
|------|-------|
| Ahmed Ali | ahmed@demo.com |
| Sara Hassan | sara@demo.com |
| Omar Khalid | omar@demo.com |
| Layla Nouri | layla@demo.com |
| Karwan Aziz | karwan@demo.com |

## Demo Data Summary — ملخص البيانات التجريبية

| Table | Records |
|-------|---------|
| Rooms | 6 (Standard → Presidential Suite) |
| Features | 10 |
| Facilities | 8 |
| Users | 5 |
| Bookings | 9 (completed, active, cancelled) |
| Reviews | 5 (ratings 3–5 stars) |
| Queries | 5 (mix of seen/unseen) |
| Team Members | 4 |
| Carousel | 3 images |

## Database Features — مميزات قاعدة البيانات

- ✅ All passwords hashed using bcrypt — جميع كلمات المرور مشفرة
- ✅ Foreign keys properly configured — المفاتيح الأجنبية مضبوطة
- ✅ Indexes for better performance — فهارس لتحسين الأداء
- ✅ UTF-8 support for Arabic content — دعم UTF-8 للمحتوى العربي
- ✅ Cascade delete for data integrity — حذف تسلسلي لسلامة البيانات

## Notes — ملاحظات

- ⚠️ The seeder **truncates all tables** before inserting — run only on a fresh/test database
- Room images reference files already in `public/images/rooms/`
- Balances are pre-loaded so users can make bookings immediately
- All timestamps use server timezone
