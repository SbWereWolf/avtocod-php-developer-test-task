<?php


namespace App\Http;

use Illuminate\Support\Facades\Validator;

class Validation
{
    // Параметр с текстом сообщения
    const CONTENT = 'content';
    // Параметр с идентификатором сообщения
    const ID = 'id';
    // Параметр с идентификатором учётной записи пользователя
    const AUTH = 'auth';


    /**
     * Возвращает валидатор для проверки перед записью
     *
     * @param string $content собственно сообщение
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function beforeStore(string $content)
    {
        return Validator::make([self::CONTENT => $content],
            [self::CONTENT => 'required|string|max:1024',],
            [self::CONTENT.'.required'=>'Сообщение не может быть пустым']);
    }

    /**
     * Возвращает валидатор для проверки перед удалением
     *
     * @param int $message идентификатор сообщения
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function beforeDestroy(int $message)
    {
        return Validator::make([self::ID => $message],
            [self::ID => 'required|integer|gt:0',]);
    }

    /**
     * Возвращает валидатор для проверки неанонимности запроса
     *
     * @param int $user идентификатор учётной записи
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function ofAuthentication(int $user)
    {
        return Validator::make([self::AUTH => $user], [
            self::AUTH => 'required|integer|gt:0',
        ]);
    }

}
