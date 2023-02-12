<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cicle;
use Faker\Generator as Faker;

$factory->define(Cicle::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->word,
    ];
});
