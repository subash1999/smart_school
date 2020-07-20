<?php

use Illuminate\Database\Seeder;

class GradeSubjectTeacherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\GradeSubjectTeacher',10)->create();
    }
}
