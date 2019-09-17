<?php


namespace App\BusinessLogic;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Scribe
{
    /* @var int $user идентификатор пользователя */
    private $user = 0;

    /**
     * Scribe constructor.
     *
     * @param \App\Models\User $user учётная запись пользователя
     *                               от имени которого будут выполняться
     *                               действия
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Получить все сообщения
     *
     * @return \App\Models\Message[]
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
            Message::USER => $this->user['id'],
        ]);

        return $result;
    }

    /**
     * Стереть сообщение, с проверкой прав на операцию
     *
     * @param int $message идентификатор сообщения
     *
     * @return int количество удалённых сообщений
     */
    public function destroy(int $message): int
    {
        $isAdmin = $this->user[User::IS_ADMIN] == true;
        if ($isAdmin) {
            $result = $this->destroyWithAdmin($message);
        }
        if (!$isAdmin) {
            $result = $this->destroyWithUser($message);
        }

        return $result;
    }

    /**
     * Стереть сообщение с правами Админа
     *
     * @param int $message идентификатор сообщения
     *
     * @return int количество удалённых сообщений
     */
    private function destroyWithAdmin(int $message): int
    {
        $result = DB::table(Message::TABLE)
            ->where(Message::ID, $message)
            ->delete();

        return $result;
    }

    /**
     * Стереть сообщение с правами Пользователя
     *
     * @param int $message идентификатор сообщения
     *
     * @return int количество удалённых сообщений
     */
    private function destroyWithUser(int $message): int
    {
        $result = DB::table(Message::TABLE)
            ->where(Message::ID, $message)
            ->where(Message::USER, $this->user['id'])
            ->delete();

        return $result;
    }

}
