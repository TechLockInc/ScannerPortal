<?php

use Faker\Generator as Faker;


$factory->define(App\Appliance::class, function (Faker $faker) {

    return [
    	'id' => $faker->number,
        'client_code' => $faker->text,
        'client_name' => $faker->text,
        'tunnel' => $faker->text,
        'external'=> $faker->text,
        'hostname' => $faker->number,
    ];
});
