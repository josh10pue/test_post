<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;

$factory->define(App\Models\Example::class, function (Faker $faker) {
    return [
        'path' => $faker->randomElement(config('routes.dummy')),
    ];
});
