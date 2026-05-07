<?php
/**
 * Web Routes
 * Define all application routes here
 */

// ========== Public Routes ==========

// Home & Static Pages
Router::get('/', 'HomeController@index');
Router::get('/home', 'HomeController@index');
Router::get('/about', 'HomeController@about');
Router::get('/facilities', 'HomeController@facilities');
Router::any('/contact', 'HomeController@contact');

// Language Switcher
Router::get('/set-lang', 'HomeController@setLang');

// Rooms
Router::get('/rooms', 'RoomController@index');
Router::get('/room/{id}', 'RoomController@show');

// AJAX Room Search
Router::get('/api/rooms/search', 'RoomController@search');

// ========== Auth Routes ==========
Router::get('/login',    'AuthController@loginPage');
Router::get('/register', 'AuthController@registerPage');
Router::post('/api/auth/login',    'AuthController@login');
Router::post('/api/auth/register', 'AuthController@register');
Router::get('/logout', 'AuthController@logout');

// ========== User Routes (Require Login) ==========
Router::get('/bookings', 'BookingController@index');
Router::get('/booking/confirm', 'BookingController@confirm');
Router::post('/api/booking/check-availability', 'BookingController@checkAvailability');
Router::post('/booking/pay', 'BookingController@pay');
Router::get('/booking/payment', 'BookingController@paymentPage');
Router::post('/api/booking/process-payment', 'BookingController@processPayment');
Router::get('/booking/success', 'BookingController@paymentSuccess');
Router::post('/api/booking/cancel', 'BookingController@cancel');
Router::post('/api/booking/review', 'BookingController@review');

Router::get('/profile', 'UserController@profile');
Router::post('/api/user/update-profile', 'UserController@updateProfile');
Router::post('/api/user/update-password', 'UserController@updatePassword');
Router::post('/api/user/add-balance', 'UserController@addBalance');
Router::post('/api/user/update-avatar', 'UserController@updateAvatar');

// ========== Admin Routes ==========
Router::any('/admin/login',    'AuthController@adminLogin');
Router::get('/admin/logout',   'AuthController@adminLogout');
Router::get('/admin',          'AdminDashboardController@index');
Router::get('/admin/dashboard','AdminDashboardController@index');
Router::post('/admin/dashboard','AdminDashboardController@analytics');

// Bookings
Router::get('/admin/bookings/new',          'AdminBookingController@newBookings');
Router::post('/admin/bookings/assign',      'AdminBookingController@assignRoom');
Router::post('/admin/bookings/cancel',      'AdminBookingController@cancelBooking');
Router::get('/admin/bookings/refunds',      'AdminBookingController@refundBookings');
Router::post('/admin/bookings/refund',      'AdminBookingController@processRefund');
Router::get('/admin/bookings/records',      'AdminBookingController@records');

// Rooms
Router::get('/admin/rooms',                 'AdminRoomController@index');
Router::post('/admin/rooms/add',            'AdminRoomController@addRoom');
Router::post('/admin/rooms/edit',           'AdminRoomController@editRoom');
Router::post('/admin/rooms/toggle',         'AdminRoomController@toggleStatus');
Router::post('/admin/rooms/remove',         'AdminRoomController@removeRoom');
Router::get('/admin/rooms/{id}/images',         'AdminRoomController@images');
Router::post('/admin/rooms/{id}/images/add',    'AdminRoomController@addImage');
Router::post('/admin/rooms/{id}/images/remove', 'AdminRoomController@removeImage');
Router::post('/admin/rooms/{id}/images/thumb',  'AdminRoomController@setThumb');

// Users
Router::get('/admin/users',                 'AdminUserController@index');
Router::post('/admin/users/toggle',         'AdminUserController@toggleStatus');
Router::post('/admin/users/remove',         'AdminUserController@removeUser');

// Facilities & Features
Router::get('/admin/facilities',            'AdminFacilityController@index');
Router::post('/admin/features/add',         'AdminFacilityController@addFeature');
Router::post('/admin/features/remove',      'AdminFacilityController@removeFeature');
Router::post('/admin/facilities/add',       'AdminFacilityController@addFacility');
Router::post('/admin/facilities/remove',    'AdminFacilityController@removeFacility');

// Reviews & Queries
Router::get('/admin/reviews',               'AdminReviewController@reviews');
Router::post('/admin/reviews/seen',         'AdminReviewController@markReviewSeen');
Router::get('/admin/queries',               'AdminReviewController@queries');
Router::post('/admin/queries/seen',         'AdminReviewController@markQuerySeen');

// Settings
Router::get('/admin/settings',              'AdminSettingsController@index');
Router::post('/admin/settings/general',     'AdminSettingsController@updateGeneral');
Router::post('/admin/settings/contacts',    'AdminSettingsController@updateContacts');
Router::post('/admin/settings/member/add',  'AdminSettingsController@addMember');
Router::post('/admin/settings/member/remove','AdminSettingsController@removeMember');

// Carousel
Router::get('/admin/carousel',              'AdminSettingsController@carousel');
Router::post('/admin/carousel/add',         'AdminSettingsController@addCarousel');
Router::post('/admin/carousel/remove',      'AdminSettingsController@removeCarousel');
