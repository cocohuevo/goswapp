<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'num_boscoins' => $faker->numberBetween(50, 100),
        'description' => $faker->word,
        'date_request' => $faker->date,
        'date_completian' => $faker->date,
        'type' => 'user',
        'is_published' =>false,
        'user_id' => $faker->randomDigitNot(0),
        'profile_id' => $faker->randomDigitNot(0),
    ];
});
