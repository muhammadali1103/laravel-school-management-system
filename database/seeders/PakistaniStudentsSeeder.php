<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\FeeStructure;
use App\Models\Fee;
use App\Models\Timetable;
use App\Models\Teacher;
use App\Models\Course;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PakistaniStudentsSeeder extends Seeder
{
    public function run(): void
    {
        $studentRole = \App\Models\Role::where('name', 'student')->first();
        $teacherRole = \App\Models\Role::where('name', 'teacher')->first();

        // Pakistani Student Names with parent names
        $studentNames = [
            // Boys
            ['name' => 'Muhammad Hamza', 'gender' => 'male', 'parent' => 'Muhammad Saeed Khan'],
            ['name' => 'Abdullah Khan', 'gender' => 'male', 'parent' => 'Asif Khan'],
            ['name' => 'Hassan Ali', 'gender' => 'male', 'parent' => 'Muhammad Ali Raza'],
            ['name' => 'Ahmad Raza', 'gender' => 'male', 'parent' => 'Raza Ahmed'],
            ['name' => 'Usman Malik', 'gender' => 'male', 'parent' => 'Tariq Malik'],
            ['name' => 'Ibrahim Yousaf', 'gender' => 'male', 'parent' => 'Yousaf Ahmed'],
            ['name' => 'Zain Abbas', 'gender' => 'male', 'parent' => 'Abbas Ali'],
            ['name' => 'Faisal Sheikh', 'gender' => 'male', 'parent' => 'Sheikh Muhammad'],
            ['name' => 'Saad Khan', 'gender' => 'male', 'parent' => 'Khan Ahmed'],
            ['name' => 'Bilal Hassan', 'gender' => 'male', 'parent' => 'Hassan Mahmood'],
            ['name' => 'Hamza Tariq', 'gender' => 'male', 'parent' => 'Tariq Masood'],
            ['name' => 'Danyal Ahmed', 'gender' => 'male', 'parent' => 'Ahmed Hussain'],
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
            ['name' => 'Rida Fatima', 'gender' => 'female', 'parent' => 'Fatima Noor'],
            ['name' => 'Hoorain Abbas', 'gender' => 'female', 'parent' => 'Abbas Khan'],
            ['name' => 'Khadija Noor', 'gender' => 'female', 'parent' => 'Noor Ahmed'],
        ];

        // Create Pakistani Students
        $students = [];
        foreach ($studentNames as $index => $studentData) {
            $user = User::create([
                'name' => $studentData['name'],
                'email' => strtolower(str_replace(' ', '.', $studentData['name'])) . '@student.pk',
                'password' => Hash::make('student123'),
                'role_id' => $studentRole->id,
            ]);

            $student = Student::create([
                'user_id' => $user->id,
                'roll_number' => 'STD-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'phone' => '+92-300-' . rand(1000000, 9999999),
                'address' => ['Karachi', 'Lahore', 'Islamabad', 'Rawalpindi', 'Faisalabad', 'Multan'][$index % 6] . ', Pakistan',
                'date_of_birth' => Carbon::now()->subYears(rand(14, 18))->subDays(rand(1, 365)),
                'gender' => $studentData['gender'],
                'parent_name' => $studentData['parent'],
                'parent_phone' => '+92-300-' . rand(1000000, 9999999),
            ]);
            $students[] = $student;
        }

        $teachers = Teacher::all();

        // Create Pakistani Classes
        $classData = [
            ['name' => 'Class 9', 'section' => 'A', 'capacity' => 35],
            ['name' => 'Class 9', 'section' => 'B', 'capacity' => 35],
            ['name' => 'Class 10', 'section' => 'A', 'capacity' => 35],
            ['name' => 'Class 10', 'section' => 'B', 'capacity' => 35],
            ['name' => 'Class 11', 'section' => 'A', 'capacity' => 30],
            ['name' => 'Class 12', 'section' => 'A', 'capacity' => 30],
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
        }

        // Assign students to classes
        $studentsPerClass = (int) ceil(count($students) / count($classes));
        foreach ($classes as $index => $class) {
            $classStudents = array_slice($students, $index * $studentsPerClass, $studentsPerClass);
            $studentIds = array_map(fn($s) => $s->id, $classStudents);
            $class->students()->attach($studentIds);
        }

        // Fee Structures in PKR
        $feeStructures = [
            ['name' => 'Monthly Tuition Fee - Class 9', 'fee_type' => 'Tuition Fee', 'amount' => 5000, 'class_id' => $classes[0]->id ?? null],
            ['name' => 'Admission Fee', 'fee_type' => 'Admission Fee', 'amount' => 10000, 'class_id' => null],
            ['name' => 'Transport Fee', 'fee_type' => 'Transport Fee', 'amount' => 3000, 'class_id' => null],
        ];

        foreach ($feeStructures as $structure) {
            FeeStructure::create(array_merge($structure, [
                'description' => 'Standard fee in PKR',
                'is_active' => true,
            ]));
        }

        // Assign fees to students with varied statuses
        foreach ($students as $i => $student) {
            // Create multiple fee types for each student
            $feeTypes = [
                ['structure_id' => 1, 'amount' => 5000, 'type' => 'Tuition Fee'],
                ['structure_id' => 2, 'amount' => 10000, 'type' => 'Admission Fee'],
                ['structure_id' => 3, 'amount' => 3000, 'type' => 'Transport Fee'],
            ];

            foreach ($feeTypes as $index => $feeType) {
                // Skip some fees for variety
                if ($i % 3 == 0 && $index > 0)
                    continue;

                // Determine payment status
                $status = ['pending', 'partial', 'paid', 'overdue'][$i % 4];
                $paidAmount = 0;
                $paidDate = null;

                if ($status == 'paid') {
                    $paidAmount = $feeType['amount'];
                    $paidDate = Carbon::now()->subDays(rand(1, 30));
                } elseif ($status == 'partial') {
                    $paidAmount = $feeType['amount'] * 0.5; // 50% paid
                    $paidDate = Carbon::now()->subDays(rand(1, 20));
                } elseif ($status == 'overdue') {
                    $paidAmount = 0;
                    $paidDate = null;
                }

                Fee::create([
                    'fee_structure_id' => $feeType['structure_id'],
                    'student_id' => $student->id,
                    'amount' => $feeType['amount'],
                    'discount' => $i % 5 == 0 ? ($feeType['amount'] * 0.1) : 0, // 10% discount for some
                    'paid_amount' => $paidAmount,
                    'due_date' => $status == 'overdue' ? Carbon::now()->subDays(rand(5, 30)) : Carbon::now()->addDays(30),
                    'paid_date' => $paidDate,
                    'status' => $status,
                    'fee_type' => $feeType['type'],
                    'payment_method' => $paidAmount > 0 ? ['cash', 'bank', 'online'][$i % 3] : null,
                    'remarks' => $status == 'overdue' ? 'Payment overdue' : null,
                ]);
            }
        }

        // Get all courses
        $allCourses = Course::all();

        // Assign courses to classes and create timetables
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $timeSlots = [
            ['start' => '08:00:00', 'end' => '09:00:00'],
            ['start' => '09:00:00', 'end' => '10:00:00'],
            ['start' => '10:00:00', 'end' => '11:00:00'],
            ['start' => '11:30:00', 'end' => '12:30:00'], // After break
            ['start' => '12:30:00', 'end' => '13:30:00'],
        ];

        foreach ($classes as $classIndex => $class) {
            // Assign courses to this class
            $classCourses = $allCourses->random(min(6, $allCourses->count()));

            // Attach courses to class (many-to-many relationship)
            $class->courses()->attach($classCourses->pluck('id'));

            // Create timetable entries
            $courseIndex = 0;
            foreach ($days as $day) {
                foreach ($timeSlots as $slotIndex => $slot) {
                    // Pick a course for this slot
                    $course = $classCourses[$courseIndex % $classCourses->count()];

                    // Find a teacher who specializes in this subject or use class teacher
                    $teacher = $teachers->where('subject_specialization', $course->name)->first();
                    if (!$teacher) {
                        $teacher = $teachers[$classIndex % $teachers->count()];
                    }

                    Timetable::create([
                        'class_id' => $class->id,
                        'course_id' => $course->id,
                        'teacher_id' => $teacher->id,
                        'day' => $day,
                        'start_time' => $slot['start'],
                        'end_time' => $slot['end'],
                    ]);

                    $courseIndex++;

                    // Only 3-4 periods per day
                    if ($slotIndex >= 3)
                        break;
                }
            }
        }

        // Create attendance records for the past 10 days
        for ($dayOffset = 10; $dayOffset >= 0; $dayOffset--) {
            $attendanceDate = Carbon::now()->subDays($dayOffset);

            // Skip weekends
            if ($attendanceDate->isWeekend())
                continue;

            foreach ($classes as $class) {
                $classStudents = $class->students;

                foreach ($classStudents as $student) {
                    // Random attendance: 80% present, 10% absent, 10% late
                    $rand = rand(1, 10);
                    $status = 'present';
                    if ($rand == 1)
                        $status = 'absent';
                    if ($rand == 2)
                        $status = 'late';

                    \App\Models\Attendance::create([
                        'student_id' => $student->id,
                        'class_id' => $class->id,
                        'date' => $attendanceDate,
                        'status' => $status,
                        'remarks' => $status == 'absent' ? 'Absent' : null,
                    ]);
                }
            }
        }

        $this->command->info('Pakistani student data seeded successfully!');
        $this->command->info('Added: Timetables, Attendance Records, and Fee Records');
    }
}
