<?php


namespace App\Http;


use App\BusinessLogic\UserBlock;
use Illuminate\Support\Facades\Route;

class WebRouter
{
    const ALL_MESSAGES = 'AllMessages';

    public function setupRoutes()
    {
        /*
     * Да, конечно, для списка сообщений должен быть контроллер MessageS,
     * и для работы с одиночнм сообщением Message, но не в этот раз
     * */
        Route::get('/', 'MessageController@index')
            ->name(self::ALL_MESSAGES);
        Route::post('/message/store', 'MessageController@store');
        /*
         * HTML не даёт возможности отправлять DELETE-запросы,
         * используем сурогат - метод POST
         * */
        Route::post('/message/destroy/{id}', 'MessageController@destroy');

        Route::get('/reg', function () {

            $userBlock = UserBlock::get();
            return view('messages.reg', $userBlock);
        });
        Route::post('/reg', 'Auth\RegisterController@register');
        Route::get('/reg_success', function () {

            $userBlock = UserBlock::get();
            return view('messages.reg_success', $userBlock);
        });

        Route::get('/login', function () {

            $userBlock = UserBlock::get();
            return view('messages.login', $userBlock);
        });
        Route::post('/login', 'Auth\LoginController@login');

        Route::get('/logout', 'Auth\LoginController@logout');
    }
}
