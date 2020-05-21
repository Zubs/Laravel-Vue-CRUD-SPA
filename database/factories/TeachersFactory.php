<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Teachers;
use Faker\Generator as Faker;

$factory->define(Teachers::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'price' => random_int(1000, 10000)
    ];
});
