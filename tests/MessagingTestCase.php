<?php

namespace Tests\Unit;

use App\BusinessLogic\Css;
use App\BusinessLogic\MessageHandler;
use App\BusinessLogic\UserBlock;
use App\Models\Message;
use App\Models\User;
use Faker\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\AbstractTestCase;

class MessagingTestCase extends AbstractTestCase
{
    public function testUnauthenticatedUserBlock()
    {
        $userBlock = $this->userBlockStructureTest();

        $userName = $userBlock[UserBlock::USERNAME];
        $this->assertTrue(empty($userName),
            'For not authenticated user the parameter `username`'
            . ' must be empty');

        $forUser = $userBlock[UserBlock::FOR_USER];
        $this->assertEquals(Css::INVISIBLE, $forUser,
            'For not authenticated user the parameter `for-user`'
            . ' must has `invisible` value');
        $forGuest = $userBlock[UserBlock::FOR_GUEST];
        $this->assertEquals(Css::VISIBLE, $forGuest,
            'For not authenticated user the parameter `for-guest`'
            . ' must has `visible` value');

        $this->assertFalse($forUser === $forGuest,
            'parameters `for-user` and `for-guest`'
            . ' must has different values');
    }

    public function userBlockStructureTest(): array
    {
        $userBlock = UserBlock::get();

        $this->assertTrue(is_array($userBlock),
            'User block are not array');
        $this->assertTrue(
            array_key_exists(UserBlock::USERNAME, $userBlock),
            'User block has no `username` parameter');
        $this->assertTrue(
            array_key_exists(UserBlock::FOR_USER, $userBlock),
            'User block has no `for-user` parameter');
        $this->assertTrue(
            array_key_exists(UserBlock::FOR_GUEST, $userBlock),
            'User block has no `for-guest` parameter');
        return $userBlock;
    }

    public function testAuthenticatedUserBlock()
    {
        $user = User::query()->select()->first();
        Auth::guard()->login($user);

        $userBlock = $this->userBlockStructureTest();

        $userName = $userBlock[UserBlock::USERNAME];
        $this->assertTrue(!empty($userName),
            'For authenticated user the parameter `username`'
            . ' must has value');

        $forUser = $userBlock[UserBlock::FOR_USER];
        $this->assertEquals(Css::VISIBLE, $forUser,
            'For authenticated user the parameter `for-user`'
            . ' must has `visible` value');
        $forGuest = $userBlock[UserBlock::FOR_GUEST];
        $this->assertEquals(Css::INVISIBLE, $forGuest,
            'For authenticated user the parameter `for-guest`'
            . ' must has `invisible` value');

        $this->assertFalse($forUser === $forGuest,
            'parameters `for-user` and `for-guest`'
            . ' must has different values');
    }

    public function testBeginTransaction()
    {
        DB::beginTransaction();

        $this->assertTrue(true);
    }

    /**
     * @depends testBeginTransaction
     */
    public function testShow()
    {
        $messages = collect(MessageHandler::getAll());
        $all = collect(Message::all()->sortByDesc('id'));

        $isEqual = $messages->count() === $all->count();
        $this->assertTrue($isEqual,
            'Количество всех постов и постов в таблице различается');

        /* @var $some Message */
        $some = $all->first();
        $attributes = array_keys($some->getAttributes());

        $total = $messages->count();
        for ($index = 0; $index <= $total; $index++) {
            $message = $messages->pop();
            $item = $all->pop();

            foreach ($attributes as $attribute) {
                $isEqual = $message[$attribute] === $item[$attribute];
                $this->assertTrue($isEqual,
                    "Attribute `$attribute` of messages" .
                    " with id `{$message['id']}` and " .
                    "with id  `{$item['id']}`` is not equal"
                );
            }
        }
    }

    /**
     * @depends testBeginTransaction
     */
    public function testStore()
    {
        $user = User::query()->select()->first();
        Auth::guard()->login($user);

        $userId = $user['id'];
        $handler = new MessageHandler($userId);

        $text = (Factory::create())->text();

        $post = $handler->store($text);
        $postId = $post[Message::ID];

        /* @var $actual \App\Models\Message */
        $actual = DB::table(Message::TABLE)
            ->where(Message::ID, $postId)
            ->where(Message::USER, $userId)
            ->where(Message::CONTENT, $text)
            ->first();

        $this->assertTrue(!empty($actual), 'Message was not store');

        return ['user' => (int)$userId, 'post' => (int)$postId];
    }

    /**
     * @depends testStore
     *
     */
    public function testDestroy(array $data)
    {
        $userId = $data['user'];
        $user = User::find($userId);
        Auth::guard()->login($user);

        $handler = new MessageHandler($userId);

        $postId = (int)$data['post'];
        $count = (int)$handler->destroy($postId);

        $this->assertFalse($count < 1, 'Message was not destroyed');
        $this->assertFalse($count > 1, 'Several messages were destroyed');


        /* @var $actual \App\Models\Message */
        $actual = DB::table(Message::TABLE)
            ->where(Message::ID, $postId)
            ->first();

        $this->assertTrue(empty($actual), 'Message was obtained by select');

        $count = (int)$handler->destroy($postId);
        $this->assertTrue($count === 0, 'Message was not destroyed');
    }

    /**
     * @depends testBeginTransaction
     */
    public function testRollBackTransaction()
    {
        DB::rollBack();

        $this->assertTrue(true);
    }
}
