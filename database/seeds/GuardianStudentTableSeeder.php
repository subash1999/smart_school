<?php

use Illuminate\Database\Seeder;

class GuardianStudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\GuardianStudent',1200)->create();
    }
}
