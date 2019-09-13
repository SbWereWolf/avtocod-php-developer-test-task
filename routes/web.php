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

/**
 * @return array
 */
function getUserBlock(): array
{
    $user = auth()->user();

    $isObject = is_object($user);
    if ($isObject) {
        $name = $user->name;
        $mayShow = 'visible';
    }
    if (!$isObject) {
        $name = '';
        $mayShow = 'invisible';
    }
    $userBlock = ['username' => $name, 'visibleProperty' => $mayShow];

    return $userBlock;
}

Route::get('/', function () {

    $userBlock = getUserBlock();
    return view('messages.index',$userBlock);
});

Route::get('/reg', function () {

    $userBlock = getUserBlock();
    return view('messages.reg',$userBlock);
});
Route::post('/reg', 'Auth\RegisterController@register');
Route::get('/reg_success', function () {

    $userBlock = getUserBlock();
    return view('messages.reg_success',$userBlock);
});

Route::get('/login', function () {

    $userBlock = getUserBlock();
    return view('messages.login',$userBlock);
});
Route::post('/login', 'Auth\LoginController@login');

Route::get('/logout', 'Auth\LoginController@logout');


