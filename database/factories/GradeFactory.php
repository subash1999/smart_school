<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Grade;
use Faker\Generator as Faker;

$factory->define(Grade::class, function (Faker $faker) {
    $school_sessions = App\SchoolSession::pluck('id')->toArray();
    $grade_name = range(1,10);
    $section = ['A','B',null];
    $grade = [];
    foreach ($grade_name as $g){
            foreach ($school_sessions as $ss){
                if($g!=10 && $g != 9 && $g != 8){
                    array_push($grade,[$g,'A',$ss]);
                    array_push($grade,[$g,'B',$ss]);
                }
                else{
                    array_push($grade,[$g,null,$ss]);
                }
        }

    }
    $rand_index = $faker->unique()->numberBetween(0,count($grade)-1);
    return [
        'grade_name' => $grade[$rand_index][0],
        'section' => $grade[$rand_index][1],
        'school_session_id' => $grade[$rand_index][2],
    ];
});
