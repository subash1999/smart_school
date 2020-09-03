<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\StudentGrade;
use Faker\Generator as Faker;

$factory->define(StudentGrade::class, function (Faker $faker) {
    $student_grades = [];
    foreach(App\Grade::all() as $g){
        foreach(App\Student::all() as $s){
//            print_r($student_grades);
            $student_grades[]=[$s->id,$g->id,$g->school_session_id];
        }
    }

    $student_grade = $faker->unique()->randomElement($student_grades);

    $grade_id = $student_grade[1];
    $rolls = App\Grade::find($grade_id)->studentGrades()->pluck('roll_no')->toArray();
    $roll_no = 1;
    if(count($rolls)!=0){
        $roll_no = max($rolls) + 1;
    }

    return [
        'student_id' => $student_grade[0],
        'grade_id' => $student_grade[1],
        'roll_no' => $roll_no,

    ];
});
