# خطة التصحيح والتحسين الشاملة — Vana Hotel

---

## المرحلة الاولى — مشاكل حرجة (امان)

- [x] 1. تكرار كود الاتصال بقاعدة البيانات — توحيده عبر `require_once`
- [x] 2. بيانات الاتصال القديمة في ملفات AJAX — توحيد الاتصال
- [x] 3. SQL Injection — Prepared Statements في `pay_response.php` وغيرها
- [x] 4. كلمة مرور الادمن غير مشفرة — bcrypt مع ترقية تلقائية
- [x] 5. عدم استخدام `session_regenerate_id()` — اضيفت بعد تسجيل الدخول
- [x] 6. ملف `booking_debug.log` مكشوف — حذف + `.gitignore`

---

## المرحلة الثانية — مشاكل الباكيند

- [x] 7. عدم وجود `index.php` — redirect الى `hotel.php`
- [x] 8. `die()` يكشف الاخطاء — استبداله بـ `error_log()`
- [x] 9. عدم التحقق من الجلسة في `pay.php`
- [x] 10. مسارات خاطئة — توحيدها تلقائياً بـ `PROJECT_FOLDER`
- [x] 11. Rate Limiting — 5 محاولات / 10 دقائق
- [x] 12. Pagination — `bookings.php` 6 لكل صفحة
- [x] 13. التحقق من التواريخ — فرونت اند في `rooms.php` و `hotel.php`
- [x] 14. `require` بدل `require_once` — تم التوحيد

---

## المرحلة الثالثة — مشاكل الفرونت اند

- [x] 15. واجهة قديمة — تحديث بطاقات الغرف + `hotel.php`
- [x] 16. Dark Mode — CSS variables + toggle + localStorage
- [x] 17. الصور بدون `alt` — اضيف alt لكل الصور
- [x] 18. Lazy Loading — `loading="lazy"` + IntersectionObserver
- [x] 19. Favicon — SVG emoji في `header1.php`
- [x] 20. رسائل خطا — موحدة في `footer.php`
- [x] 21. Empty State — عند عدم وجود غرف او تقييمات
- [x] 22. ازرار Loading State — `.btn-loading` CSS + JS
- [x] 23. فورم البحث يتحقق من التواريخ
- [x] 24. زر Scroll to Top

---

## المرحلة الثالثة-ب — دعم متعدد اللغات

- [x] 25. نظام ترجمة i18n — دالة `lang()` في `essentials.php`
- [x] 26. ملفات اللغة: `lang/ar.php`, `lang/en.php`, `lang/ku.php`
- [x] 27. زر تبديل اللغة في Header — dropdown
- [x] 28. دعم RTL/LTR — `dir` attribute تلقائي
- [x] 29. ترجمة النصوص الرئيسية
- [x] 30. حفظ اللغة في Session

---

## المرحلة الرابعة — تحسينات الاداء

- [x] 31. N+1 Query — حُلّت في `ajax/rooms.php` بـ 4 bulk queries
- [x] 32. Caching — `inc/cache.php` file-based + تطبيق في `header1.php`
- [x] 33. CSS مكرر — `admin/hotel.css` نُظّف
- [x] 34. تحسين الصور — `loading="lazy"` + `object-fit:cover`

---

## المرحلة الخامسة — تحسينات الواجهة الحديثة

- [x] 35. تحديث Header + تبديل اللغة
- [x] 36. تحسين بطاقات الغرف — `room-card` class + hover
- [ ] 37. تحديث صفحة الحجز `confirm_booking.php`
- [ ] 38. تحسين صفحة تفاصيل الغرفة `room_details.php`
- [x] 39. صفحة 404
- [x] 40. تحسين Footer + اسم Vana

---

## سجل التقدم

| # | المهمة | الحالة | الملاحظات |
|---|--------|--------|-----------|
| 1-6  | المرحلة الاولى (امان)    | done | كاملة |
| 7-14 | المرحلة الثانية (باكيند) | done | كاملة |
| 15-30| المرحلة الثالثة (فرونت + لغات) | done | كاملة |
| 31-34| المرحلة الرابعة (اداء)   | done | كاملة |
| 37-38| المرحلة الخامسة (واجهة)  | pending | confirm_booking + room_details |
