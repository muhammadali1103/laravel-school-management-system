<?php

namespace Database\Seeders;

use App\Models\ClassModel;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = Teacher::all();
        $students = Student::all();
        $courses = Course::all();

        $classes = [
            ['name' => 'Grade 9', 'section' => 'A', 'teacher_id' => $teachers->skip(0)->first()->id ?? null, 'capacity' => 30],
            ['name' => 'Grade 9', 'section' => 'B', 'teacher_id' => $teachers->skip(1)->first()->id ?? null, 'capacity' => 30],
            ['name' => 'Grade 10', 'section' => 'A', 'teacher_id' => $teachers->skip(2)->first()->id ?? null, 'capacity' => 30],
            ['name' => 'Grade 10', 'section' => 'B', 'teacher_id' => $teachers->skip(3)->first()->id ?? null, 'capacity' => 30],
        ];

        foreach ($classes as $classData) {
            $class = ClassModel::create($classData);

            // Assign students to classes (5 students per class)
            $class->students()->attach($students->random(min(5, $students->count()))->pluck('id'));

            // Assign courses to classes
            foreach ($courses->take(5) as $index => $course) {
                $class->courses()->attach($course->id, [
                    'teacher_id' => $teachers->skip($index % $teachers->count())->first()->id ?? null,
                ]);
            }
        }
    }
}
