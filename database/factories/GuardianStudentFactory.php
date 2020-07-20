<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\GuardianStudent;
use Faker\Generator as Faker;

$factory->define(GuardianStudent::class, function (Faker $faker) {
    $gender = $faker->randomElement(['Male','Female']);
    $relationships = ['Father','Mother',
        'Grand Father','Grand Mother','Aunt','Uncle','Guardian',
        'Maternal Uncle','Maternal Aunt','Brother','Sister','Cousin',
        'Great Grand Father','Great Grand Mother'];
    if(strcasecmp($gender,'Male')==0){
        $relationships = ['Father','Grand Father','Uncle','Guardian',
            'Maternal Uncle', 'Brother', 'Cousin', 'Great Grand Father'];
    }
    elseif (strcasecmp($gender,'Female')==0){
        $relationships = ['Mother','Grand Mother', 'Aunt', 'Guardian',
            'Maternal Aunt', 'Sister', 'Cousin', 'Great Grand Mother'];
    }

    return [
        //
    ];
});
