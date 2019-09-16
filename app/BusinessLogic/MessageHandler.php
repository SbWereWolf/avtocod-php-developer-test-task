<?php


namespace App\BusinessLogic;

use App\Models\Message;
use Illuminate\Support\Facades\DB;

class MessageHandler
{
    private $user = 0;

    public function __construct(int $user)
    {
        $this->user = $user;
    }

    public static function getAll(): array
    {
        $twits = Message::withAuthors()->all();

        return $twits;
    }

    public function store(string $content): Message
    {
        $result = Message::create([
            Message::CONTENT => $content,
            Message::USER => $this->user,
        ]);

        return $result;
    }

    public function destroy(int $message): int
    {
        $result = DB::table(Message::TABLE)
            ->where(Message::ID, $message)
            ->where(Message::USER, $this->user)
            ->delete();

        return $result;
    }
}
