<?php


namespace App\Http;

use Illuminate\Support\Facades\Validator;

class Validation
{
    const CONTENT = 'content';
    const ID = 'id';
    const AUTH = 'auth';

    /**
     * Get a validator for an incoming request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function beforeStore(string $content)
    {
        return Validator::make([self::CONTENT => $content],
            [self::CONTENT => 'required|string|max:1024',],
            [self::CONTENT.'.required'=>'Сообщение не может быть пустым']);
    }

    public static function beforeDestroy(int $message)
    {
        return Validator::make([self::ID => $message],
            [self::ID => 'required|integer|gt:0',]);
    }

    public static function ofAuthentication(int $user)
    {
        return Validator::make([self::AUTH => $user], [
            self::AUTH => 'required|integer|gt:0',
        ]);
    }

}
