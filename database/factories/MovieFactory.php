<?php

use Faker\Generator as Faker;

$factory->define(App\Movie::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'issuer' => $faker->sentence(5),
        'desc' => $faker->paragraph(),
        'download_link' => $faker->url()
    ];
});
