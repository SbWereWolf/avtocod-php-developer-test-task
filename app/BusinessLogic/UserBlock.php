<?php


namespace App\BusinessLogic;


class UserBlock implements Css
{
    const USERNAME = 'username';
    const FOR_USER = 'forUser';
    const FOR_GUEST = 'forGuest';

    /**
     * Получить параметры разметки для
     * областей зависимых от пользователя
     *
     * @return array
     */
    public static function get(): array
    {
        $user = auth()->user();

        $isAnonymous = !is_object($user);
        if ($isAnonymous) {
            $name = '';
            $forUser = static::INVISIBLE;
            $forGuest = static::VISIBLE;
        }
        if (!$isAnonymous) {
            $name = $user->name;
            $forUser = static::VISIBLE;
            $forGuest = static::INVISIBLE;
        }
        $userBlock = [self::USERNAME => $name,
            self::FOR_USER => $forUser, self::FOR_GUEST => $forGuest];

        return $userBlock;
    }
}
