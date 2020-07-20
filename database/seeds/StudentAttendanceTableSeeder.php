<?php

use Illuminate\Database\Seeder;

class StudentAttendanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\StudentAttendance',10)->create();
    }
}
