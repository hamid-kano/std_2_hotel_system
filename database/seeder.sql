-- ============================================================
--  Vana Hotel — Full Database Seeder
--  Run this AFTER importing m_hotel.sql
--  Clears existing data and inserts fresh demo data
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ── Truncate all tables ──────────────────────────────────────
TRUNCATE TABLE `rating_review`;
TRUNCATE TABLE `booking_details`;
TRUNCATE TABLE `booking_order`;
TRUNCATE TABLE `room_images`;
TRUNCATE TABLE `room_features`;
TRUNCATE TABLE `room_facilities`;
TRUNCATE TABLE `rooms`;
TRUNCATE TABLE `features`;
TRUNCATE TABLE `facilities`;
TRUNCATE TABLE `carousel`;
TRUNCATE TABLE `team_members`;
TRUNCATE TABLE `user_queries`;
TRUNCATE TABLE `balances`;
TRUNCATE TABLE `user_cred`;
TRUNCATE TABLE `settings`;
TRUNCATE TABLE `contact_details`;
TRUNCATE TABLE `admin_cred`;

SET FOREIGN_KEY_CHECKS = 1;

-- ── 1. Admin ─────────────────────────────────────────────────
-- Password: admin123 (bcrypt)
INSERT INTO `admin_cred` (`sr_no`, `admin_name`, `admin_pass`) VALUES
(1, 'admin', '$2y$10$NtHmTjp28qX2seosp73lH.D7t5mvMDLTa9XFfYG4sBjlg4CpA49CC');

-- ── 2. Settings ──────────────────────────────────────────────
INSERT INTO `settings` (`sr_no`, `site_title`, `site_about`, `shutdown`) VALUES
(1,
 'Vana Hotel',
 'Nestled in the heart of Erbil, Vana Hotel offers a refined and sophisticated retreat for the modern traveler. Our experienced team is dedicated to delivering the highest levels of service.',
 0);

-- ── 3. Contact Details ───────────────────────────────────────
INSERT INTO `contact_details`
  (`sr_no`, `address`, `gmap`, `pn1`, `pn2`, `email`, `fb`, `insta`, `tw`, `iframe`)
VALUES (
  1,
  'Erbil, Kurdistan Region, Iraq',
  'https://maps.app.goo.gl/Cjk46hd6ZtnJ2N2o8',
  9647501234567,
  9647509876543,
  'info@vanahotel.com',
  'https://facebook.com/vanahotel',
  'https://instagram.com/vanahotel',
  'https://twitter.com/vanahotel',
  'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d103031.92458615714!2d44.00896305!3d36.19701874210335!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x400722fe13443461:0x3e01d63391de79d1!2z2KfYsdio2YrZhCwgS3VyZGlzdGFuIFJlZ2lvbtiMINin2YTYudix2KfZgg!5e0!3m2!1sar!2s!4v1710944568233!5m2!1sar!2s'
);

-- ── 4. Carousel ──────────────────────────────────────────────
INSERT INTO `carousel` (`sr_no`, `image`) VALUES
(1, 'IMG_19327.png'),
(2, 'IMG_57805.png'),
(3, 'IMG_5.png');

-- ── 5. Features ──────────────────────────────────────────────
INSERT INTO `features` (`id`, `name`) VALUES
(1,  'Free Wi-Fi'),
(2,  'Air Conditioning'),
(3,  'Balcony'),
(4,  'Kitchen'),
(5,  'Room Service'),
(6,  'Mini Bar'),
(7,  'Jacuzzi'),
(8,  'Sea View'),
(9,  'City View'),
(10, 'Smart TV');

-- ── 6. Facilities ────────────────────────────────────────────
INSERT INTO `facilities` (`id`, `icon`, `name`, `description`) VALUES
(1, 'IMG_45307.svg', 'Air Conditioning',    'Climate control in all rooms'),
(2, 'IMG_15151.svg', 'Spa & Wellness',       'Full-service spa and wellness center'),
(3, 'IMG_54631.svg', 'Restaurant',           'Fine dining with international cuisine'),
(4, 'IMG_18593.svg', 'Concierge',            '24/7 concierge services'),
(5, 'IMG_45039.svg', 'High-Speed Wi-Fi',     'Complimentary high-speed internet'),
(6, 'IMG_83389.svg', 'Business Center',      'Fully equipped business center'),
(7, 'IMG_89768.svg', 'Conference Rooms',     'Modern meeting and event spaces'),
(8, 'IMG_61046.svg', 'Swimming Pool',        'Outdoor heated swimming pool');

