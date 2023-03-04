<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Comment;
use App\Task;
use App\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'task_id' => function () {
            return factory(Task::class)->create()->id;
        },
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'rating' => $faker->numberBetween(1, 5),
        'comment' => $faker->sentence(10),
    ];
});
