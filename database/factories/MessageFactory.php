<?php

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

/** @var EloquentFactory $factory */
$factory->define(App\Models\Message::class, function (Faker $faker) {
    return [
        'content' => $faker->text(),
    ];
});
