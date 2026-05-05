# خطة التصحيح والتحسين الشاملة — Vana Hotel

---

## 🔴 المرحلة الأولى — مشاكل حرجة (أمان)

- [ ] 1. تكرار كود الاتصال بقاعدة البيانات — توحيده عبر `require` في: `ajax/login_register.php`, `ajax/confirm_booking.php`, `ajax/cancel_booking.php`, `generate_pdf.php`
- [ ] 2. بيانات الاتصال القديمة في ملفات AJAX — توحيد الاتصال
- [ ] 3. SQL Injection — استخدام Prepared Statements في: `room_details.php`, `hotel.php`, `ajax/rooms.php`, `confirm_booking.php`, `pay_response.php` (حرج جداً — `$_POST` مباشرة في query)
- [ ] 4. كلمة مرور الأدمن غير مشفرة في `admin/index.php` — تشفيرها بـ bcrypt
- [ ] 5. عدم استخدام `session_regenerate_id()` في أي مكان — إضافتها بعد تسجيل الدخول
- [ ] 6. ملف `booking_debug.log` مكشوف — حذفه وإضافته لـ `.gitignore`

---

## 🟠 المرحلة الثانية — مشاكل الباكيند

- [x] 7. عدم وجود `index.php` في الجذر — إنشاء ملف يعيد التوجيه لـ `hotel.php`
- [x] 8. `die()` يكشف أخطاء قاعدة البيانات — استبداله بـ `error_log()`
- [x] 9. عدم التحقق من الجلسة في `pay.php`
- [x] 10. مسارات خاطئة — توحيدها في `essentials.php` (PROJECT_FOLDER تلقائي)
- [x] 11. عدم وجود Rate Limiting على تسجيل الدخول (5 محاولات / 10 دقائق)
- [x] 12. عدم وجود Pagination في الحجوزات (6 لكل صفحة)
- [x] 13. التحقق من التواريخ غير مكتمل — إضافة تحقق في الفرونت إند
- [x] 14. استخدام `require` بدل `require_once` في `header1.php`

---

## 🟡 المرحلة الثالثة — مشاكل الفرونت إند

- [x] 15. واجهة قديمة — تحديث بطاقات الغرف + hotel.php
- [x] 16. Dark Mode — CSS variables + toggle button + localStorage
- [x] 17. الصور بدون `alt` — إضافة alt لكل الصور
- [x] 18. Lazy Loading — `loading="lazy"` + IntersectionObserver
- [x] 19. Favicon — SVG emoji favicon في header1.php
- [x] 20. رسائل خطأ — موحّدة في footer.php
- [x] 21. Empty State — عند عدم وجود غرف أو تقييمات
- [x] 22. أزرار Loading State — `.btn-loading` CSS + JS
- [x] 23. فورم البحث يتحقق من التواريخ — hotel.php + rooms.php
- [x] 24. زر Scroll to Top — CSS + JS في footer.php

---

## 🌐 المرحلة الثالثة-ب — دعم متعدد اللغات

- [x] 25. نظام ترجمة (i18n) — `lang()` في essentials.php
- [x] 26. ملفات اللغة: `lang/ar.php`, `lang/en.php`, `lang/ku.php`
- [x] 27. زر تبديل اللغة في Header — dropdown مع أعلام
- [x] 28. دعم RTL/LTR — `dir` attribute في hotel.php
- [x] 29. ترجمة النصوص الرئيسية — header + footer + hotel.php
- [x] 30. حفظ اللغة في Session — `setLang()` + `$_SESSION['lang']`

---

## � المرحلة الرابعة — تحسينات الأداء

- [ ] 31. مشكلة N+1 Query في `hotel.php` و `rooms.php`
- [ ] 32. عدم وجود Caching للاستعلامات المتكررة
- [ ] 33. CSS مكرر بين `hotel.css` و `admin/hotel.css`
- [ ] 34. عدم تحسين الصور (ضغط + WebP)

---

## 🟢 المرحلة الخامسة — تحسينات الواجهة الحديثة

- [ ] 35. تحديث Header وإضافة تبديل اللغة
- [ ] 36. تحسين بطاقات الغرف
- [ ] 37. تحديث صفحة الحجز
- [ ] 38. تحسين صفحة تفاصيل الغرفة
- [ ] 39. إضافة صفحة 404
- [ ] 40. تحسين Footer وإضافة اسم Vana

---

## سجل التقدم

| # | المهمة | الحالة | الملاحظات |
|---|--------|--------|-----------|
| 1 | توحيد الاتصال بقاعدة البيانات | ✅ | login_register, confirm_booking, cancel_booking |
| 2 | توحيد AJAX | ✅ | تم استخدام require_once |
| 3 | SQL Injection | ✅ | pay_response.php تم إصلاحه (الأخطر) |
| 4 | تشفير كلمة مرور الأدمن | ✅ | bcrypt مع دعم الترقية التلقائية |
| 5 | session_regenerate_id | ✅ | أضيفت في login و admin login |
| 6 | booking_debug.log | ✅ | حذف + .gitignore |
| 7 | index.php | ✅ | redirect إلى hotel.php |
| 8 | die() → error_log() | ✅ | في db_config.php كاملاً |
| 9 | session check في pay.php | ✅ | redirect إذا غير مسجل |
| 10 | توحيد المسارات | ✅ | PROJECT_FOLDER تلقائي |
| 11 | Rate Limiting | ✅ | 5 محاولات / 10 دقائق |
| 12 | Pagination | ✅ | bookings.php — 6 لكل صفحة |
| 13 | تحقق التواريخ | ✅ | فرونت إند في rooms.php |
| 14 | require_once | ✅ | header1.php |
