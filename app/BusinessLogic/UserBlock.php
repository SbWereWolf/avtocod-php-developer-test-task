<?php


namespace App\BusinessLogic;


class UserBlock implements Css
{
    /**
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
        $userBlock = ['username' => $name,
            'forUser' => $forUser, 'forGuest' => $forGuest];

        return $userBlock;
    }
}
