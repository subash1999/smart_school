<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Guardian;
use Faker\Generator as Faker;

$factory->define(Guardian::class, function (Faker $faker) {
    $gender = $faker->randomElement(['Male','Female']);
    return [
        'name' => $faker->name($gender),
        'gender' => $gender,
        'passport_photo' => $faker->imageUrl($width = 354, $height = 472,'people'),
        'address' => $faker->address,
        'district' => $faker->district,
        'phone1' => $faker->PhoneNumber,
        'phone2' => $faker->randomElement([null,$faker->phoneNumber]),
        'description' => $faker->randomHtml(),
        'school_id' => $faker->randomElement(App\School::pluck('id')->toArray()),
        'user_id' => factory('App\User'),
    ];
});
