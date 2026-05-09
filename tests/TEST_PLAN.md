# خطة اختبار شاملة - Vana Hotel System
# Complete Test Plan - Vana Hotel System

## 📋 نظرة عامة - Overview

هذا المستند يحتوي على خطة اختبار شاملة لجميع وظائف النظام.

---

## 🔐 1. نظام المصادقة - Authentication System

### 1.1 تسجيل دخول المستخدم - User Login
- [ ] **UC-AUTH-001**: تسجيل دخول بإيميل صحيح وكلمة مرور صحيحة
  - URL: `/login` → POST `/api/auth/login`
  - البيانات: `email=ahmed@demo.com`, `password=password123`
  - النتيجة المتوقعة: تسجيل دخول ناجح + إعادة توجيه للصفحة الرئيسية

- [ ] **UC-AUTH-002**: تسجيل دخول برقم هاتف صحيح وكلمة مرور صحيحة
  - البيانات: `email=07501111111`, `password=password123`
  - النتيجة المتوقعة: تسجيل دخول ناجح

- [ ] **UC-AUTH-003**: تسجيل دخول بكلمة مرور خاطئة
  - البيانات: `email=ahmed@demo.com`, `password=wrongpass`
  - النتيجة المتوقعة: رسالة خطأ "Invalid credentials"

- [ ] **UC-AUTH-004**: تسجيل دخول بإيميل غير موجود
  - البيانات: `email=notexist@demo.com`, `password=password123`
  - النتيجة المتوقعة: رسالة خطأ

### 1.2 تسجيل مستخدم جديد - User Registration
- [ ] **UC-AUTH-005**: تسجيل مستخدم جديد ببيانات صحيحة
  - URL: `/register` → POST `/api/auth/register`
  - البيانات: اسم، إيميل جديد، رقم هاتف جديد، عنوان، رمز بريدي، تاريخ ميلاد، كلمة مرور
  - النتيجة المتوقعة: تسجيل ناجح + رسالة نجاح

- [ ] **UC-AUTH-006**: تسجيل بإيميل مستخدم مسبقاً
  - البيانات: `email=ahmed@demo.com`
  - النتيجة المتوقعة: رسالة خطأ "Email already exists"

- [ ] **UC-AUTH-007**: تسجيل برقم هاتف مستخدم مسبقاً
  - البيانات: `phonenum=07501111111`
  - النتيجة المتوقعة: رسالة خطأ "Phone already exists"

### 1.3 تسجيل دخول المدير - Admin Login
- [ ] **UC-AUTH-008**: تسجيل دخول المدير ببيانات صحيحة
  - URL: `/admin/login` → POST `/admin/login`
  - البيانات: `admin_name=admin`, `admin_pass=admin123`
  - النتيجة المتوقعة: تسجيل دخول ناجح + إعادة توجيه للوحة التحكم

- [ ] **UC-AUTH-009**: تسجيل دخول المدير ببيانات خاطئة
  - البيانات: `admin_name=admin`, `admin_pass=wrongpass`
  - النتيجة المتوقعة: رسالة خطأ "Invalid credentials"

### 1.4 تسجيل الخروج - Logout
- [ ] **UC-AUTH-010**: تسجيل خروج المستخدم
  - URL: `/logout`
  - النتيجة المتوقعة: تسجيل خروج + إعادة توجيه للصفحة الرئيسية

- [ ] **UC-AUTH-011**: تسجيل خروج المدير
  - URL: `/admin/logout`
  - النتيجة المتوقعة: تسجيل خروج + إعادة توجيه لصفحة تسجيل دخول المدير

---

## 🏠 2. الصفحات العامة - Public Pages

### 2.1 الصفحة الرئيسية - Home Page
- [ ] **UC-HOME-001**: عرض الصفحة الرئيسية
  - URL: `/` أو `/home`
  - النتيجة المتوقعة: عرض carousel، غرف مميزة، مرافق، تقييمات

