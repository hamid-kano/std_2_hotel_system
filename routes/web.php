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
Router::post('/api/auth/login', 'AuthController@login');
Router::post('/api/auth/register', 'AuthController@register');
Router::get('/logout', 'AuthController@logout');

// ========== User Routes (Require Login) ==========
Router::get('/bookings', 'BookingController@index');
Router::get('/booking/confirm', 'BookingController@confirm');
Router::post('/api/booking/check-availability', 'BookingController@checkAvailability');
Router::post('/booking/pay', 'BookingController@pay');
Router::post('/api/booking/cancel', 'BookingController@cancel');
Router::post('/api/booking/review', 'BookingController@review');

Router::get('/profile', 'UserController@profile');
Router::post('/api/user/update-profile', 'UserController@updateProfile');
Router::post('/api/user/update-password', 'UserController@updatePassword');
Router::post('/api/user/add-balance', 'UserController@addBalance');
Router::post('/api/user/update-avatar', 'UserController@updateAvatar');

// ========== Admin Routes ==========
Router::any('/admin/login', 'AuthController@adminLogin');
Router::get('/admin/logout', 'AuthController@adminLogout');

// Admin Dashboard (will be added later)
// Router::get('/admin/dashboard', 'AdminController@dashboard');
// Router::get('/admin/rooms', 'AdminRoomController@index');
// ... etc
