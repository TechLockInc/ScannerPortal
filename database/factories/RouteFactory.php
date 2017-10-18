<?php

use Faker\Generator as Faker;


$factory->define(App\Route::class, function (Faker $faker) {

    return [
    	'id' => $faker->number;
    	'subnet' => $faker->text,
        'mask' => $faker->text,
        'gateway' => $faker->number,
    ];
});
