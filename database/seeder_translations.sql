-- ============================================================
--  Translation Data for Dynamic Content
--  بيانات الترجمة للمحتوى الديناميكي
--  Run this AFTER schema_translations.sql
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

-- Clear existing translations
TRUNCATE TABLE `features_translations`;
TRUNCATE TABLE `facilities_translations`;
TRUNCATE TABLE `rooms_translations`;

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- 1. Features Translations (ترجمات ميزات الغرف)
-- ============================================================

-- Feature 1: Free Wi-Fi
INSERT INTO `features_translations` (`feature_id`, `lang`, `name`) VALUES
(1, 'en', 'Free Wi-Fi'),
(1, 'ar', 'واي فاي مجاني'),
(1, 'ku', 'Wi-Fi Belaş');

-- Feature 2: Air Conditioning
INSERT INTO `features_translations` (`feature_id`, `lang`, `name`) VALUES
(2, 'en', 'Air Conditioning'),
(2, 'ar', 'تكييف هواء'),
(2, 'ku', 'Klîma');

-- Feature 3: Balcony
INSERT INTO `features_translations` (`feature_id`, `lang`, `name`) VALUES
(3, 'en', 'Balcony'),
(3, 'ar', 'شرفة'),
(3, 'ku', 'Balkon');

-- Feature 4: Kitchen
INSERT INTO `features_translations` (`feature_id`, `lang`, `name`) VALUES
(4, 'en', 'Kitchen'),
(4, 'ar', 'مطبخ'),
(4, 'ku', 'Mitbax');

-- Feature 5: Room Service
INSERT INTO `features_translations` (`feature_id`, `lang`, `name`) VALUES
(5, 'en', 'Room Service'),
(5, 'ar', 'خدمة الغرف'),
(5, 'ku', 'Xizmeta Odeyê');

-- Feature 6: Mini Bar
INSERT INTO `features_translations` (`feature_id`, `lang`, `name`) VALUES
(6, 'en', 'Mini Bar'),
(6, 'ar', 'ميني بار'),
(6, 'ku', 'Mînî Bar');

-- Feature 7: Jacuzzi
INSERT INTO `features_translations` (`feature_id`, `lang`, `name`) VALUES
(7, 'en', 'Jacuzzi'),
(7, 'ar', 'جاكوزي'),
(7, 'ku', 'Jakûzî');

-- Feature 8: Sea View
INSERT INTO `features_translations` (`feature_id`, `lang`, `name`) VALUES
(8, 'en', 'Sea View'),
(8, 'ar', 'إطلالة بحرية'),
(8, 'ku', 'Dîtina Deryayê');

-- Feature 9: City View
INSERT INTO `features_translations` (`feature_id`, `lang`, `name`) VALUES
(9, 'en', 'City View'),
(9, 'ar', 'إطلالة على المدينة'),
(9, 'ku', 'Dîtina Bajarê');

-- Feature 10: Smart TV
INSERT INTO `features_translations` (`feature_id`, `lang`, `name`) VALUES
(10, 'en', 'Smart TV'),
(10, 'ar', 'تلفاز ذكي'),
(10, 'ku', 'TV Zîrek');

-- ============================================================
-- 2. Facilities Translations (ترجمات مرافق الفندق)
-- ============================================================

-- Facility 1: Air Conditioning
INSERT INTO `facilities_translations` (`facility_id`, `lang`, `name`, `description`) VALUES
(1, 'en', 'Air Conditioning', 'Climate control in all rooms'),
(1, 'ar', 'تكييف هواء', 'تحكم بالمناخ في جميع الغرف'),
(1, 'ku', 'Klîma', 'Kontrola hewayê li hemû odeyan');

-- Facility 2: Spa & Wellness
INSERT INTO `facilities_translations` (`facility_id`, `lang`, `name`, `description`) VALUES
(2, 'en', 'Spa & Wellness', 'Full-service spa and wellness center'),
(2, 'ar', 'سبا ومركز صحي', 'مركز سبا وعافية متكامل الخدمات'),
(2, 'ku', 'Spa û Tenduristî', 'Navenda spa û tenduristiyê bi xizmetên tevahî');

