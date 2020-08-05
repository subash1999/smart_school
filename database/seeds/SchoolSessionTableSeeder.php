<?php

use Illuminate\Database\Seeder;

class SchoolSessionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\SchoolSession',12)->create();
    }
}
