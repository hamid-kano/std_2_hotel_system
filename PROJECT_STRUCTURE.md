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
│   │   ├── AdminBaseController.php
│   │   ├── AdminBookingController.php
│   │   ├── AdminDashboardController.php
│   │   ├── AdminFacilityController.php
│   │   ├── AdminReviewController.php
│   │   ├── AdminRoomController.php
│   │   ├── AdminSettingsController.php
│   │   └── AdminUserController.php
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
│   ├── 📁 archive/           # ملفات قاعدة البيانات القديمة
│   │   ├── m_hotel.sql
│   │   ├── schema.sql
│   │   ├── schema_translations.sql
│   │   ├── seeder.sql
│   │   ├── seeder_translations.sql
│   │   ├── README.md
│   │   └── README_OLD.md
│   ├── install.sql           # ⭐ ملف التثبيت الكامل (schema + seed)
│   └── INSTALL.md            # دليل التثبيت
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
│   ├── 📁 assets/
│   │   ├── 📁 css/
│   │   │   └── style.css
│   │   └── 📁 js/
│   │       └── main.js
│   ├── 📁 images/
│   │   ├── 📁 about/         # صور صفحة من نحن
│   │   ├── 📁 carousel/      # صور الكاروسيل
│   │   ├── 📁 facilities/    # صور المرافق (SVG/PNG)
│   │   ├── 📁 rooms/         # صور الغرف
│   │   └── 📁 users/         # صور المستخدمين
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
│   ├── TEST_PLAN.md          # خطة الاختبار
│   ├── MANUAL_TESTING_GUIDE.md # دليل الاختبار اليدوي
│   ├── TEST_RESULTS_TEMPLATE.md # نموذج تقرير
│   └── README.md             # دليل الاختبارات
│
├── 📁 views/                  # ملفات العرض
│   ├── 📁 admin/             # صفحات لوحة التحكم
│   │   ├── 📁 partials/
│   │   │   └── room_form.php
│   │   ├── booking_records.php
│   │   ├── carousel.php
│   │   ├── dashboard.php
│   │   ├── facilities.php
│   │   ├── layout.php
│   │   ├── login.php
│   │   ├── new_bookings.php
│   │   ├── queries.php
│   │   ├── refund_bookings.php
│   │   ├── reviews.php
│   │   ├── room_images.php
│   │   ├── rooms.php
│   │   ├── settings.php
│   │   └── users.php
│   ├── 📁 auth/              # صفحات المصادقة
│   │   ├── 📁 partials/
│   │   │   └── topbar.php
│   │   ├── login.php
│   │   └── register.php
│   ├── 📁 errors/            # صفحات الأخطاء
│   │   ├── 404.php
│   │   └── 500.php
│   ├── 📁 layouts/           # القوالب المشتركة
│   │   ├── footer.php
│   │   ├── head.php
│   │   └── header.php
│   └── 📁 pages/             # الصفحات العامة
│       ├── about.php
│       ├── bookings.php
│       ├── confirm_booking.php
│       ├── contact.php
│       ├── facilities.php
│       ├── home.php
│       ├── payment.php
│       ├── payment_success.php
│       ├── profile.php
│       ├── room_details.php
│       └── rooms.php
│
├── .htaccess                  # ⭐ إعادة توجيه للمجلد public
├── .gitignore                 # ملفات Git المتجاهلة
├── DATABASE_MERGE_SUMMARY.md  # ملخص دمج قاعدة البيانات
├── PROJECT_STRUCTURE.md       # هذا الملف
└── README.md                  # دليل المشروع الرئيسي
```

## ملاحظات مهمة

- **نقطة الدخول:** `public/index.php` (يجب ضبط Document Root على مجلد `public/`)
- **قاعدة البيانات:** استخدم `database/install.sql` لتثبيت قاعدة البيانات كاملةً