### 2.2 صفحة من نحن - About Page
- [ ] **UC-HOME-002**: عرض صفحة من نحن
  - URL: `/about`
  - النتيجة المتوقعة: عرض معلومات الفندق + فريق العمل

### 2.3 صفحة المرافق - Facilities Page
- [ ] **UC-HOME-003**: عرض صفحة المرافق
  - URL: `/facilities`
  - النتيجة المتوقعة: عرض جميع مرافق الفندق

### 2.4 صفحة الاتصال - Contact Page
- [ ] **UC-HOME-004**: عرض صفحة الاتصال
  - URL: `/contact`
  - النتيجة المتوقعة: عرض نموذج الاتصال + معلومات التواصل

- [ ] **UC-HOME-005**: إرسال رسالة عبر نموذج الاتصال
  - URL: POST `/contact`
  - البيانات: `name`, `email`, `subject`, `message`
  - النتيجة المتوقعة: حفظ الرسالة في قاعدة البيانات + رسالة نجاح

### 2.5 تبديل اللغة - Language Switcher
- [ ] **UC-HOME-006**: تبديل اللغة إلى العربية
  - URL: `/set-lang?lang=ar`
  - النتيجة المتوقعة: تغيير اللغة + إعادة توجيه

- [ ] **UC-HOME-007**: تبديل اللغة إلى الإنجليزية
  - URL: `/set-lang?lang=en`
  - النتيجة المتوقعة: تغيير اللغة + إعادة توجيه

- [ ] **UC-HOME-008**: تبديل اللغة إلى الكردية
  - URL: `/set-lang?lang=ku`
  - النتيجة المتوقعة: تغيير اللغة + إعادة توجيه

---

## 🛏️ 3. نظام الغرف - Rooms System

### 3.1 عرض الغرف - View Rooms
- [ ] **UC-ROOM-001**: عرض جميع الغرف
  - URL: `/rooms`
  - النتيجة المتوقعة: عرض قائمة الغرف المتاحة

- [ ] **UC-ROOM-002**: عرض تفاصيل غرفة محددة
  - URL: `/room/1`
  - النتيجة المتوقعة: عرض تفاصيل الغرفة + الصور + المرافق + التقييمات

### 3.2 البحث عن الغرف - Search Rooms
- [ ] **UC-ROOM-003**: البحث عن غرف حسب عدد الأشخاص
  - URL: `/api/rooms/search?adults=2&children=1`
  - النتيجة المتوقعة: عرض الغرف المناسبة فقط

- [ ] **UC-ROOM-004**: البحث بدون نتائج
  - URL: `/api/rooms/search?adults=10&children=5`
  - النتيجة المتوقعة: رسالة "لا توجد غرف متاحة"

---

## 📅 4. نظام الحجوزات - Booking System

### 4.1 إنشاء حجز - Create Booking
- [ ] **UC-BOOK-001**: التحقق من توفر غرفة
  - URL: POST `/api/booking/check-availability`
  - البيانات: `room_id`, `check_in`, `check_out`
  - النتيجة المتوقعة: رسالة توفر أو عدم توفر

- [ ] **UC-BOOK-002**: تأكيد الحجز (بدون تسجيل دخول)
  - URL: `/booking/confirm`
  - النتيجة المتوقعة: إعادة توجيه لصفحة تسجيل الدخول

- [ ] **UC-BOOK-003**: تأكيد الحجز (مع تسجيل دخول)
  - URL: `/booking/confirm?room_id=1&check_in=2026-06-01&check_out=2026-06-05`
  - النتيجة المتوقعة: عرض صفحة تأكيد الحجز

- [ ] **UC-BOOK-004**: معالجة الدفع
  - URL: POST `/api/booking/process-payment`
  - البيانات: `room_id`, `check_in`, `check_out`, `name`, `phone`, `address`
  - النتيجة المتوقعة: إنشاء حجز + خصم من الرصيد + إعادة توجيه لصفحة النجاح

