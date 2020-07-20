<?php

use Illuminate\Database\Seeder;

class SchoolCalendarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\SchoolCalendar',10)->create();
    }
}
