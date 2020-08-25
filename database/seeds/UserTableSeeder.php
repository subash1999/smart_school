<?php

use Illuminate\Database\Seeder;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\User',10)->create();
        factory('App\User',2)->states('soft_deleted')->create();
        $user = new \App\User;
        $user->email = "subash.niroula4455@gmail.com";
        $user->password = "password";
        $user->avatar = "https://lorempixel.com/640/480/people/?31435";
        $user->email_verified_at = now();
        $user->save();
    }
}