- [ ] **UC-BOOK-005**: محاولة الحجز برصيد غير كافٍ
  - النتيجة المتوقعة: رسالة خطأ "رصيد غير كافٍ"

### 4.2 عرض الحجوزات - View Bookings
- [ ] **UC-BOOK-006**: عرض حجوزات المستخدم
  - URL: `/bookings`
  - النتيجة المتوقعة: عرض قائمة حجوزات المستخدم

### 4.3 إلغاء حجز - Cancel Booking
- [ ] **UC-BOOK-007**: إلغاء حجز نشط
  - URL: POST `/api/booking/cancel`
  - البيانات: `booking_id`
  - النتيجة المتوقعة: إلغاء الحجز + تحديث الحالة

### 4.4 تقييم الحجز - Review Booking
- [ ] **UC-BOOK-008**: إضافة تقييم لحجز مكتمل
  - URL: POST `/api/booking/review`
  - البيانات: `booking_id`, `rating`, `review`
  - النتيجة المتوقعة: حفظ التقييم + تحديث حالة الحجز

---

## 👤 5. نظام الملف الشخصي - User Profile System

### 5.1 عرض الملف الشخصي - View Profile
- [ ] **UC-PROF-001**: عرض صفحة الملف الشخصي
  - URL: `/profile`
  - النتيجة المتوقعة: عرض معلومات المستخدم + الرصيد

### 5.2 تحديث الملف الشخصي - Update Profile
- [ ] **UC-PROF-002**: تحديث المعلومات الشخصية
  - URL: POST `/api/user/update-profile`
  - البيانات: `name`, `email`, `phonenum`, `address`
  - النتيجة المتوقعة: تحديث البيانات + رسالة نجاح

- [ ] **UC-PROF-003**: تحديث كلمة المرور
  - URL: POST `/api/user/update-password`
  - البيانات: `old_password`, `new_password`, `confirm_password`
  - النتيجة المتوقعة: تحديث كلمة المرور + رسالة نجاح

- [ ] **UC-PROF-004**: تحديث الصورة الشخصية
  - URL: POST `/api/user/update-avatar`
  - البيانات: `profile_img` (file)
  - النتيجة المتوقعة: رفع الصورة + تحديث المسار

### 5.3 إدارة الرصيد - Balance Management
- [ ] **UC-PROF-005**: إضافة رصيد
  - URL: POST `/api/user/add-balance`
  - البيانات: `amount`
  - النتيجة المتوقعة: زيادة الرصيد + رسالة نجاح

---

## 🔧 6. لوحة تحكم المدير - Admin Dashboard

### 6.1 لوحة التحكم الرئيسية - Main Dashboard
- [ ] **UC-ADMIN-001**: عرض لوحة التحكم
  - URL: `/admin/dashboard`
  - النتيجة المتوقعة: عرض الإحصائيات + الحجوزات الجديدة + التقييمات

- [ ] **UC-ADMIN-002**: تصفية الإحصائيات حسب الفترة
  - URL: POST `/admin/dashboard`
  - البيانات: `period=1` (30 يوم)
  - النتيجة المتوقعة: عرض إحصائيات آخر 30 يوم

### 6.2 إدارة الحجوزات - Bookings Management
- [ ] **UC-ADMIN-003**: عرض الحجوزات الجديدة
  - URL: `/admin/bookings/new`
  - النتيجة المتوقعة: عرض الحجوزات التي لم يتم تعيين غرفة لها

- [ ] **UC-ADMIN-004**: تعيين رقم غرفة لحجز
  - URL: POST `/admin/bookings/assign`
  - البيانات: `booking_id`, `room_no`
  - النتيجة المتوقعة: تحديث رقم الغرفة + تأكيد الوصول

