<?php

use Illuminate\Database\Seeder;

class TeacherAttendanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\TeacherAttendance',10)->create();
    }
}
