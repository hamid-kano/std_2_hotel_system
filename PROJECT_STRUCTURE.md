# هيكل المشروع - Project Structure
# نظام فندق فانا - Vana Hotel System

## 📁 الملفات والمجلدات الرئيسية

```
std_2_hotel_system/
├── 📁 bootstrap/              # تهيئة التطبيق
│   └── app.php               # ملف التهيئة الرئيسي
│
├── 📁 config/                 # ملفات الإعدادات
│   ├── constants.php         # الثوابت
│   ├── database.php          # إعدادات قاعدة البيانات
│   └── session.php           # إعدادات الجلسات
│
├── 📁 controllers/            # المتحكمات (Controllers)
│   ├── 📁 admin/             # متحكمات لوحة التحكم
│   ├── AuthController.php    # المصادقة
│   ├── BaseController.php    # المتحكم الأساسي
│   ├── BookingController.php # الحجوزات
│   ├── HomeController.php    # الصفحات العامة
│   ├── RoomController.php    # الغرف
│   └── UserController.php    # المستخدمين
│
├── 📁 core/                   # النواة الأساسية
│   ├── Auth.php              # نظام المصادقة
│   ├── Model.php             # النموذج الأساسي
│   ├── Request.php           # معالجة الطلبات
│   ├── Response.php          # معالجة الاستجابات
│   ├── Router.php            # نظام التوجيه
│   └── Validator.php         # التحقق من البيانات
│
├── 📁 database/               # قاعدة البيانات
│   ├── schema.sql            # ⭐ بنية قاعدة البيانات الأساسية
│   ├── seeder.sql            # ⭐ البيانات التجريبية
│   ├── schema_translations.sql  # ⭐ جداول الترجمة
│   ├── seeder_translations.sql  # ⭐ بيانات الترجمة
│   ├── README.md             # دليل قاعدة البيانات
│   ├── QUICK_START.md        # البدء السريع
│   └── TRANSLATIONS_README.md # دليل نظام الترجمة
│
├── 📁 helpers/                # الدوال المساعدة
│   ├── cache.php             # التخزين المؤقت
│   └── functions.php         # ⭐ الدوال العامة (تحتوي على getTranslation)
│
├── 📁 lang/                   # ملفات اللغات
│   ├── ar.php                # العربية
│   ├── en.php                # الإنجليزية
│   └── ku.php                # الكردية
│
├── 📁 models/                 # النماذج (Models)
│   ├── Admin.php             # المدير
│   ├── Booking.php           # الحجوزات
│   ├── Facility.php          # المرافق
│   ├── Review.php            # التقييمات
│   ├── Room.php              # الغرف
│   ├── Setting.php           # الإعدادات
│   └── User.php              # المستخدمين
│
├── 📁 public/                 # المجلد العام (Document Root)
│   ├── 📁 assets/            # الأصول (CSS, JS)
│   ├── 📁 images/            # الصور
│   ├── .htaccess             # إعدادات Apache
│   └── index.php             # نقطة الدخول
│
├── 📁 routes/                 # التوجيهات
│   └── web.php               # توجيهات الويب
│
├── 📁 storage/                # التخزين
│   ├── 📁 cache/             # الملفات المؤقتة
│   └── 📁 logs/              # السجلات
│
├── 📁 tests/                  # الاختبارات
│   ├── automated_tests.php   # ⭐ الاختبارات التلقائية
│   ├── TEST_PLAN.md          # خطة الاختبار (107 حالة)
│   ├── MANUAL_TESTING_GUIDE.md # دليل الاختبار اليدوي
│   ├── TEST_RESULTS_TEMPLATE.md # نموذج تقرير
│   └── README.md             # دليل الاختبارات
│
├── 📁 views/                  # ملفات العرض
│   ├── 📁 admin/             # صفحات لوحة التحكم
│   ├── 📁 auth/              # صفحات المصادقة
│   ├── 📁 errors/            # صفحات الأخطاء
│   ├── 📁 layouts/           # القوالب
│   └── 📁 pages/             # الصفحات العامة
│
├── .htaccess                  # ⭐ إعادة توجيه للمجلد public
├── .gitignore                 # ملفات Git المتجاهلة
│
├── 📄 README.md               # دليل المشروع الرئيسي
├── 📄 RUN_TESTS.md            # ⭐ دليل تشغيل الاختبارات
├── 📄 TESTING_SUMMARY.md      # ⭐ ملخص الاختبار
│
├── 📄 INSTALL_TRANSLATIONS.md # ⭐ دليل تثبيت نظام الترجمة
├── 📄 TRANSLATION_GUIDE.md    # دليل استخدام الترجمة
└── 📄 TRANSLATION_SYSTEM_COMPARISON.md # مقارنة أنظمة الترجمة
```

