<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Teacher;
use Faker\Generator as Faker;

$factory->define(Teacher::class, function (Faker $faker) {
    return [
        'firstname' => $faker->name,
        'surname' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'type' => 'teacher',
        'address' => $faker->word,
        'mobile' => $faker->phoneNumber,
        'cicle_id' => $faker->randomDigitNot(0),
    ];
});
