<?php

use Illuminate\Database\Seeder;

class SchoolAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\SchoolAdmin',10)->create();
    }
}
