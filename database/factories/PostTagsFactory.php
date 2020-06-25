<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PostTags;
use Faker\Generator as Faker;

$factory->define(PostTags::class, function (Faker $faker) {
    return [
        'post_id' => Post::all()->random()->id,
        'tag_id' => Tag::all()->random()->id
    ];
});
