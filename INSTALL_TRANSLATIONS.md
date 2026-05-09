# تثبيت نظام الترجمة - Install Translation System
# دليل سريع - Quick Guide

## ⚡ التثبيت السريع (دقيقة واحدة!)

### الطريقة الجديدة (موصى به) ⭐
```bash
# تثبيت كل شيء بأمر واحد (البنية + البيانات + الترجمات)
mysql -u root -p homework_std_ro_db < database/install.sql
```

### الطريقة القديمة (خطوة بخطوة)
```bash
# 1. إنشاء جداول الترجمة
mysql -u root -p homework_std_ro_db < database/schema_translations.sql

# 2. إدراج بيانات الترجمة
mysql -u root -p homework_std_ro_db < database/seeder_translations.sql
```

### الخطوة الأخيرة: اختبار
افتح الموقع وبدّل اللغة - يجب أن ترى الترجمات تعمل!

---

## ✅ التحقق من التثبيت

### 1. تحقق من الجداول
```sql
SHOW TABLES LIKE '%translations%';
```
**النتيجة المتوقعة**:
```
features_translations
facilities_translations
rooms_translations
```

### 2. تحقق من البيانات
```sql
SELECT COUNT(*) FROM features_translations;    -- يجب أن يكون 30 (10 ميزات × 3 لغات)
SELECT COUNT(*) FROM facilities_translations;  -- يجب أن يكون 24 (8 مرافق × 3 لغات)
SELECT COUNT(*) FROM rooms_translations;       -- يجب أن يكون 18 (6 غرف × 3 لغات)
```

### 3. اختبار الترجمة
```sql
-- اختبر ترجمة مرفق
SELECT * FROM facilities_translations WHERE facility_id = 1;
```
**النتيجة المتوقعة**:
```
| id | facility_id | lang | name              | description                    |
|----|-------------|------|-------------------|--------------------------------|
| 1  | 1           | en   | Air Conditioning  | Climate control in all rooms   |
| 2  | 1           | ar   | تكييف هواء        | تحكم بالمناخ في جميع الغرف      |
| 3  | 1           | ku   | Klîma             | Kontrola hewayê li hemû odeyan |
```

---

## 🧪 الاختبار

### اختبار يدوي:
1. افتح: `http://localhost/std_2_hotel_system/facilities`
2. بدّل اللغة من القائمة العلوية
3. تحقق من ترجمة أسماء المرافق

### اختبار تلقائي:
```bash
php tests/automated_tests.php
```

**النتيجة المتوقعة**: 100% نجاح

---

## 🔧 استخدام النظام

### في ملفات العرض:

#### ترجمة اسم المرفق:
```php
<?php echo getTranslation('facilities_translations', $facility['id'], 'name', $facility['name']); ?>
```

#### ترجمة اسم الميزة:
```php
<?php echo getTranslation('features_translations', $feature['id'], 'name', $feature['name']); ?>
```

#### ترجمة اسم الغرفة:
```php
<?php echo getTranslation('rooms_translations', $room['id'], 'name', $room['name']); ?>
```

---

## 📝 الملفات التي تحتاج تحديث

### ✅ تم التحديث:
- [x] `views/pages/facilities.php`

### ⏳ تحتاج تحديث (اختياري):
- [ ] `views/pages/room_details.php`
- [ ] `views/pages/rooms.php`
- [ ] `views/pages/home.php`
- [ ] `views/pages/confirm_booking.php`
- [ ] `views/pages/payment.php`

**ملاحظة**: النظام القديم (`translateContent`) لا يزال يعمل، لكن النظام الجديد أفضل!

---

## 🐛 حل المشاكل

### المشكلة: "Table doesn't exist"
```bash
# الحل: أعد تشغيل schema_translations.sql
mysql -u root -p homework_std_ro_db < database/schema_translations.sql
```

### المشكلة: "No data found"
```bash
# الحل: أعد تشغيل seeder_translations.sql
mysql -u root -p homework_std_ro_db < database/seeder_translations.sql
```

### المشكلة: الترجمة لا تظهر
```sql
-- تحقق من وجود الترجمة
SELECT * FROM facilities_translations WHERE facility_id = 1 AND lang = 'ar';

-- إذا لم توجد، أضفها
INSERT INTO facilities_translations VALUES (NULL, 1, 'ar', 'تكييف هواء', 'تحكم بالمناخ');
```

---

## 📚 الوثائق الكاملة

- `database/TRANSLATIONS_README.md` - دليل شامل
- `TRANSLATION_SYSTEM_COMPARISON.md` - مقارنة الأنظمة
- `TRANSLATION_GUIDE.md` - دليل الاستخدام

---

## 🎯 الخطوات التالية

1. ✅ ثبّت النظام (تم!)
2. ✅ اختبر النظام
3. ⏳ حدّث ملفات العرض الأخرى (اختياري)
4. ⏳ أضف لوحة تحكم للترجمات (اختياري)

---

**ملاحظة**: النظام الجديد أفضل من القديم لأنه أكثر مرونة وأسهل في الصيانة! 🚀
