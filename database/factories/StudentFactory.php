<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Student;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {
    $gender = $faker->randomElement([['Male','Female']]);
    $grades = App\Grade::pluck('id')->toArray();
    return [
        'name' => $faker->name($gender),
        'gender' => $gender,
        'passport_photo' => $faker->imageUrl($width = 354, $height = 472,'people'),
        'address' => $faker->address,
        'district' => $faker->district,
        'phone1' => $faker->PhoneNumber,
        'phone2' => $faker->randomElement([null,$faker->phoneNumber]),
        'description' => $faker->randomHtml(),
        'user_id' => factory('App\User'),
    ];
});
