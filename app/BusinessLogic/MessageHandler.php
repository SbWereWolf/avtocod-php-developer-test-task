<?php


namespace App\BusinessLogic;

use App\Models\Message;
use Illuminate\Support\Facades\DB;

class MessageHandler
{
    /* @var int $user идентификатор пользователя */
    private $user = 0;

    /**
     * MessageHandler constructor.
     *
     * @param int $user идентификатор пользователя автора сообщений
     */
    public function __construct(int $user)
    {
        $this->user = $user;
    }

    /**
     * Получить все сообщения
     *
     * @return array
     */
    public static function getAll(): array
    {
        $twits = Message::withAuthors()->all();

        return $twits;
    }

    /**
     * Записать сообщение
     *
     * @param string $content собственно сообщение
     *
     * @return Message
     */
    public function store(string $content): Message
    {
        $result = Message::create([
            Message::CONTENT => $content,
            Message::USER => $this->user,
        ]);

        return $result;
    }

    /**
     * Стереть сообщение
     *
     * @param int $message
     *
     * @return int
     */
    public function destroy(int $message): int
    {
        $result = DB::table(Message::TABLE)
            ->where(Message::ID, $message)
            ->where(Message::USER, $this->user)
            ->delete();

        return $result;
    }
}
