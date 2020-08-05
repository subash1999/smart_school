<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         $this->call(UserSeeder::class);
         $this->call(SuperAdminTableSeeder::class);
         $this->call(SchoolTableSeeder::class);
         $this->call(SchoolAdminTableSeeder::class);
         $this->call(SchoolSessionTableSeeder::class);
         $this->call(GuardianTableSeeder::class);
         $this->call(GradeTableSeeder::class);
         $this->call(StudentTableSeeder::class);
         $this->call(GuardianStudentTableSeeder::class);
         $this->call(StudentGradeTableSeeder::class);
    }
}
