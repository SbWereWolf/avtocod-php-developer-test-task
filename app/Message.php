<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    const CONTENT = 'content';
    const USER = 'users_id';
    const AUTHOR = 'author';

    public $timestamps = false;
    protected $table = 'message';
    protected $fillable = [
        'content', 'users_id'
    ];

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