-- ── 7. Rooms ─────────────────────────────────────────────────
INSERT INTO `rooms` (`id`, `name`, `area`, `price`, `quantity`, `adult`, `children`, `description`, `status`, `removed`) VALUES
(1, 'Standard Room',      25, 80,  10, 2, 1,
 'A comfortable standard room with all essential amenities, perfect for solo travelers or couples. Features a queen-size bed, en-suite bathroom, and city views.',
 1, 0),

(2, 'Deluxe Room',        35, 150, 8,  2, 2,
 'Spacious deluxe room with modern decor, premium bedding, and a stunning view. Includes a sitting area, minibar, and luxury bathroom with rain shower.',
 1, 0),

(3, 'Studio Suite',       45, 200, 5,  2, 2,
 'Open-plan suite combining bedroom and living area with a fully equipped kitchenette. Ideal for extended stays with a king-size bed and panoramic city views.',
 1, 0),

(4, 'One-Bedroom Suite',  60, 280, 4,  2, 3,
 'Elegant suite with a separate bedroom and spacious living room. Features premium furnishings, a dining area, and a luxurious bathroom with jacuzzi.',
 1, 0),

(5, 'Family Room',        55, 220, 6,  2, 4,
 'Designed for families, this room features two queen beds, a play area for children, and a large bathroom. Includes complimentary breakfast for all guests.',
 1, 0),

(6, 'Presidential Suite', 120, 600, 2, 4, 2,
 'The pinnacle of luxury — a sprawling suite with a private terrace, butler service, grand living room, two bedrooms, and breathtaking panoramic views of Erbil.',
 1, 0);

-- ── 8. Room Features ─────────────────────────────────────────
INSERT INTO `room_features` (`room_id`, `features_id`) VALUES
-- Standard Room
(1, 1), (1, 2), (1, 10),
-- Deluxe Room
(2, 1), (2, 2), (2, 3), (2, 6), (2, 10),
-- Studio Suite
(3, 1), (3, 2), (3, 3), (3, 4), (3, 5), (3, 10),
-- One-Bedroom Suite
(4, 1), (4, 2), (4, 3), (4, 5), (4, 6), (4, 7), (4, 10),
-- Family Room
(5, 1), (5, 2), (5, 4), (5, 5), (5, 10),
-- Presidential Suite
(6, 1), (6, 2), (6, 3), (6, 4), (6, 5), (6, 6), (6, 7), (6, 8), (6, 9), (6, 10);

-- ── 9. Room Facilities ───────────────────────────────────────
INSERT INTO `room_facilities` (`room_id`, `facilities_id`) VALUES
-- Standard Room
(1, 1), (1, 5),
-- Deluxe Room
(2, 1), (2, 4), (2, 5),
-- Studio Suite
(3, 1), (3, 3), (3, 4), (3, 5),
-- One-Bedroom Suite
(4, 1), (4, 2), (4, 3), (4, 4), (4, 5), (4, 6),
-- Family Room
(5, 1), (5, 3), (5, 4), (5, 5), (5, 8),
-- Presidential Suite
(6, 1), (6, 2), (6, 3), (6, 4), (6, 5), (6, 6), (6, 7), (6, 8);

-- ── 10. Room Images ──────────────────────────────────────────
INSERT INTO `room_images` (`room_id`, `image`, `thumb`) VALUES
(1, 'IMG_36840.png',  1),
(1, 'IMG_44615.png',  0),
(2, 'IMG_58588.png',  1),
(2, 'IMG_36840.png',  0),
(3, 'IMG_81645.png',  1),
(3, 'IMG_46752.png',  0),
(4, 'IMG_54129.jpg',  1),
(4, 'IMG_31704.png',  0),
(5, 'IMG_62925.png',  1),
(5, 'IMG_94743.png',  0),
(6, 'IMG_94743.png',  1),
(6, 'IMG_62925.png',  0);

