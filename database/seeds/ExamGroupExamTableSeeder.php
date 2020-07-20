<?php

use Illuminate\Database\Seeder;

class ExamGroupExamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\ExamGroupExam',10)->create();
    }
}
