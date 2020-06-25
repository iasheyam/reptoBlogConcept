<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CommentReply;
use App\User;
use Faker\Generator as Faker;

$factory->define(CommentReply::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'comment_id' => \App\Comment::all()->random()->id,
        'body' => $faker->paragraph(3)
    ];
});
