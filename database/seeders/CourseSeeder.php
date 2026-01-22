<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            ['name' => 'Mathematics', 'code' => 'MATH101', 'description' => 'Mathematics', 'credits' => 4],
            ['name' => 'English', 'code' => 'ENG101', 'description' => 'English Language', 'credits' => 3],
            ['name' => 'Urdu', 'code' => 'URD101', 'description' => 'Urdu Language', 'credits' => 3],
            ['name' => 'Islamiat', 'code' => 'ISL101', 'description' => 'Islamic Studies', 'credits' => 2],
            ['name' => 'Pakistan Studies', 'code' => 'PAK101', 'description' => 'Pakistan Studies', 'credits' => 2],
            ['name' => 'Computer Science', 'code' => 'CS101', 'description' => 'Computer Science', 'credits' => 3],
            ['name' => 'Physics', 'code' => 'PHY101', 'description' => 'Physics', 'credits' => 4],
            ['name' => 'Chemistry', 'code' => 'CHEM101', 'description' => 'Chemistry', 'credits' => 4],
            ['name' => 'Biology', 'code' => 'BIO101', 'description' => 'Biology', 'credits' => 4],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
