<?php

use Faker\Generator as Faker;

$factory->define(App\DownloadToken::class, function (Faker $faker) {
    return [
        'token' => str_random(20),
        'file_id' => function() {
            return factory(App\File::class)->create()->id;
        },
        'expired_at' => now()->addMinutes(30)
    ];
});
