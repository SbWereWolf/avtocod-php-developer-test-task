<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('messages.index');
});
Route::get('/reg', function () {
    return view('messages.reg');
});
Route::post('/reg', 'Auth\RegisterController@register');
Route::get('/reg_success', function () {
    return view('messages.reg_success');
});
Route::get('/login', function () {
    return view('messages.login');
});
Route::post('/login', 'Auth\LoginController@login');

Route::get('/logout', 'Auth\LoginController@logout');


