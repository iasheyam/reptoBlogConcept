<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use App\CommentVote;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(CommentVote::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'comment_id' => Comment::all()->random()->id,
        // todo Couldn't generate unique composite relation between user_id and comment_id
        'vote_type_id' => DB::table('vote_types')->inRandomOrder()->first()->id,
    ];
});
