<?php

use Faker\Generator as Faker;

$factory->define(App\File::class, function (Faker $faker) {
    return [
        'name' => 'random.jpg',
        'size' => rand(100, 10000),
        'mime' => $faker->mimeType,
        'path' => '/path/random.jpg'
    ];
});
