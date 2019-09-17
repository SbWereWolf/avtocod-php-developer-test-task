<?php

namespace Tests\Unit;

use App\BusinessLogic\Css;
use App\BusinessLogic\Scribe;
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

        $isAdmin = (bool)$userBlock[UserBlock::IS_ADMIN];
        $this->assertFalse($isAdmin,
            'For not authenticated user the parameter `is-admin`'
            . ' must be `false`');
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
        $this->assertTrue(
            array_key_exists(UserBlock::IS_ADMIN, $userBlock),
            'User block has no `is-admin` parameter');

        return $userBlock;
    }

    public function testAuthenticatedUserBlock()
    {
        $this->loginWithUser();

        $userBlock = $this->userBlockStructureTest();

        $this->authenticatedUserTest($userBlock);

        $isAdmin = (bool)$userBlock[UserBlock::IS_ADMIN];
        $this->assertFalse($isAdmin,
            'For authenticated user (not admin) the parameter `is-admin`'
            . ' must be `false`');
    }

    public function testAdminUserBlock()
    {
        $this->loginWithAdmin();

        $userBlock = $this->userBlockStructureTest();

        $this->authenticatedUserTest($userBlock);

        $isAdmin = (bool)$userBlock[UserBlock::IS_ADMIN];
        $this->assertTrue($isAdmin,
            'For authenticated user (not admin) the parameter `is-admin`'
            . ' must be `true`');
    }

    public function authenticatedUserTest(array $userBlock): void
    {
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
        $messages = collect(Scribe::getAll());
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
        $user = $this->loginWithUser();
        $handler = new Scribe($user);

        $text = (Factory::create())->text();

        $post = $handler->store($text);
        $postId = $post[Message::ID];

        $userId = $user['id'];
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

        $handler = new Scribe($user);

        $postId = (int)$data['post'];
        $count = (int)$handler->destroy($postId);

        $this->assertFalse($count < 1,
            'Message was not destroyed');
        $this->assertFalse($count > 1,
            'Several messages were destroyed');


        /* @var $actual \App\Models\Message */
        $actual = DB::table(Message::TABLE)
            ->where(Message::ID, $postId)
            ->first();

        $this->assertTrue(empty($actual),
            'Message was obtained by select');

        $count = (int)$handler->destroy($postId);
        $this->assertTrue($count === 0,
            'Message was not destroyed');
    }

    /**
     * @depends testBeginTransaction
     */
    public function testDestroyWithAdmin()
    {
        $user = $this->loginWithAdmin();
        $handler = new Scribe($user);

        $data = $this->testStore();
        $postId = (int)$data['post'];

        $count = (int)$handler->destroy($postId);

        $this->assertFalse($count < 1,
            'Message was not destroyed');
        $this->assertFalse($count > 1,
            'Several messages were destroyed');

        $actual = DB::table(Message::TABLE)
            ->where(Message::ID, $postId)
            ->first();

        $this->assertTrue(empty($actual),
            'Message was obtained by select');

        $count = (int)$handler->destroy($postId);
        $this->assertTrue($count === 0,
            'Message was not destroyed');
    }


    /**
     * @depends testBeginTransaction
     */
    public function testRollBackTransaction()
    {
        DB::rollBack();

        $this->assertTrue(true);
    }

    public function loginWithUser(): User
    {
        /* @var $user User */
        $user = User::query()->select()
            ->where(User::IS_ADMIN, false)->first();
        Auth::guard()->login($user);

        return $user;
    }

    public function loginWithAdmin(): User
    {
        /* @var $user User */
        $user = User::query()->select()
            ->where(User::IS_ADMIN, true)->first();
        Auth::guard()->login($user);

        return $user;
    }
}
