<?php

use Faker\Generator as Faker;

$factory->define(App\Movie::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'issuer' => $faker->sentence(5),
        'desc' => $faker->paragraph(),
        'download_link' => $faker->url(),
        'is_featured' => false,
        'released_at' => $faker->date($format = 'Y-m-d', $max = 'now')
    ];
});
