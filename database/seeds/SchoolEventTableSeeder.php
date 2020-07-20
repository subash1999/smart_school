<?php

use Illuminate\Database\Seeder;

class SchoolEventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\SchoolEvent',10)->create();
    }
}
