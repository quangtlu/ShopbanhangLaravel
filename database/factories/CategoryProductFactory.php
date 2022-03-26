<?php

/** @var Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'category_name' => $faker->name,
        'category_desc' => $faker->text,
        'category_status' => 1
    ];
});
