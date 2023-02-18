<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'num_boscoins' => $faker->numberBetween(50, 100),
        'title' => $faker->word,
        'imagen' => $faker->word,
        'description' => $faker->word,
        'grade' => $faker->randomDigitNot(0),
        'user_id' => $faker->randomDigitNot(0),
        'cicle_id' => $faker->randomDigitNot(0),
    ];
});
