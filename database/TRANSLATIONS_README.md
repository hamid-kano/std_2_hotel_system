# نظام الترجمة للمحتوى الديناميكي
# Translation System for Dynamic Content

## 🌍 نظرة عامة - Overview

هذا النظام يستخدم **جداول ترجمة منفصلة** لتخزين الترجمات للمحتوى الديناميكي (الغرف، المرافق، الميزات).

### ✅ المزايا:
1. **سهولة الإدارة**: المدير يمكنه إدخال البيانات بأي لغة
2. **مرونة عالية**: إضافة لغات جديدة بسهولة
3. **أداء أفضل**: استعلامات مباشرة من قاعدة البيانات
4. **بيانات منظمة**: فصل واضح بين البيانات والترجمات

---

## 📁 الملفات

### 1. `schema_translations.sql`
يحتوي على بنية جداول الترجمة:
- `features_translations` - ترجمات ميزات الغرف
- `facilities_translations` - ترجمات مرافق الفندق
- `rooms_translations` - ترجمات الغرف

### 2. `seeder_translations.sql`
يحتوي على بيانات الترجمة لجميع اللغات (عربي، إنجليزي، كردي)

---

## 🚀 التثبيت - Installation

### الخطوة 1: إنشاء جداول الترجمة
```bash
mysql -u root -p homework_std_ro_db < database/schema_translations.sql
```

### الخطوة 2: إدراج بيانات الترجمة
```bash
mysql -u root -p homework_std_ro_db < database/seeder_translations.sql
```

### الخطوة 3: اختبار النظام
افتح الموقع وبدّل اللغة - يجب أن ترى الترجمات تعمل!

---

## 💻 كيفية الاستخدام - Usage

### في ملفات العرض (Views):

#### ترجمة اسم المرفق:
```php
<?php echo getTranslation('facilities_translations', $facility['id'], 'name', $facility['name']); ?>
```

#### ترجمة وصف المرفق:
```php
<?php echo getTranslation('facilities_translations', $facility['id'], 'description', $facility['description']); ?>
```

#### ترجمة اسم الميزة:
```php
<?php echo getTranslation('features_translations', $feature['id'], 'name', $feature['name']); ?>
```

#### ترجمة اسم الغرفة:
```php
<?php echo getTranslation('rooms_translations', $room['id'], 'name', $room['name']); ?>
```

#### ترجمة وصف الغرفة:
```php
<?php echo getTranslation('rooms_translations', $room['id'], 'description', $room['description']); ?>
```

---

## 🔧 بنية الجداول - Table Structure

### features_translations
```sql
id              INT         Primary Key
feature_id      INT         Foreign Key → features(id)
lang            VARCHAR(5)  'ar', 'en', 'ku'
name            VARCHAR(100) الاسم المترجم
```

### facilities_translations
```sql
id              INT         Primary Key
facility_id     INT         Foreign Key → facilities(id)
lang            VARCHAR(5)  'ar', 'en', 'ku'
name            VARCHAR(100) الاسم المترجم
description     TEXT        الوصف المترجم
```

### rooms_translations
```sql
id              INT         Primary Key
room_id         INT         Foreign Key → rooms(id)
lang            VARCHAR(5)  'ar', 'en', 'ku'
name            VARCHAR(150) الاسم المترجم
description     TEXT        الوصف المترجم
```

---

## ➕ إضافة ترجمة جديدة

### مثال: إضافة مرفق جديد

#### 1. أضف المرفق في الجدول الأساسي:
```sql
INSERT INTO facilities (icon, name, description) VALUES 
('gym.svg', 'Gym', 'Fitness center');
-- سيحصل على ID تلقائياً، لنفترض ID = 9
```

#### 2. أضف الترجمات:
```sql
-- الإنجليزية
INSERT INTO facilities_translations (facility_id, lang, name, description) VALUES
(9, 'en', 'Gym', 'Fully equipped fitness center');

-- العربية
INSERT INTO facilities_translations (facility_id, lang, name, description) VALUES
(9, 'ar', 'صالة رياضية', 'مركز لياقة بدنية مجهز بالكامل');

-- الكردية
INSERT INTO facilities_translations (facility_id, lang, name, description) VALUES
(9, 'ku', 'Salona Werzişê', 'Navenda werzişê bi tevahî amade');
```

#### 3. استخدم في الكود:
```php
<?php echo getTranslation('facilities_translations', $facility['id'], 'name', $facility['name']); ?>
```

---

## 🎨 إضافة لغة جديدة

### مثال: إضافة اللغة الفرنسية (fr)

#### 1. أضف الترجمات لجميع المرافق:
```sql
INSERT INTO facilities_translations (facility_id, lang, name, description) VALUES
(1, 'fr', 'Climatisation', 'Contrôle climatique dans toutes les chambres'),
(2, 'fr', 'Spa & Bien-être', 'Centre de spa et bien-être complet'),
-- ... إلخ
```

