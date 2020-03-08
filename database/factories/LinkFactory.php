<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Link;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Link::class, function (Faker $faker) {
    return [
        'url' => $faker->name(),
        'shortcode' => $faker->name(),
        'redirectCount' => 0
    ];
});
