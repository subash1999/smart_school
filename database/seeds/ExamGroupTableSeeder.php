<?php

use Illuminate\Database\Seeder;

class ExamGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\ExamGroup',10)->create();
    }
}
