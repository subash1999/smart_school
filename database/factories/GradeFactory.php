<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Grade;
use Faker\Generator as Faker;

$factory->define(Grade::class, function (Faker $faker) {
    $grade_name = range(1,10);
    $section = ['A','B',null];
    $grade = [];
    foreach ($grade_name as $g){
        if($g!=10 && $g != 9 && $g != 8){
            array_push($grade,[$g,'A']);
            array_push($grade,[$g,'B']);
        }
        else{
            array_push($grade,[$g,null]);
        }
    }
    $rand_index = $faker->unique()->numberBetween(0,count($grade)-1);
    return [
        'grade_name' => $grade[$rand_index][0],
        'section' => $grade[$rand_index][1],
    ];
});
