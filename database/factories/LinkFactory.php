<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Link;
use Faker\Generator as Faker;

$factory->define(Link::class, function (Faker $faker) {
    return [
        'url' => 'www.facebook.com/' . $faker->uuid(),
        'shortcode' => $faker->lexify('??????'),
        'redirectCount' => 0
    ];
});