-- ── 11. Team Members ─────────────────────────────────────────
INSERT INTO `team_members` (`sr_no`, `name`, `picture`) VALUES
(1, 'Ahmed Al-Rashid',  'IMG_35847.jpg'),
(2, 'Sara Hassan',      'IMG_94008.webp'),
(3, 'Omar Khalid',      'IMG_14806.webp'),
(4, 'Narin Aziz',       'IMG_95291.jpg');

-- ── 12. Users (password: password123) ───────────────────────
-- bcrypt hash of "password123"
INSERT INTO `user_cred`
  (`id`, `name`, `email`, `address`, `phonenum`, `pincode`, `dob`, `profile`, `password`, `is_verified`, `token`, `status`, `datentime`)
VALUES
(1, 'Ahmed Ali',    'ahmed@demo.com',  'Erbil, Kurdistan',  '07501111111', 44001, '1990-05-15', 0,
 '$2y$10$RAbSdtV39PhveSXla7BjQ.XkFDGMnHg8zK8.ibKHu3mO86NA6P56m', 1, NULL, 1, '2024-01-10 09:00:00'),

(2, 'Sara Hassan',  'sara@demo.com',   'Sulaymaniyah',      '07502222222', 46001, '1995-08-22', 0,
 '$2y$10$RAbSdtV39PhveSXla7BjQ.XkFDGMnHg8zK8.ibKHu3mO86NA6P56m', 1, NULL, 1, '2024-02-14 10:30:00'),

(3, 'Omar Khalid',  'omar@demo.com',   'Duhok, Kurdistan',  '07503333333', 42001, '1988-12-01', 0,
 '$2y$10$RAbSdtV39PhveSXla7BjQ.XkFDGMnHg8zK8.ibKHu3mO86NA6P56m', 1, NULL, 1, '2024-03-05 14:00:00'),

(4, 'Layla Nouri',  'layla@demo.com',  'Baghdad, Iraq',     '07504444444', 10001, '1992-03-18', 0,
 '$2y$10$RAbSdtV39PhveSXla7BjQ.XkFDGMnHg8zK8.ibKHu3mO86NA6P56m', 1, NULL, 1, '2024-04-20 08:15:00'),

(5, 'Karwan Aziz',  'karwan@demo.com', 'Erbil, Kurdistan',  '07505555555', 44002, '1997-07-30', 0,
 '$2y$10$RAbSdtV39PhveSXla7BjQ.XkFDGMnHg8zK8.ibKHu3mO86NA6P56m', 1, NULL, 1, '2024-05-11 16:45:00');

-- ── 13. Balances ─────────────────────────────────────────────
INSERT INTO `balances` (`user_id`, `balance`) VALUES
(1, 5000.00),
(2, 3200.00),
(3, 8500.00),
(4, 1200.00),
(5, 9999.00);

-- ── 14. Bookings ─────────────────────────────────────────────
INSERT INTO `booking_order`
  (`booking_id`, `user_id`, `room_id`, `check_in`, `check_out`, `arrival`, `refund`,
   `booking_status`, `order_id`, `trans_status`, `rate_review`, `datentime`)
VALUES
-- Completed bookings (arrival=1, rate_review=1)
(1, 1, 1, '2024-06-01', '2024-06-03', 1, NULL, 'booked',    'ORD-DEMO-001', 'success', 1, '2024-05-28 10:00:00'),
(2, 2, 2, '2024-06-05', '2024-06-08', 1, NULL, 'booked',    'ORD-DEMO-002', 'success', 1, '2024-06-01 11:00:00'),
(3, 3, 3, '2024-06-10', '2024-06-12', 1, NULL, 'booked',    'ORD-DEMO-003', 'success', 1, '2024-06-07 09:30:00'),
(4, 4, 4, '2024-06-15', '2024-06-18', 1, NULL, 'booked',    'ORD-DEMO-004', 'success', 1, '2024-06-12 14:00:00'),
(5, 5, 5, '2024-06-20', '2024-06-22', 1, NULL, 'booked',    'ORD-DEMO-005', 'success', 1, '2024-06-18 08:00:00'),
-- Active bookings (arrival=0, not yet checked in)
(6, 1, 2, '2025-12-01', '2025-12-05', 0, NULL, 'booked',    'ORD-DEMO-006', 'success', 0, '2025-11-20 10:00:00'),
(7, 2, 4, '2025-12-10', '2025-12-14', 0, NULL, 'booked',    'ORD-DEMO-007', 'success', 0, '2025-11-25 12:00:00'),
-- Cancelled with refund processed
(8, 3, 1, '2024-07-01', '2024-07-03', 0, 1,    'cancelled', 'ORD-DEMO-008', 'success', NULL, '2024-06-28 09:00:00'),
-- Cancelled pending refund
(9, 4, 2, '2024-07-10', '2024-07-12', 0, 0,    'cancelled', 'ORD-DEMO-009', 'success', NULL, '2024-07-08 11:00:00');

