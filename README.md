# Vana Hotel Management System

نظام إدارة فندق احترافي مبني بـ PHP مع هيكلية طبقات واضحة (Layered Architecture).

## الهيكلية

```
std_2_hotel_system/
├── config/          # إعدادات التطبيق
├── core/            # الكلاسات الأساسية
├── models/          # طبقة البيانات
├── controllers/     # طبقة المنطق
├── views/           # طبقة العرض
├── public/          # الملفات العامة (نقطة الدخول)
├── routes/          # تعريف المسارات
├── helpers/         # دوال مساعدة
├── storage/         # التخزين (cache, logs)
└── bootstrap/       # تحميل التطبيق
```

## المزايا

✅ **فصل واضح بين الطبقات** (Separation of Concerns)  
✅ **أمان عالي** (Prepared Statements, CSRF Protection, Rate Limiting)  
✅ **أداء محسّن** (Caching, Bulk Queries, N+1 Fix)  
✅ **سهولة الصيانة** (Single Responsibility, DRY)  
✅ **قابلية التوسع** (Modular Structure)  
✅ **دعم متعدد اللغات** (AR, EN, KU)  
✅ **Dark Mode**  
✅ **Responsive Design**

## المتطلبات

- PHP 8.0+
- MySQL 5.7+
- Apache with mod_rewrite

## التثبيت

1. انسخ المشروع للمجلد `htdocs`
2. استورد قاعدة البيانات من `m_hotel.sql`
3. عدّل إعدادات قاعدة البيانات في `config/database.php`
4. تأكد من تفعيل `mod_rewrite` في Apache
5. افتح المتصفح على: `http://localhost/std_2_hotel_system/public/`

## الاستخدام

### للمستخدمين:
- التسجيل / تسجيل الدخول
- البحث عن الغرف
- حجز الغرف
- إدارة الحجوزات
- تقييم الغرف

### للأدمن:
- لوحة تحكم شاملة
- إدارة الغرف والحجوزات
- إدارة المستخدمين
- إحصائيات وتقارير

## الطبقات

### 1. Config Layer
- `database.php` - اتصال قاعدة البيانات
- `constants.php` - الثوابت
- `session.php` - إدارة الجلسات

### 2. Core Layer
- `Request.php` - معالجة الطلبات
- `Response.php` - الردود
- `Router.php` - التوجيه
- `Auth.php` - المصادقة
- `Validator.php` - التحقق من البيانات
- `Model.php` - الكلاس الأساسي للنماذج

### 3. Models Layer
- `User.php` - المستخدمين
- `Room.php` - الغرف
- `Booking.php` - الحجوزات
- `Review.php` - التقييمات
- `Admin.php` - الأدمن

### 4. Controllers Layer
- `AuthController.php` - التسجيل والدخول
- `HomeController.php` - الصفحات الرئيسية
- `RoomController.php` - الغرف
- `BookingController.php` - الحجوزات
- `UserController.php` - الملف الشخصي

### 5. Views Layer
- `layouts/` - القوالب الأساسية
- `pages/` - الصفحات
- `admin/` - صفحات الأدمن

## الأمان

- ✅ Prepared Statements (SQL Injection Protection)
- ✅ Password Hashing (bcrypt)
- ✅ Session Security
- ✅ Rate Limiting
- ✅ Input Validation & Sanitization
- ✅ CSRF Protection (قيد التطوير)
- ✅ XSS Protection

## الأداء

- ✅ File-based Caching
- ✅ Bulk Queries (N+1 Fix)
- ✅ Lazy Loading للصور
- ✅ Query Optimization

## الترخيص

هذا المشروع تعليمي ومفتوح المصدر.

## المطور

تم تطويره بواسطة Kiro AI 🚀
