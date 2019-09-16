<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    const CONTENT = 'content';
    const USER = 'users_id';
    const ID = 'id';
    const AUTHOR = 'author';
    const TABLE = 'message';

    public $timestamps = false;
    protected $table = self::TABLE;
    protected $fillable = [
        'content', 'users_id'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        DB::statement('PRAGMA foreign_keys = ON;');
    }

    public static function withAuthors()
    {

        $result = static::with(static::AUTHOR)
            ->orderBy('message.id', 'desc')
            ->get();

        return $result;
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User',
            'users_id', 'id');
    }
}
