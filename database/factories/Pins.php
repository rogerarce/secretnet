<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Pins::class, function (Faker $faker) {
    return [
        "pin"     => substr(md5(microtime() . rand()), 0, 10),
        "status"  => "inactive",
    ];
});
