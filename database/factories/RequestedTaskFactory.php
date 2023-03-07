<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\RequestedTask;
use Faker\Generator as Faker;

$factory->define(RequestedTask::class, function (Faker $faker) {
    return [
        'cicle_id' => $faker->randomDigitNot(0),
        'task_id' => $faker->randomDigitNot(0),
        'student_id' => $faker->randomDigitNot(0),
        'assignment' => $faker->boolean,
    ];
});