<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    $grade = $faker->randomDigitNot(0);
    return [
        'num_boscoins' => $grade * 100,
        'title' => $faker->word,
        'imagen' => $faker->word,
        'description' => $faker->word,
        'grade' => $faker->randomDigitNot(0),
        'user_id' => $faker->randomDigitNot(0),
        'cicle_id' => $faker->randomDigitNot(0),
        'completion_date' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        'comment' => $faker->paragraph(),
        'client_address' => $faker->address,
        'client_phone' => $faker->phoneNumber,
        'client_rating' => $faker->numberBetween(1, 5),
    ];
});
