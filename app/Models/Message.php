<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    // Колонка собственно сообщения
    const CONTENT = 'content';
    // Колонка ссылки на учётную запись пользователя
    const USER = 'users_id';
    // Колонка идентификатора записи таблицы
    const ID = 'id';
    // Наименование отношения "Автор поста"
    const AUTHOR = 'author';
    // Наименование таблицы
    const TABLE = 'message';

    // не записывать отметки времени
    public $timestamps = false;
    protected $table = self::TABLE;
    protected $fillable = [
        'content', 'users_id'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        /*
         * SQLite по умолчанию не включает функционал внешних ключей,
         * включаем в ручную, каждый раз когда начинаем работу
         * */
        DB::statement('PRAGMA foreign_keys = ON;');
    }

    /**
     * Все сообщения совместно с информацией об авторах
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function withAuthors()
    {
        $result = static::with(static::AUTHOR)
            ->orderBy('message.id', 'desc')
            ->get();

        return $result;
    }

    /**
     * Отношение "Автор поста",
     * стыковка автора поста с учёной записью пользователя
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('App\Models\User',
            'users_id', 'id');
    }
}