---

## ⭐ الملفات المهمة

### للبدء السريع:
1. `database/QUICK_START.md` - دليل البدء السريع
2. `RUN_TESTS.md` - كيفية تشغيل الاختبارات
3. `INSTALL_TRANSLATIONS.md` - تثبيت نظام الترجمة

### للتطوير:
1. `helpers/functions.php` - الدوال المساعدة (تحتوي على `getTranslation()`)
2. `routes/web.php` - جميع المسارات
3. `config/constants.php` - الثوابت والإعدادات

### للاختبار:
1. `tests/automated_tests.php` - الاختبارات التلقائية
2. `tests/TEST_PLAN.md` - خطة الاختبار الشاملة (107 حالة)
3. `tests/MANUAL_TESTING_GUIDE.md` - دليل الاختبار اليدوي

### قاعدة البيانات:
1. `database/schema.sql` - البنية الأساسية (17 جدول)
2. `database/seeder.sql` - البيانات التجريبية
3. `database/schema_translations.sql` - جداول الترجمة (3 جداول)
4. `database/seeder_translations.sql` - بيانات الترجمة

---

## 🚀 البدء السريع

### 1. إعداد قاعدة البيانات:
```bash
mysql -u root -p -e "CREATE DATABASE homework_std_ro_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p homework_std_ro_db < database/schema.sql
mysql -u root -p homework_std_ro_db < database/seeder.sql
mysql -u root -p homework_std_ro_db < database/schema_translations.sql
mysql -u root -p homework_std_ro_db < database/seeder_translations.sql
```

### 2. تشغيل الاختبارات:
```bash
php tests/automated_tests.php
```

### 3. فتح الموقع:
```
http://localhost/std_2_hotel_system/
```

---

## 🌍 نظام الترجمة

### الترجمات الثابتة (Static):
```php
<?php echo lang('home'); ?>  // الرئيسية / Home / Malper
```

### الترجمات الديناميكية (Dynamic):
```php
<?php echo getTranslation('facilities_translations', $facility['id'], 'name', $facility['name']); ?>
```

**راجع**: `INSTALL_TRANSLATIONS.md` للتفاصيل

---

## 🧪 الاختبار

### اختبار تلقائي:
```bash
php tests/automated_tests.php
```

### اختبار يدوي:
راجع `tests/MANUAL_TESTING_GUIDE.md`

---

## 📊 الإحصائيات

- **عدد الجداول**: 20 (17 أساسية + 3 ترجمة)
- **عدد Controllers**: 12
- **عدد Models**: 7
- **عدد Routes**: ~50
- **اللغات المدعومة**: 3 (عربي، إنجليزي، كردي)
- **حالات الاختبار**: 107
- **معدل نجاح الاختبارات**: 100%

---

## 🔧 التقنيات المستخدمة

- **Backend**: PHP 8.2+
- **Database**: MySQL 5.7+
- **Frontend**: Bootstrap 5.3, JavaScript
- **Architecture**: MVC Pattern
- **Routing**: Custom Router
- **ORM**: Custom Model Layer
- **Authentication**: Session-based
- **Caching**: File-based Cache
- **Testing**: Custom Test Suite

---

## 📞 الدعم

للمزيد من المعلومات، راجع:
- `README.md` - دليل المشروع الرئيسي
- `database/README.md` - دليل قاعدة البيانات
- `tests/README.md` - دليل الاختبارات
- `database/TRANSLATIONS_README.md` - دليل نظام الترجمة

---

**آخر تحديث**: 2026-05-09