- [ ] **UC-ADMIN-005**: إلغاء حجز
  - URL: POST `/admin/bookings/cancel`
  - البيانات: `booking_id`
  - النتيجة المتوقعة: إلغاء الحجز

- [ ] **UC-ADMIN-006**: عرض طلبات الاسترداد
  - URL: `/admin/bookings/refunds`
  - النتيجة المتوقعة: عرض الحجوزات الملغاة التي تحتاج استرداد

- [ ] **UC-ADMIN-007**: معالجة استرداد
  - URL: POST `/admin/bookings/refund`
  - البيانات: `booking_id`
  - النتيجة المتوقعة: إرجاع المبلغ للمستخدم + تحديث الحالة

- [ ] **UC-ADMIN-008**: عرض سجل الحجوزات
  - URL: `/admin/bookings/records`
  - النتيجة المتوقعة: عرض جميع الحجوزات المكتملة

- [ ] **UC-ADMIN-009**: البحث في سجل الحجوزات
  - URL: `/admin/bookings/records?search=ahmed`
  - النتيجة المتوقعة: عرض الحجوزات المطابقة للبحث

### 6.3 إدارة الغرف - Rooms Management
- [ ] **UC-ADMIN-010**: عرض جميع الغرف
  - URL: `/admin/rooms`
  - النتيجة المتوقعة: عرض قائمة الغرف

- [ ] **UC-ADMIN-011**: إضافة غرفة جديدة
  - URL: POST `/admin/rooms/add`
  - البيانات: `name`, `area`, `price`, `quantity`, `adult`, `children`, `description`, `features[]`, `facilities[]`
  - النتيجة المتوقعة: إضافة الغرفة + رسالة نجاح

- [ ] **UC-ADMIN-012**: تعديل غرفة
  - URL: POST `/admin/rooms/edit`
  - البيانات: `room_id`, بيانات محدثة
  - النتيجة المتوقعة: تحديث الغرفة + رسالة نجاح

- [ ] **UC-ADMIN-013**: تفعيل/تعطيل غرفة
  - URL: POST `/admin/rooms/toggle`
  - البيانات: `room_id`, `status`
  - النتيجة المتوقعة: تغيير حالة الغرفة

- [ ] **UC-ADMIN-014**: حذف غرفة (soft delete)
  - URL: POST `/admin/rooms/remove`
  - البيانات: `room_id`
  - النتيجة المتوقعة: وضع علامة حذف على الغرفة

### 6.4 إدارة صور الغرف - Room Images Management
- [ ] **UC-ADMIN-015**: عرض صور غرفة
  - URL: `/admin/rooms/1/images`
  - النتيجة المتوقعة: عرض جميع صور الغرفة

- [ ] **UC-ADMIN-016**: إضافة صورة لغرفة
  - URL: POST `/admin/rooms/1/images/add`
  - البيانات: `image` (file)
  - النتيجة المتوقعة: رفع الصورة + إضافتها للغرفة

- [ ] **UC-ADMIN-017**: تعيين صورة مصغرة
  - URL: POST `/admin/rooms/1/images/thumb`
  - البيانات: `image_id`
  - النتيجة المتوقعة: تعيين الصورة كمصغرة

- [ ] **UC-ADMIN-018**: حذف صورة
  - URL: POST `/admin/rooms/1/images/remove`
  - البيانات: `image_id`
  - النتيجة المتوقعة: حذف الصورة من السيرفر وقاعدة البيانات

### 6.5 إدارة المستخدمين - Users Management
- [ ] **UC-ADMIN-019**: عرض جميع المستخدمين
  - URL: `/admin/users`
  - النتيجة المتوقعة: عرض قائمة المستخدمين

- [ ] **UC-ADMIN-020**: تفعيل/تعطيل مستخدم
  - URL: POST `/admin/users/toggle`
  - البيانات: `user_id`, `status`
  - النتيجة المتوقعة: تغيير حالة المستخدم

