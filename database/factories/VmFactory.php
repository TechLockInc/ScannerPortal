<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
    	'id' => $faker->number,
        'hostname' => $faker->text,
    ];
});
