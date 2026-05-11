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