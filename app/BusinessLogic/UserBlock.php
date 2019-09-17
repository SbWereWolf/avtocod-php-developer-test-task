<?php


namespace App\BusinessLogic;


use App\Models\User;

class UserBlock implements Css
{
    // имя учётной записи
    const USERNAME = 'username';
    // параметр отображения для прошедших аутентификацию
    const FOR_USER = 'forUser';
    // параметр отображения для гостей
    const FOR_GUEST = 'forGuest';
    // параметр признака роли Администратора
    const IS_ADMIN = 'isAdmin';

    /**
     * Получить параметры разметки для
     * областей зависимых от пользователя
     *
     * @return array параметры отображения интерфейас
     */
    public static function get(): array
    {
        $user = auth()->user();

        $isAnonymous = !is_object($user);
        if ($isAnonymous) {
            $name = '';
            $forUser = static::INVISIBLE;
            $forGuest = static::VISIBLE;
            $isAdmin = false;
        }
        if (!$isAnonymous) {
            $name = $user->name;
            $forUser = static::VISIBLE;
            $forGuest = static::INVISIBLE;

        }
        if (!$isAnonymous) {
            $isAdmin = (bool)$user[User::IS_ADMIN];
        }
        $userBlock = [self::USERNAME => $name, self::IS_ADMIN => $isAdmin,
            self::FOR_USER => $forUser, self::FOR_GUEST => $forGuest];

        return $userBlock;
    }
}