-- Facility 3: Restaurant
INSERT INTO `facilities_translations` (`facility_id`, `lang`, `name`, `description`) VALUES
(3, 'en', 'Restaurant', 'Fine dining with international cuisine'),
(3, 'ar', 'مطعم', 'تناول طعام فاخر مع مأكولات عالمية'),
(3, 'ku', 'Xwarinxane', 'Xwarina xweş bi xwarinên navneteweyî');

-- Facility 4: Concierge
INSERT INTO `facilities_translations` (`facility_id`, `lang`, `name`, `description`) VALUES
(4, 'en', 'Concierge', '24/7 concierge services'),
(4, 'ar', 'خدمة الكونسيرج', 'خدمات الكونسيرج على مدار الساعة'),
(4, 'ku', 'Xizmeta Mêvan', 'Xizmetên mêvan 24/7');

-- Facility 5: High-Speed Wi-Fi
INSERT INTO `facilities_translations` (`facility_id`, `lang`, `name`, `description`) VALUES
(5, 'en', 'High-Speed Wi-Fi', 'Complimentary high-speed internet'),
(5, 'ar', 'إنترنت عالي السرعة', 'إنترنت مجاني عالي السرعة'),
(5, 'ku', 'Înternet Bilez', 'Înternet bilez belaş');

-- Facility 6: Business Center
INSERT INTO `facilities_translations` (`facility_id`, `lang`, `name`, `description`) VALUES
(6, 'en', 'Business Center', 'Fully equipped business center'),
(6, 'ar', 'مركز أعمال', 'مركز أعمال مجهز بالكامل'),
(6, 'ku', 'Navenda Karsaziyê', 'Navenda karsaziyê bi tevahî amade');

-- Facility 7: Conference Rooms
INSERT INTO `facilities_translations` (`facility_id`, `lang`, `name`, `description`) VALUES
(7, 'en', 'Conference Rooms', 'Modern meeting and event spaces'),
(7, 'ar', 'قاعات مؤتمرات', 'قاعات اجتماعات وفعاليات حديثة'),
(7, 'ku', 'Salên Konferansê', 'Cihên civîn û bûyeran ên modern');

-- Facility 8: Swimming Pool
INSERT INTO `facilities_translations` (`facility_id`, `lang`, `name`, `description`) VALUES
(8, 'en', 'Swimming Pool', 'Outdoor heated swimming pool'),
(8, 'ar', 'مسبح', 'مسبح خارجي مُدفأ'),
(8, 'ku', 'Hewza Avê', 'Hewza avê ya derveyî ya germ');

-- ============================================================
-- 3. Rooms Translations (ترجمات الغرف)
-- ============================================================

-- Room 1: Standard Room
INSERT INTO `rooms_translations` (`room_id`, `lang`, `name`, `description`) VALUES
(1, 'en', 'Standard Room', 'A comfortable standard room with all essential amenities, perfect for solo travelers or couples. Features a queen-size bed, en-suite bathroom, and city views.'),
(1, 'ar', 'غرفة قياسية', 'غرفة قياسية مريحة مع جميع وسائل الراحة الأساسية، مثالية للمسافرين الفرديين أو الأزواج. تحتوي على سرير كوين، حمام داخلي، وإطلالة على المدينة.'),
(1, 'ku', 'Odeya Standard', 'Odeyek standard a rehet bi hemû amûrên bingehîn, ji bo rêwîtiyên yekane an hevjînan baş e. Nivînek queen-size, banyoyek hundurîn û dîtina bajarê heye.');

