<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CourseSeeder::class,
            UserSeeder::class,  // This already creates admin and teacher with correct credentials
            PakistaniStudentsSeeder::class,  // Only creates Pakistani students and assigns fees
        ]);
    }
}
