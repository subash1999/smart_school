<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\GuardianStudent;
use Faker\Generator as Faker;

$factory->define(GuardianStudent::class, function (Faker $faker) {
    $guardian_ids = App\Guardian::all()->pluck('id')->toArray();
    $guardian_ids = array_merge($guardian_ids,App\Guardian::all()->pluck('id')->toArray());
    $guardian_id = $faker->unique()->randomElement($guardian_ids);
    $guardian = App\Guardian::find($guardian_id);
    $guardian_students = array();
    $student = App\Student::where('school_id',$guardian->school_id)->get()->random();
    if (!in_array([$guardian->id,$student->id],$guardian_students)){
        array_push($guardian_students,[$guardian->id,$student->id]);
    }
    $relationships = ['Father','Mother',
        'Grand Father','Grand Mother','Aunt','Uncle','Guardian',
        'Maternal Uncle','Maternal Aunt','Brother','Sister','Cousin',
        'Great Grand Father','Great Grand Mother'];
    if(strcasecmp($guardian->gender,'Male')==0){
        $relationships = ['Father','Grand Father','Uncle','Guardian',
            'Maternal Uncle', 'Brother', 'Cousin', 'Great Grand Father'];
    }
    elseif (strcasecmp($guardian->gender,'Female')==0){
        $relationships = ['Mother','Grand Mother', 'Aunt', 'Guardian',
            'Maternal Aunt', 'Sister', 'Cousin', 'Great Grand Mother'];
    }
    $guardian_student = $faker->unique()->randomElement($guardian_students);
    return [
        'guardian_id' => $guardian_student[0],
        'student_id' => $guardian_student[1],
        'relation_to_student' => $faker->randomElement($relationships),
    ];
});
