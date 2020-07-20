<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SchoolSession;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(SchoolSession::class, function (Faker $faker) {
    $from_date =  $faker->dateTimeBetween('-11 years','-2 years');
    $schools = App\School::pluck('id')->toArray();
    return [
        'from'  => $from_date->format('Y-m-d H:i:s'),
        'name' => $from_date->format('Y'),
        'to'  => $from_date->modify('+52 week')->format('Y-m-d H:i:s'),
        'school_id' => $faker->randomElement($schools),
    ];

});
