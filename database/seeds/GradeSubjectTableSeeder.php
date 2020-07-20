<?php

use Illuminate\Database\Seeder;

class GradeSubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\GradeSubject',10)->create();
    }
}
