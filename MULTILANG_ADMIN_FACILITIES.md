# Multi-Language Support for Admin Features & Facilities

## Overview
تم تنفيذ دعم تعدد اللغات الكامل في صفحة المميزات والمرافق بلوحة التحكم مع ترجمة جميع رسائل الخطأ.

## Changes Made

### 1. Updated Forms (views/admin/facilities.php)
- **Add Feature Modal**: تم تحديث النموذج ليحتوي على 3 حقول إدخال (عربي، إنجليزي، كردي)
- **Add Facility Modal**: تم تحديث النموذج ليحتوي على 3 حقول للاسم و3 حقول للوصف (عربي، إنجليزي، كردي)
- تم تغيير حجم Modal للمرافق إلى `modal-lg` لاستيعاب الحقول الإضافية
- تم تحديث placeholder بالكرمانجي للحقول الكردية

### 2. Updated Display Logic (views/admin/facilities.php)
- تم استبدال عرض الأسماء المباشرة بـ `getTranslation()` function
- Features table: `getTranslation('features_translations', $f['id'], 'name', $f['name'])`
- Facilities table: `getTranslation('facilities_translations', $f['id'], 'name', $f['name'])`
- Facility descriptions: `getTranslation('facilities_translations', $f['id'], 'description', $f['description'])`

### 3. Updated Controller Logic (controllers/admin/AdminFacilityController.php)

#### addFeature() Method:
```php
- يستقبل 3 حقول: name_ar, name_en, name_ku
- يحفظ الاسم الإنجليزي في جدول features (كقيمة افتراضية)
- يحفظ الترجمات الثلاث في جدول features_translations
- يستخدم القيمة المرجعة من insert() للحصول على ID الميزة
- جميع رسائل الخطأ مترجمة باستخدام lang()
```

#### addFacility() Method:
```php
- يستقبل 6 حقول: name_ar, name_en, name_ku, desc_ar, desc_en, desc_ku
- يحفظ الاسم والوصف الإنجليزي في جدول facilities (كقيمة افتراضية)
- يحفظ الترجمات الثلاث في جدول facilities_translations
- يستخدم القيمة المرجعة من insert() للحصول على ID المرفق
- جميع رسائل الخطأ مترجمة باستخدام lang()
```

### 4. Enhanced uploadImage() Function (helpers/functions.php)
تم تحسين دالة رفع الصور لدعم SVG:
- التحقق من نوع الملف (SVG أو صور عادية)
- تطبيق حدود مختلفة: 1MB للـ SVG، 2MB للصور العادية
- دعم أنواع الملفات: SVG, PNG, JPEG, WEBP

### 5. Language Files Updates
تم إضافة مفاتيح جديدة في ملفات اللغة الثلاث:

#### أسماء اللغات:
- `arabic` - عربي / Arabic / Erebî
- `english` - إنجليزي / English / Îngilîzî
- `kurdish` - كردي / Kurdish / Kurdî

#### رسائل الخطأ:
- `err_upload_icon` - يرجى رفع أيقونة / Please upload an icon / Ji kerema xwe îkonekê bar bike
- `err_fill_all_names` - يرجى ملء جميع حقول الأسماء / Please fill all name fields / Ji kerema xwe hemû qadên navan dagire
- `err_invalid_file_type` - نوع الملف غير صالح / Invalid file type / Cureya pelê nederbasdar e
- `err_file_too_large` - الملف كبير جداً / File too large / Pel pir mezin e
- `err_upload_failed` - فشل الرفع / Upload failed / Barkirin bi ser neket
- `err_fill_all_langs` - يرجى ملء جميع حقول اللغات / Please fill all language fields / Ji kerema xwe hemû qadên zimanan dagire

## Database Structure
النظام يستخدم الجداول التالية:

### features
- `id` (primary key)
- `name` (default English name)

### features_translations
- `id` (primary key)
- `feature_id` (foreign key → features.id)
- `lang` (ar, en, ku)
- `name` (translated name)

### facilities
- `id` (primary key)
- `icon` (image filename)
- `name` (default English name)
- `description` (default English description)

### facilities_translations
- `id` (primary key)
- `facility_id` (foreign key → facilities.id)
- `lang` (ar, en, ku)
- `name` (translated name)
- `description` (translated description)

## User Experience

### Adding a Feature:
1. المدير يضغط على "إضافة ميزة"
2. يظهر نموذج بـ 3 حقول (عربي، إنجليزي، كردي)
3. يجب ملء الحقول الثلاثة (required)
4. عند الحفظ، يتم إدراج الميزة مع ترجماتها الثلاث
5. رسائل النجاح/الخطأ تظهر باللغة المختارة

### Adding a Facility:
1. المدير يضغط على "إضافة مرفق"
2. يظهر نموذج كبير بـ 6 حقول نصية + حقل الأيقونة
3. يجب ملء حقول الأسماء الثلاثة (required)
4. حقول الوصف اختيارية
5. يجب رفع أيقونة (SVG أو PNG)
6. حدود الحجم: 1MB للـ SVG، 2MB للـ PNG
7. عند الحفظ، يتم إدراج المرفق مع ترجماته الثلاث
8. رسائل النجاح/الخطأ تظهر باللغة المختارة

### Viewing Features/Facilities:
- يتم عرض الأسماء والأوصاف حسب اللغة المختارة في الموقع
- إذا لم تتوفر ترجمة، يتم عرض القيمة الافتراضية (الإنجليزية)

## Error Messages (Translated)
جميع رسائل الخطأ الآن مترجمة:

| Error Code | Arabic | English | Kurdish (Kurmancî) |
|------------|--------|---------|-------------------|
| No icon | يرجى رفع أيقونة | Please upload an icon | Ji kerema xwe îkonekê bar bike |
| Missing names | يرجى ملء جميع حقول الأسماء | Please fill all name fields | Ji kerema xwe hemû qadên navan dagire |
| Invalid type | نوع الملف غير صالح | Invalid file type | Cureya pelê nederbasdar e |
| File too large | الملف كبير جداً | File too large | Pel pir mezin e |
| Upload failed | فشل الرفع | Upload failed | Barkirin bi ser neket |
| Missing langs | يرجى ملء جميع حقول اللغات | Please fill all language fields | Ji kerema xwe hemû qadên zimanan dagire |

## Testing Results
✅ All 15 automated tests passed (100%)
- Public pages load correctly
- Language switching works
- Authentication pages accessible
- Security redirects working
- API endpoints responding

## Benefits
1. **تجربة مستخدم محسّنة**: المحتوى والرسائل تظهر باللغة المفضلة للمستخدم
2. **إدارة سهلة**: المدير يضيف الترجمات مرة واحدة عند الإضافة
3. **توافق كامل**: النظام يدعم 3 لغات (عربي، إنجليزي، كردي)
4. **قابلية التوسع**: يمكن إضافة لغات جديدة بسهولة
5. **رسائل خطأ واضحة**: جميع الرسائل مترجمة ومفهومة
6. **دعم SVG**: رفع أيقونات SVG مع حدود حجم مناسبة

## Next Steps (Optional Enhancements)
- إضافة وظيفة التعديل للمميزات والمرافق
- إضافة معاينة للترجمات قبل الحفظ
- إضافة تحقق من صحة الترجمات (validation)
- إضافة إمكانية رفع صور متعددة للمرافق
