<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ClassModel;
use App\Models\Course;
use App\Models\FeeStructure;
use App\Models\Fee;
use App\Models\Timetable;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PakistaniDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get role IDs
        $adminRole = \App\Models\Role::where('name', 'admin')->first();
        $teacherRole = \App\Models\Role::where('name', 'teacher')->first();

        // Create Admin User (keep credentials same)
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@school.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        try {
            // Create Default Teacher User (keep credentials same)
            $defaultTeacher = User::create([
                'name' => 'Default Teacher',
                'email' => 'teacher@school.com',
                'password' => Hash::make('password'),
                'role_id' => $teacherRole->id,
            ]);

            Teacher::create([
                'user_id' => $defaultTeacher->id,
                'employee_id' => 'TCH-0000',
                'phone' => '+92-321-0000000',
                'address' => 'Lahore, Pakistan',
                'subject_specialization' => 'Mathematics',
                'qualification' => 'M.Sc',
                'joining_date' => Carbon::now()->subYears(5),
            ]);
        } catch (\Exception $e) {
            $this->command->error('Error creating default teacher: ' . $e->getMessage());
            throw $e;
        }

        // Pakistani Teacher Names
        $teacherNames = [
            ['name' => 'Muhammad Ahmed Khan', 'email' => 'ahmed.khan@school.pk', 'phone' => '+92-321-1234567'],
            ['name' => 'Fatima Noor', 'email' => 'fatima.noor@school.pk', 'phone' => '+92-321-2345678'],
            ['name' => 'Ali Hassan', 'email' => 'ali.hassan@school.pk', 'phone' => '+92-321-3456789'],
            ['name' => 'Ayesha Malik', 'email' => 'ayesha.malik@school.pk', 'phone' => '+92-321-4567890'],
            ['name' => 'Usman Tariq', 'email' => 'usman.tariq@school.pk', 'phone' => '+92-321-5678901'],
            ['name' => 'Sara Ali', 'email' => 'sara.ali@school.pk', 'phone' => '+92-321-6789012'],
            ['name' => 'Bilal Ahmed', 'email' => 'bilal.ahmed@school.pk', 'phone' => '+92-321-7890123'],
            ['name' => 'Zainab Hussain', 'email' => 'zainab.hussain@school.pk', 'phone' => '+92-321-8901234'],
        ];

        // Create Teachers
        foreach ($teacherNames as $index => $teacherData) {
            $user = User::create([
                'name' => $teacherData['name'],
                'email' => $teacherData['email'],
                'password' => Hash::make('teacher123'),
                'role_id' => $teacherRole->id,
            ]);

            Teacher::create([
                'user_id' => $user->id,
                'employee_id' => 'TCH-' . str_pad($index + 10, 4, '0', STR_PAD_LEFT), // Start from TCH-0010
                'phone' => $teacherData['phone'],
                'address' => ['Karachi, Pakistan', 'Lahore, Pakistan', 'Islamabad, Pakistan'][$index % 3],
                'subject_specialization' => ['Mathematics', 'English', 'Urdu', 'Science', 'Islamiat', 'Pakistan Studies', 'Computer Science', 'Physics'][$index % 8],
                'qualification' => ['M.A', 'M.Sc', 'B.Ed', 'M.Phil'][$index % 4],
                'joining_date' => Carbon::now()->subYears(rand(1, 10)),
            ]);
        }

        // Get student role
        $studentRole = \App\Models\Role::where('name', 'student')->first();

        // Pakistani Student Names
        $studentNames = [
            // Boys
            ['name' => 'Muhammad Hamza', 'gender' => 'male', 'parent' => 'Muhammad Saeed'],
            ['name' => 'Abdullah Khan', 'gender' => 'male', 'parent' => 'Asif Khan'],
            ['name' => 'Hassan Ali', 'gender' => 'male', 'parent' => 'Muhammad Ali'],
            ['name' => 'Ahmad Raza', 'gender' => 'male', 'parent' => 'Raza Ahmed'],
            ['name' => 'Usman Malik', 'gender' => 'male', 'parent' => 'Tariq Malik'],
            ['name' => 'Ibrahim Yousaf', 'gender' => 'male', 'parent' => 'Yousaf Ahmed'],
            ['name' => 'Zain Abbas', 'gender' => 'male', 'parent' => 'Abbas Ali'],
            ['name' => 'Faisal Sheikh', 'gender' => 'male', 'parent' => 'Sheikh Muhammad'],
            ['name' => 'Saad Khan', 'gender' => 'male', 'parent' => 'Khan Sahib'],
            ['name' => 'Bilal Hassan', 'gender' => 'male', 'parent' => 'Hassan Ali'],
            // Girls
            ['name' => 'Fatima Zahra', 'gender' => 'female', 'parent' => 'Zahra Hussain'],
            ['name' => 'Ayesha Siddique', 'gender' => 'female', 'parent' => 'Siddique Ahmed'],
            ['name' => 'Maryam Noor', 'gender' => 'female', 'parent' => 'Noor Muhammad'],
            ['name' => 'Zainab Batool', 'gender' => 'female', 'parent' => 'Batool Hussain'],
            ['name' => 'Hiba Fatima', 'gender' => 'female', 'parent' => 'Fatima Saeed'],
            ['name' => 'Amina Khan', 'gender' => 'female', 'parent' => 'Khan Muhammad'],
            ['name' => 'Sara Ahmed', 'gender' => 'female', 'parent' => 'Ahmed Hassan'],
            ['name' => 'Laiba Ali', 'gender' => 'female', 'parent' => 'Ali Raza'],
            ['name' => 'Aliza Tariq', 'gender' => 'female', 'parent' => 'Tariq Mehmood'],
            ['name' => 'Alizeh Malik', 'gender' => 'female', 'parent' => 'Malik Saeed'],
        ];

        // Create Students
        foreach ($studentNames as $studentData) {
            $user = User::create([
                'name' => $studentData['name'],
                'email' => strtolower(str_replace(' ', '.', $studentData['name'])) . '@student.pk',
                'password' => Hash::make('student123'),
                'role_id' => $studentRole->id,
            ]);

            Student::create([
                'user_id' => $user->id,
                'roll_number' => 'STD-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'phone' => '+92-300-' . rand(1000000, 9999999),
                'address' => ['Karachi', 'Lahore', 'Islamabad', 'Rawalpindi', 'Faisalabad', 'Multan', 'Peshawar', 'Quetta'][$index % 8] . ', Pakistan',
                'date_of_birth' => Carbon::now()->subYears(rand(14, 18))->subDays(rand(1, 365)),
                'gender' => $studentData['gender'],
                'parent_name' => $studentData['parent'],
                'parent_phone' => '+92-300-' . rand(1000000, 9999999),
            ]);
        }

        // Get all teachers and students
        $teachers = Teacher::all();
        $students = Student::all();

        // Pakistani Classes
        $classData = [
            ['name' => 'Class 9', 'section' => 'A', 'capacity' => 40],
            ['name' => 'Class 9', 'section' => 'B', 'capacity' => 40],
            ['name' => 'Class 10', 'section' => 'A', 'capacity' => 40],
            ['name' => 'Class 10', 'section' => 'B', 'capacity' => 40],
            ['name' => 'Class 11', 'section' => 'A', 'capacity' => 35],
            ['name' => 'Class 12', 'section' => 'A', 'capacity' => 35],
        ];

        $classes = [];
        foreach ($classData as $index => $data) {
            $class = ClassModel::create([
                'name' => $data['name'],
                'section' => $data['section'],
                'teacher_id' => $teachers[$index % $teachers->count()]->id,
                'capacity' => $data['capacity'],
            ]);
            $classes[] = $class;

            // Assign students to classes (distribute evenly)
            $studentsPerClass = (int) ceil($students->count() / count($classData));
            $studentsForClass = $students->slice($index * $studentsPerClass, $studentsPerClass);
            $class->students()->attach($studentsForClass->pluck('id'));
        }

        // Fee Structures in PKR
        $feeStructures = [
            ['name' => 'Monthly Tuition Fee - Class 9', 'fee_type' => 'Tuition Fee', 'amount' => 5000, 'class_id' => $classes[0]->id],
            ['name' => 'Monthly Tuition Fee - Class 10', 'fee_type' => 'Tuition Fee', 'amount' => 5500, 'class_id' => $classes[2]->id],
            ['name' => 'Monthly Tuition Fee - Class 11', 'fee_type' => 'Tuition Fee', 'amount' => 6000, 'class_id' => $classes[4]->id],
            ['name' => 'Monthly Tuition Fee - Class 12', 'fee_type' => 'Tuition Fee', 'amount' => 6500, 'class_id' => $classes[5]->id],
            ['name' => 'Admission Fee', 'fee_type' => 'Admission Fee', 'amount' => 10000, 'class_id' => null],
            ['name' => 'Transport Fee', 'fee_type' => 'Transport Fee', 'amount' => 3000, 'class_id' => null],
            ['name' => 'Laboratory Fee', 'fee_type' => 'Laboratory Fee', 'amount' => 2000, 'class_id' => null],
            ['name' => 'Library Fee', 'fee_type' => 'Library Fee', 'amount' => 1000, 'class_id' => null],
            ['name' => 'Sports Fee', 'fee_type' => 'Sports Fee', 'amount' => 1500, 'class_id' => null],
            ['name' => 'Examination Fee', 'fee_type' => 'Examination Fee', 'amount' => 2500, 'class_id' => null],
        ];

        foreach ($feeStructures as $structure) {
            FeeStructure::create(array_merge($structure, [
                'description' => 'Standard fee structure for Pakistani school',
                'is_active' => true,
            ]));
        }

        // Assign fees to students
        foreach ($students->take(10) as $index => $student) {
            Fee::create([
                'fee_structure_id' => $index % 4 + 1, // Rotate through tuition fees
                'student_id' => $student->id,
                'amount' => [5000, 5500, 6000, 6500][$index % 4],
                'discount' => $index % 5 == 0 ? 500 : 0, // 10% discount for some students
                'paid_amount' => $index % 3 == 0 ? [5000, 5500, 6000, 6500][$index % 4] : ($index % 2 == 0 ? 2500 : 0),
                'due_date' => Carbon::now()->addDays(30),
                'paid_date' => $index % 3 == 0 ? Carbon::now()->subDays(5) : null,
                'status' => $index % 3 == 0 ? 'paid' : ($index % 2 == 0 ? 'partial' : 'pending'),
                'fee_type' => 'Tuition Fee',
                'payment_method' => $index % 3 == 0 ? ['cash', 'bank', 'online'][$index % 3] : null,
            ]);
        }

        // Pakistani Timetable (Monday to Friday)
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $subjects = ['Mathematics', 'English', 'Urdu', 'Islamiat', 'Pakistan Studies', 'Computer Science', 'Physics', 'Chemistry'];
        $times = ['08:00-09:00', '09:00-10:00', '10:00-11:00', '11:00-12:00', '12:00-13:00'];

        // Get courses for reference
        $allCourses = Course::all();

        foreach ($classes as $class) {
            foreach ($days as $dayIndex => $day) {
                foreach ([0, 1, 2] as $periodIndex) { // 3 periods per day
                    $subject = $subjects[($dayIndex + $periodIndex) % count($subjects)];

                    // Find a teacher who teaches this subject or use random
                    $teacher = $teachers->where('subject_specialization', $subject)->first();
                    if (!$teacher) {
                        $teacher = $teachers->random();
                    }

                    // Find the course by name
                    $course = $allCourses->where('name', $subject)->first();
                    if (!$course) {
                        $course = $allCourses->first();
                    }

                    $timeSlot = $times[$periodIndex];
                    list($startTime, $endTime) = explode('-', $timeSlot);

                    Timetable::create([
                        'class_id' => $class->id,
                        'course_id' => $course->id,
                        'teacher_id' => $teacher->id,
                        'day' => $day,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                    ]);
                }
            }
        }

        $this->command->info('Pakistani data seeded successfully!');
    }
}