INSERT INTO `booking_details`
  (`booking_id`, `room_name`, `price`, `total_pay`, `room_no`, `user_name`, `phonenum`, `address`)
VALUES
(1, 'Standard Room',      80,  160,  '101', 'Ahmed Ali',   '07501111111', 'Erbil, Kurdistan'),
(2, 'Deluxe Room',        150, 450,  '205', 'Sara Hassan', '07502222222', 'Sulaymaniyah'),
(3, 'Studio Suite',       200, 400,  '310', 'Omar Khalid', '07503333333', 'Duhok, Kurdistan'),
(4, 'One-Bedroom Suite',  280, 840,  '401', 'Layla Nouri', '07504444444', 'Baghdad, Iraq'),
(5, 'Family Room',        220, 440,  '502', 'Karwan Aziz', '07505555555', 'Erbil, Kurdistan'),
(6, 'Deluxe Room',        150, 600,  NULL,  'Ahmed Ali',   '07501111111', 'Erbil, Kurdistan'),
(7, 'One-Bedroom Suite',  280, 1120, NULL,  'Sara Hassan', '07502222222', 'Sulaymaniyah'),
(8, 'Standard Room',      80,  160,  NULL,  'Omar Khalid', '07503333333', 'Duhok, Kurdistan'),
(9, 'Deluxe Room',        150, 300,  NULL,  'Layla Nouri', '07504444444', 'Baghdad, Iraq');

-- ── 15. Reviews ──────────────────────────────────────────────
INSERT INTO `rating_review`
  (`booking_id`, `room_id`, `user_id`, `rating`, `review`, `seen`, `datentime`)
VALUES
(1, 1, 1, 5, 'Excellent stay! The room was spotless and the staff were incredibly helpful. Will definitely return.',
 1, '2024-06-04 10:00:00'),

(2, 2, 2, 4, 'Very comfortable room with great amenities. The view from the balcony was stunning. Highly recommended.',
 1, '2024-06-09 11:00:00'),

(3, 3, 3, 5, 'The studio suite exceeded all expectations. Perfect for a couple getaway. The kitchenette was a great bonus.',
 0, '2024-06-13 09:00:00'),

(4, 4, 4, 3, 'Good room overall but the jacuzzi was not working during our stay. Staff resolved it quickly though.',
 0, '2024-06-19 14:00:00'),

(5, 5, 5, 5, 'Perfect for our family! Kids loved the play area and the breakfast was delicious. 10/10.',
 0, '2024-06-23 08:00:00');

-- ── 16. User Queries ─────────────────────────────────────────
INSERT INTO `user_queries`
  (`name`, `email`, `subject`, `message`, `datentime`, `seen`)
VALUES
('Ahmed Ali',   'ahmed@demo.com',  'Room Availability',
 'Hello, I would like to know if the Presidential Suite is available for New Year\'s Eve. Please let me know the rates.',
 '2024-11-01 10:00:00', 1),

('Sara Hassan', 'sara@demo.com',   'Special Request',
 'We are celebrating our anniversary. Is it possible to arrange a special decoration in the room?',
 '2024-11-05 14:30:00', 1),

('Omar Khalid', 'omar@demo.com',   'Group Booking',
 'We have a group of 15 people coming for a conference. Do you have special rates for group bookings?',
 '2024-11-10 09:15:00', 0),

('Layla Nouri', 'layla@demo.com',  'Cancellation Policy',
 'What is your cancellation policy for bookings made more than 30 days in advance?',
 '2024-11-15 16:00:00', 0),

('Karwan Aziz', 'karwan@demo.com', 'Airport Transfer',
 'Do you provide airport transfer services? If yes, what are the charges from Erbil International Airport?',
 '2024-11-20 11:45:00', 0);

-- ── Done ─────────────────────────────────────────────────────
SELECT 'Seeder completed successfully!' AS status;
