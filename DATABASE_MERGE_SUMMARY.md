
### `database/install.sql` (467 سطر)

#### Part 1: Drop Tables
- حذف جميع الجداول القديمة إن وجدت

#### Part 2: Create Base Tables (17 جدول)
1. `admin_cred` - بيانات المدير
2. `settings` - الإعدادات العامة
3. `contact_details` - بيانات التواصل
4. `user_cred` - حسابات المستخدمين
5. `balances` - أرصدة المستخدمين
6. `user_queries` - استفسارات التواصل
7. `team_members` - فريق الإدارة
8. `carousel` - صور الكاروسيل
9. `facilities` - مرافق الفندق
10. `features` - ميزات الغرف
11. `rooms` - الغرف
12. `room_features` - علاقة الغرف بالميزات
13. `room_facilities` - علاقة الغرف بالمرافق
14. `room_images` - صور الغرف
15. `booking_order` - طلبات الحجز
16. `booking_details` - تفاصيل الحجز
17. `rating_review` - التقييمات والمراجعات

#### Part 3: Create Translation Tables (3 جداول)
18. `features_translations` - ترجمات الميزات
19. `facilities_translations` - ترجمات المرافق
20. `rooms_translations` - ترجمات الغرف

#### Part 4: Insert Demo Data
- 1 مدير (admin / admin123)
- 5 مستخدمين (password: password123)
- 6 غرف
- 8 مرافق
- 10 ميزات
- 9 حجوزات
- 5 تقييمات
- 5 استفسارات

#### Part 5: Insert Translation Data (72 سجل)
- 30 ترجمة للميزات (10 × 3 لغات)
- 24 ترجمة للمرافق (8 × 3 لغات)
- 18 ترجمة للغرف (6 × 3 لغات)

---
