<?php


namespace App\Http;


use App\BusinessLogic\UserBlock;
use Illuminate\Support\Facades\Route;

class WebRouter
{
    // Наименование адреса страницы со стеной сообщений
    const ALL_MESSAGES = 'AllMessages';

    /**
     * Настроить роутинг
     */
    public function setupRoutes()
    {
        /*
         * Да, конечно, для списка сообщений должен быть контроллер MessageS,
         * и для работы с одиночным сообщением Message, но не в этот раз
         * */
        //Все сообщения
        Route::get('/', 'MessageController@index')
            ->name(self::ALL_MESSAGES);
        // Добавить сообщение
        Route::post('/message/store', 'MessageController@store');
        /*
         * HTML не даёт возможности отправлять DELETE-запросы,
         * используем сурогат - метод POST
         * */
        // Удалить сообщение
        Route::post('/message/destroy/{id}', 'MessageController@destroy');

        // Форма регистрации
        Route::get('/reg', function () {

            $userBlock = UserBlock::get();
            return view('messages.reg', $userBlock);
        });
        // Зарегистрировать учётную запись
        Route::post('/reg', 'Auth\RegisterController@register');
        // Страница успешной регистрации
        Route::get('/reg_success', function () {

            $userBlock = UserBlock::get();
            return view('messages.reg_success', $userBlock);
        });

        // Страница входа в учётную запись
        Route::get('/login', function () {

            $userBlock = UserBlock::get();
            return view('messages.login', $userBlock);
        });
        // Войти в учётную запись
        Route::post('/login', 'Auth\LoginController@login');

        // Выйти из учётной записи
        Route::get('/logout', 'Auth\LoginController@logout');
    }
}
