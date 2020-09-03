<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class StudentGradeTableSeeder extends Seeder
{
    public function run()
    {
        factory('App\StudentGrade',4000)->create();
    }
}