- [ ] **UC-ADMIN-021**: حذف مستخدم
  - URL: POST `/admin/users/remove`
  - البيانات: `user_id`
  - النتيجة المتوقعة: حذف المستخدم

### 6.6 إدارة المرافق والميزات - Facilities & Features Management
- [ ] **UC-ADMIN-022**: عرض المرافق والميزات
  - URL: `/admin/facilities`
  - النتيجة المتوقعة: عرض قوائم المرافق والميزات

- [ ] **UC-ADMIN-023**: إضافة ميزة جديدة
  - URL: POST `/admin/features/add`
  - البيانات: `name`
  - النتيجة المتوقعة: إضافة الميزة + رسالة نجاح

- [ ] **UC-ADMIN-024**: حذف ميزة
  - URL: POST `/admin/features/remove`
  - البيانات: `feature_id`
  - النتيجة المتوقعة: حذف الميزة

- [ ] **UC-ADMIN-025**: إضافة مرفق جديد
  - URL: POST `/admin/facilities/add`
  - البيانات: `name`, `description`, `icon` (file)
  - النتيجة المتوقعة: إضافة المرفق + رسالة نجاح

- [ ] **UC-ADMIN-026**: حذف مرفق
  - URL: POST `/admin/facilities/remove`
  - البيانات: `facility_id`
  - النتيجة المتوقعة: حذف المرفق

### 6.7 إدارة التقييمات والاستفسارات - Reviews & Queries Management
- [ ] **UC-ADMIN-027**: عرض التقييمات
  - URL: `/admin/reviews`
  - النتيجة المتوقعة: عرض جميع التقييمات

- [ ] **UC-ADMIN-028**: وضع علامة "تم القراءة" على تقييم
  - URL: POST `/admin/reviews/seen`
  - البيانات: `review_id`
  - النتيجة المتوقعة: تحديث حالة التقييم

- [ ] **UC-ADMIN-029**: عرض الاستفسارات
  - URL: `/admin/queries`
  - النتيجة المتوقعة: عرض جميع رسائل الاتصال

- [ ] **UC-ADMIN-030**: وضع علامة "تم القراءة" على استفسار
  - URL: POST `/admin/queries/seen`
  - البيانات: `query_id`
  - النتيجة المتوقعة: تحديث حالة الاستفسار

### 6.8 إدارة الإعدادات - Settings Management
- [ ] **UC-ADMIN-031**: عرض صفحة الإعدادات
  - URL: `/admin/settings`
  - النتيجة المتوقعة: عرض الإعدادات العامة + معلومات الاتصال + فريق العمل

- [ ] **UC-ADMIN-032**: تحديث الإعدادات العامة
  - URL: POST `/admin/settings/general`
  - البيانات: `site_title`, `site_about`
  - النتيجة المتوقعة: تحديث الإعدادات + رسالة نجاح

- [ ] **UC-ADMIN-033**: تحديث معلومات الاتصال
  - URL: POST `/admin/settings/contacts`
  - البيانات: `address`, `gmap`, `pn1`, `pn2`, `email`, `fb`, `insta`, `tw`, `iframe`
  - النتيجة المتوقعة: تحديث المعلومات + رسالة نجاح

- [ ] **UC-ADMIN-034**: إضافة عضو فريق
  - URL: POST `/admin/settings/member/add`
  - البيانات: `name`, `picture` (file)
  - النتيجة المتوقعة: إضافة العضو + رسالة نجاح

- [ ] **UC-ADMIN-035**: حذف عضو فريق
  - URL: POST `/admin/settings/member/remove`
  - البيانات: `member_id`
  - النتيجة المتوقعة: حذف العضو + حذف الصورة

### 6.9 إدارة Carousel - Carousel Management
- [ ] **UC-ADMIN-036**: عرض صور Carousel
  - URL: `/admin/carousel`
  - النتيجة المتوقعة: عرض جميع صور Carousel

