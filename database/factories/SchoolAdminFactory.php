<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SchoolAdmin;
use App\School;
use Faker\Generator as Faker;

$factory->define(SchoolAdmin::class, function (Faker $faker) {
    $schools = App\School::pluck('id')->toArray();
    $gender = $faker->randomElement(['Male','Female']);
    return [
        'name' => $faker->name($gender),
        'gender' => $gender,
        'passport_photo' => $faker->imageUrl(354,472),
        'address' => $faker->address,
        'district' => $faker->district,
        'phone1' => $faker->phoneNumber,
        'phone2' => $faker->randomElement([null,$faker->phoneNumber]),
        'description' => $faker->randomHtml(),
        'user_id' => factory('App\User'),
        'school_id' => $faker->randomElement($schools),
    ];
});
