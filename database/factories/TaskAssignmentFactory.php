<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TaskAssignment;
use Faker\Generator as Faker;

$factory->define(TaskAssignment::class, function (Faker $faker) {
    return [
        'student_id' => $faker->randomDigitNot(0),
        'teacher_id' => $faker->randomDigitNot(0),
        'task_id' => $faker->randomDigitNot(0),
    ];
});
