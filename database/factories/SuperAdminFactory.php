<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SuperAdmin;
use Faker\Generator as Faker;

$factory->define(SuperAdmin::class, function (Faker $faker) {
    $gender = $faker->randomElement(['Male','Female']);
    return [
        'name' => $faker->name($gender),
        'gender' => $gender,
        'passport_photo' => $faker->imageUrl($width = 354, $height = 472,'people'),
        'address' => $faker->address,
        'district' => $faker->district,
        'phone1' => $faker->PhoneNumber,
        'description' => $faker->randomHtml(),
        'user_id' => factory('App\User'),
    ];
});