#### 2. أضف اللغة في الإعدادات:
```php
// في config/constants.php
define('SUPPORTED_LANGS', ['ar', 'en', 'ku', 'fr']);
```

#### 3. أنشئ ملف اللغة:
```php
// في lang/fr.php
return [
    'home' => 'Accueil',
    'about' => 'À propos',
    // ... إلخ
];
```

---

## 🔍 دالة getTranslation()

### المعاملات (Parameters):
```php
getTranslation($table, $id, $field = 'name', $fallback = '')
```

- **$table**: اسم جدول الترجمة
  - `'features_translations'`
  - `'facilities_translations'`
  - `'rooms_translations'`

- **$id**: معرف العنصر (ID)

- **$field**: الحقل المراد ترجمته
  - `'name'` (افتراضي)
  - `'description'`

- **$fallback**: القيمة الاحتياطية إذا لم توجد ترجمة

### مثال كامل:
```php
// الحصول على اسم المرفق
$facilityName = getTranslation(
    'facilities_translations',  // الجدول
    $facility['id'],            // المعرف
    'name',                     // الحقل
    $facility['name']           // القيمة الاحتياطية
);

// الحصول على وصف المرفق
$facilityDesc = getTranslation(
    'facilities_translations',
    $facility['id'],
    'description',
    $facility['description']
);
```

---

## 📊 الملفات التي تحتاج تحديث

### ✅ تم التحديث:
- [x] `views/pages/facilities.php`

### ⏳ تحتاج تحديث:
- [ ] `views/pages/room_details.php`
- [ ] `views/pages/rooms.php`
- [ ] `views/pages/home.php`
- [ ] `views/pages/confirm_booking.php`
- [ ] `views/pages/payment.php`
- [ ] `views/pages/bookings.php`
- [ ] `views/admin/rooms.php`
- [ ] `views/admin/facilities.php`

---

## 🧪 الاختبار - Testing

### اختبار يدوي:
1. افتح صفحة المرافق: `/facilities`
2. بدّل اللغة من القائمة العلوية
3. تحقق من ترجمة أسماء ووصف المرافق

### اختبار تلقائي:
```bash
php tests/automated_tests.php
```

---

## 🔄 الترحيل من النظام القديم

إذا كنت تستخدم النظام القديم (`translateContent()`):

### قبل:
```php
<?php echo translateContent($facility['name']); ?>
```

### بعد:
```php
<?php echo getTranslation('facilities_translations', $facility['id'], 'name', $facility['name']); ?>
```

---

## 💡 نصائح وأفضل الممارسات

### 1. استخدم القيمة الاحتياطية دائماً
```php
// ✅ جيد
getTranslation('facilities_translations', $id, 'name', $facility['name'])

// ❌ سيء
getTranslation('facilities_translations', $id, 'name')
```

### 2. التخزين المؤقت (Caching)
الدالة تستخدم تخزين مؤقت تلقائي - لا حاجة للقلق!

### 3. الأداء
- الاستعلامات محسّنة مع indexes
- التخزين المؤقت يقلل استعلامات قاعدة البيانات
- استخدم `UNIQUE KEY` لمنع التكرار

### 4. إضافة ترجمات جديدة
دائماً أضف الترجمة لجميع اللغات المدعومة:
```sql
-- ✅ جيد - جميع اللغات
INSERT INTO facilities_translations VALUES
(10, 'en', 'Parking', 'Free parking'),
(10, 'ar', 'موقف سيارات', 'موقف مجاني'),
(10, 'ku', 'Parkirina', 'Parkirina belaş');

-- ❌ سيء - لغة واحدة فقط
INSERT INTO facilities_translations VALUES
(10, 'en', 'Parking', 'Free parking');
```

---

## 🐛 حل المشاكل - Troubleshooting

### المشكلة: الترجمة لا تظهر
**الحل**:
1. تحقق من وجود الترجمة في قاعدة البيانات:
```sql
SELECT * FROM facilities_translations WHERE facility_id = 1 AND lang = 'ar';
```

2. تحقق من اللغة الحالية:
```php
echo Session::getLang(); // يجب أن تكون 'ar', 'en', أو 'ku'
```

### المشكلة: خطأ في الاستعلام
**الحل**: تحقق من اسم الجدول والحقل:
```php
// ✅ صحيح
getTranslation('facilities_translations', $id, 'name', $fallback)

// ❌ خطأ
getTranslation('facility_translations', $id, 'name', $fallback)
```

---

## 📞 الدعم

للمزيد من المعلومات، راجع:
- `helpers/functions.php` - دالة `getTranslation()`
- `TRANSLATION_GUIDE.md` - دليل الترجمة الكامل
- `tests/TEST_PLAN.md` - خطة الاختبار

---

**ملاحظة**: هذا النظام أفضل من النظام القديم لأنه:
- ✅ أكثر مرونة
- ✅ أسهل في الإدارة
- ✅ أفضل أداءً
- ✅ أكثر قابلية للتوسع
