<?php

use App\BusinessLogic\UserBlock;
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

Route::get('/', 'MessageController@index');
Route::post('/', 'MessageController@store');

Route::get('/reg', function () {

    $userBlock = UserBlock::get();
    return view('messages.reg',$userBlock);
});
Route::post('/reg', 'Auth\RegisterController@register');
Route::get('/reg_success', function () {

    $userBlock = UserBlock::get();
    return view('messages.reg_success',$userBlock);
});

Route::get('/login', function () {

    $userBlock = UserBlock::get();
    return view('messages.login',$userBlock);
});
Route::post('/login', 'Auth\LoginController@login');

Route::get('/logout', 'Auth\LoginController@logout');


