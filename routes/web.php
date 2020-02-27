<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'FeedController@index');

Route::get('login', 'AuthController@login');
Route::get('logout', 'AuthController@logout');
Route::post('post-login', 'AuthController@postLogin');

Route::post('post-register', 'RegisterController@postRegister');
Route::post('check-email', 'RegisterController@checkEmailAvailability');
Route::get('register', 'RegisterController@register');


Route::get('dashboard', 'FeedController@dashboard');