-- Room 2: Deluxe Room
INSERT INTO `rooms_translations` (`room_id`, `lang`, `name`, `description`) VALUES
(2, 'en', 'Deluxe Room', 'Spacious deluxe room with modern decor, premium bedding, and a stunning view. Includes a sitting area, minibar, and luxury bathroom with rain shower.'),
(2, 'ar', 'غرفة ديلوكس', 'غرفة ديلوكس واسعة مع ديكور عصري، فراش فاخر، وإطلالة خلابة. تشمل منطقة جلوس، ميني بار، وحمام فاخر مع دش مطري.'),
(2, 'ku', 'Odeya Deluxe', 'Odeyek deluxe a fireh bi dekorasyoneke modern, nivîneke premium û dîtinek ecêb. Cihek rûniştinê, mînî bar û banyoyek lûks bi duşa baranê heye.');

-- Room 3: Studio Suite
INSERT INTO `rooms_translations` (`room_id`, `lang`, `name`, `description`) VALUES
(3, 'en', 'Studio Suite', 'Open-plan suite combining bedroom and living area with a fully equipped kitchenette. Ideal for extended stays with a king-size bed and panoramic city views.'),
(3, 'ar', 'جناح استوديو', 'جناح مفتوح يجمع بين غرفة النوم ومنطقة المعيشة مع مطبخ صغير مجهز بالكامل. مثالي للإقامات الطويلة مع سرير كينج وإطلالة بانورامية على المدينة.'),
(3, 'ku', 'Stûdyo Suite', 'Suite-yek vekirî ku odeya razanê û cihê jiyanê bi mitbaxeke piçûk a bi tevahî amade dike yek. Ji bo mayînên dirêj bi nivîneke king-size û dîtina panoramîk a bajarê baş e.');

-- Room 4: One-Bedroom Suite
INSERT INTO `rooms_translations` (`room_id`, `lang`, `name`, `description`) VALUES
(4, 'en', 'One-Bedroom Suite', 'Elegant suite with a separate bedroom and spacious living room. Features premium furnishings, a dining area, and a luxurious bathroom with jacuzzi.'),
(4, 'ar', 'جناح بغرفة نوم واحدة', 'جناح أنيق مع غرفة نوم منفصلة وغرفة معيشة واسعة. يحتوي على أثاث فاخر، منطقة طعام، وحمام فاخر مع جاكوزي.'),
(4, 'ku', 'Suite bi Yek Odeya Razanê', 'Suite-yek xweşik bi odeya razanê ya veqetandî û salona jiyanê ya fireh. Mobilyayên premium, cihek xwarinê û banyoyek lûks bi jakûzî heye.');

-- Room 5: Family Room
INSERT INTO `rooms_translations` (`room_id`, `lang`, `name`, `description`) VALUES
(5, 'en', 'Family Room', 'Designed for families, this room features two queen beds, a play area for children, and a large bathroom. Includes complimentary breakfast for all guests.'),
(5, 'ar', 'غرفة عائلية', 'مصممة للعائلات، تحتوي هذه الغرفة على سريرين كوين، منطقة لعب للأطفال، وحمام كبير. تشمل إفطار مجاني لجميع الضيوف.'),
(5, 'ku', 'Odeya Malbatê', 'Ji bo malbatan hatiye çêkirin, ev ode du nivînên queen, cihek lîstikê ji zarokan û banyoyek mezin heye. Taştê sibehê ji hemû mêvanan re belaş e.');

-- Room 6: Presidential Suite
INSERT INTO `rooms_translations` (`room_id`, `lang`, `name`, `description`) VALUES
(6, 'en', 'Presidential Suite', 'The pinnacle of luxury — a sprawling suite with a private terrace, butler service, grand living room, two bedrooms, and breathtaking panoramic views of Erbil.'),
(6, 'ar', 'الجناح الرئاسي', 'قمة الفخامة - جناح واسع مع تراس خاص، خدمة خادم شخصي، غرفة معيشة كبيرة، غرفتي نوم، وإطلالات بانورامية خلابة على أربيل.'),
(6, 'ku', 'Suite ya Serokê', 'Bilindahiya lûksê - suite-yek mezin bi teraseke taybet, xizmeta butler, salona jiyanê ya mezin, du odeyan razanê û dîtinên panoramîk ên ecêb ên Hewlêrê.');

-- ============================================================
-- Success Message
-- ============================================================
SELECT 'Translation data inserted successfully!' AS status;
