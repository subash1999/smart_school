<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Student;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {
    $gender = $faker->randomElement(['Male','Female']);
    return [
        'name' => $faker->name($gender),
        'gender' => $gender,
        'passport_photo' => $faker->imageUrl($width = 354, $height = 472,'people'),
        'address' => $faker->address,
        'district' => $faker->district,
        'phone1' => $faker->PhoneNumber,
        'phone2' => $faker->randomElement([null,$faker->phoneNumber]),
        'email' => $faker->email,
        'school_id' => $faker->randomElement(App\School::pluck('id')->toArray()),
        'description' => $faker->randomHtml(),
    ];
});
