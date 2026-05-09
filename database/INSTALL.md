# 🚀 دليل التثبيت السريع - Quick Installation Guide
# نظام فندق فانا - Vana Hotel System

## ⚡ التثبيت بأمر واحد (دقيقة واحدة!)

### الطريقة الجديدة (ملف واحد شامل) ⭐ موصى به

```bash
# 1. إنشاء قاعدة البيانات
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS homework_std_ro_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 2. تثبيت كل شيء بأمر واحد
mysql -u root -p homework_std_ro_db < database/install.sql
```

**هذا كل شيء!** ✅

---

## 📦 ما يتضمنه ملف `install.sql`

الملف الشامل يحتوي على:

1. ✅ **البنية الأساسية** (17 جدول)
   - المستخدمون والمديرون
   - الغرف والحجوزات
   - المرافق والميزات
   - التقييمات والاستفسارات

2. ✅ **جداول الترجمة** (3 جداول)
   - `features_translations`
   - `facilities_translations`
   - `rooms_translations`

3. ✅ **البيانات التجريبية**
   - 1 مدير
   - 5 مستخدمين
   - 6 غرف
   - 8 مرافق
   - 10 ميزات
   - 9 حجوزات
   - 5 تقييمات

4. ✅ **بيانات الترجمة** (72 سجل)
   - 30 ترجمة للميزات (10 × 3 لغات)
   - 24 ترجمة للمرافق (8 × 3 لغات)
   - 18 ترجمة للغرف (6 × 3 لغات)

---

## 🔐 بيانات الدخول

### حساب المدير
```
URL:      http://localhost/std_2_hotel_system/admin/login
Username: admin
Password: admin123
```

### حسابات المستخدمين (كلمة المرور: password123)
```
ahmed@demo.com   - Ahmed Ali    - $5,000
sara@demo.com    - Sara Hassan  - $3,200
omar@demo.com    - Omar Khalid  - $8,500
layla@demo.com   - Layla Nouri  - $1,200
karwan@demo.com  - Karwan Aziz  - $9,999
```

---

## ✅ التحقق من التثبيت

### 1. تحقق من الجداول
```sql
USE homework_std_ro_db;
SHOW TABLES;
```

**النتيجة المتوقعة**: 20 جدول

### 2. تحقق من البيانات
```sql
SELECT COUNT(*) FROM rooms;              -- يجب أن يكون 6
SELECT COUNT(*) FROM features;           -- يجب أن يكون 10
SELECT COUNT(*) FROM facilities;         -- يجب أن يكون 8
SELECT COUNT(*) FROM user_cred;          -- يجب أن يكون 5
SELECT COUNT(*) FROM features_translations;   -- يجب أن يكون 30
SELECT COUNT(*) FROM facilities_translations; -- يجب أن يكون 24
SELECT COUNT(*) FROM rooms_translations;      -- يجب أن يكون 18
```

### 3. اختبر الموقع
```bash
# افتح المتصفح
http://localhost/std_2_hotel_system/

# شغل الاختبارات التلقائية
php tests/automated_tests.php
```

**النتيجة المتوقعة**: 15/15 اختبار ناجح (100%)

---

## 📁 الملفات المتاحة

### الملف الشامل (موصى به) ⭐
- `database/install.sql` - **ملف واحد يحتوي على كل شيء**

### الملفات المنفصلة (للمرجع)
- `database/schema.sql` - البنية الأساسية فقط
- `database/seeder.sql` - البيانات التجريبية فقط
- `database/schema_translations.sql` - جداول الترجمة فقط
- `database/seeder_translations.sql` - بيانات الترجمة فقط

---

## 🔄 إعادة التثبيت

إذا أردت إعادة التثبيت من الصفر:

```bash
# حذف قاعدة البيانات القديمة
mysql -u root -p -e "DROP DATABASE IF EXISTS homework_std_ro_db;"

# إنشاء قاعدة بيانات جديدة
mysql -u root -p -e "CREATE DATABASE homework_std_ro_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# تثبيت كل شيء
mysql -u root -p homework_std_ro_db < database/install.sql
```

---

## 🐛 حل المشاكل

### المشكلة: "Access denied for user"
```bash
# الحل: تأكد من كلمة مرور MySQL
mysql -u root -p
# أدخل كلمة المرور الصحيحة
```

### المشكلة: "Database doesn't exist"
```bash
# الحل: أنشئ قاعدة البيانات أولاً
mysql -u root -p -e "CREATE DATABASE homework_std_ro_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### المشكلة: "Table already exists"
```bash
# الحل: احذف الجداول القديمة أو أعد إنشاء قاعدة البيانات
mysql -u root -p -e "DROP DATABASE homework_std_ro_db; CREATE DATABASE homework_std_ro_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p homework_std_ro_db < database/install.sql
```

---

## 📊 الإحصائيات

بعد التثبيت، ستحصل على:

```
📁 الجداول:        20 (17 أساسية + 3 ترجمة)
👥 المستخدمين:     5
🏨 الغرف:          6
🎯 المرافق:        8
⭐ الميزات:        10
📅 الحجوزات:       9
💬 التقييمات:      5
🌍 الترجمات:       72 سجل (3 لغات)
```

---

## 🎯 الخطوات التالية

بعد التثبيت:

1. ✅ افتح الموقع: `http://localhost/std_2_hotel_system/`
2. ✅ سجل دخول كمدير: `admin` / `admin123`
3. ✅ استكشف لوحة التحكم
4. ✅ جرب تبديل اللغة (عربي/إنجليزي/كردي)
5. ✅ شغل الاختبارات: `php tests/automated_tests.php`

---

## 📚 الوثائق الإضافية

- `database/README.md` - دليل قاعدة البيانات الشامل
- `database/TRANSLATIONS_README.md` - دليل نظام الترجمة
- `tests/TEST_PLAN.md` - خطة الاختبار (107 حالة)
- `PROJECT_STRUCTURE.md` - هيكل المشروع الكامل

---

## 💡 نصائح

1. **استخدم `install.sql` دائماً** - إنه الأسهل والأسرع
2. **احفظ نسخة احتياطية** قبل إعادة التثبيت
3. **شغل الاختبارات** بعد كل تثبيت للتأكد من أن كل شيء يعمل
4. **استخدم UTF-8** في محرر النصوص لعرض العربية بشكل صحيح

---

**تاريخ الإنشاء**: 2026-05-09  
**الحالة**: ✅ جاهز للاستخدام  
**الإصدار**: 1.0.0
