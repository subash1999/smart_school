<?php

use Illuminate\Database\Seeder;

class SuperAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\SuperAdmin',10)->create();
    }
}
