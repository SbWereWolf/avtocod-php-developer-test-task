<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->times(\mt_rand(3, 7))->create()
            ->each(function (User $user) {
                $rounds = \mt_rand(0, 2);
                for ($index = 0; $index < $rounds; $index++) {
                    $user->messages()
                        ->save(factory(App\Models\Message::class)
                            ->make());
                }
            });;
    }
}