- [ ] **UC-ADMIN-037**: إضافة صورة Carousel
  - URL: POST `/admin/carousel/add`
  - البيانات: `image` (file)
  - النتيجة المتوقعة: رفع الصورة + إضافتها

- [ ] **UC-ADMIN-038**: حذف صورة Carousel
  - URL: POST `/admin/carousel/remove`
  - البيانات: `carousel_id`
  - النتيجة المتوقعة: حذف الصورة

---

## 🔒 7. اختبارات الأمان - Security Tests

### 7.1 حماية المسارات - Route Protection
- [ ] **UC-SEC-001**: محاولة الوصول لصفحة حجوزات بدون تسجيل دخول
  - URL: `/bookings`
  - النتيجة المتوقعة: إعادة توجيه لصفحة تسجيل الدخول

- [ ] **UC-SEC-002**: محاولة الوصول للوحة التحكم بدون تسجيل دخول مدير
  - URL: `/admin/dashboard`
  - النتيجة المتوقعة: إعادة توجيه لصفحة تسجيل دخول المدير

### 7.2 التحقق من الصلاحيات - Authorization Tests
- [ ] **UC-SEC-003**: محاولة إلغاء حجز مستخدم آخر
  - النتيجة المتوقعة: رفض العملية

- [ ] **UC-SEC-004**: محاولة تعديل ملف شخصي لمستخدم آخر
  - النتيجة المتوقعة: رفض العملية

### 7.3 SQL Injection Tests
- [ ] **UC-SEC-005**: محاولة SQL injection في تسجيل الدخول
  - البيانات: `email=' OR '1'='1`, `password=anything`
  - النتيجة المتوقعة: فشل تسجيل الدخول (استخدام prepared statements)

### 7.4 XSS Tests
- [ ] **UC-SEC-006**: محاولة XSS في نموذج الاتصال
  - البيانات: `message=<script>alert('XSS')</script>`
  - النتيجة المتوقعة: تنظيف البيانات قبل العرض

---

## 📊 8. اختبارات الأداء - Performance Tests

- [ ] **UC-PERF-001**: قياس وقت تحميل الصفحة الرئيسية
- [ ] **UC-PERF-002**: قياس وقت البحث عن الغرف
- [ ] **UC-PERF-003**: اختبار التخزين المؤقت (Cache)
- [ ] **UC-PERF-004**: اختبار تحميل الصور

---

## 🌐 9. اختبارات التوافق - Compatibility Tests

- [ ] **UC-COMP-001**: اختبار على Chrome
- [ ] **UC-COMP-002**: اختبار على Firefox
- [ ] **UC-COMP-003**: اختبار على Safari
- [ ] **UC-COMP-004**: اختبار على الهاتف المحمول
- [ ] **UC-COMP-005**: اختبار اللغة العربية (RTL)
- [ ] **UC-COMP-006**: اختبار اللغة الإنجليزية (LTR)
- [ ] **UC-COMP-007**: اختبار اللغة الكردية

---

## 📝 ملاحظات الاختبار - Testing Notes

### بيانات الاختبار - Test Data
- **Admin**: `admin` / `admin123`
- **User**: `ahmed@demo.com` / `password123`
- **Database**: `homework_std_ro_db`

### البيئة المطلوبة - Required Environment
- PHP 8.2+
- MySQL 5.7+
- Apache/Nginx
- Extensions: mysqli, gd, mbstring

### أدوات الاختبار - Testing Tools
- Manual Testing (اختبار يدوي)
- Browser DevTools
- Postman (لاختبار API)
- MySQL Workbench (لفحص قاعدة البيانات)

---

## ✅ ملخص التقدم - Progress Summary

**إجمالي حالات الاستخدام**: 107
**تم الاختبار**: 0
**نجح**: 0
**فشل**: 0
**معلق**: 107

---

تاريخ الإنشاء: 2026-05-09
آخر تحديث: 2026-05-09
