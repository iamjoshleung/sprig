<?php

use Faker\Generator as Faker;

$factory->define(App\Photoset::class, function (Faker $faker) {
    return [
        'images' => $faker->imageUrl($width = 640, $height = 480),
        'site_id' => $faker->randomNumber()
    ];
});
