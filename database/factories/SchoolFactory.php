<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\School;
use Faker\Generator as Faker;

$factory->define(School::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName." "."Boarding School",
        'address' => $faker->address,
        'district' => $faker->district,
        'phone1' => $faker->phoneNumber,
        'phone2' => $faker->randomElement([null,$faker->phoneNumber]),
        'email1' => $faker->companyEmail,
        'email2' => $faker->randomElement([null,$faker->companyEmail]),
        'logo' => $faker->imageUrl(500,500),
        'description' => $faker->randomHtml(),
    ];
});
