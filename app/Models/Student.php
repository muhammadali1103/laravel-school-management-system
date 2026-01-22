<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'roll_number',
        'phone',
        'address',
        'date_of_birth',
        'gender',
        'parent_name',
        'parent_phone',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the user that owns the student profile
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the classes this student belongs to
     */
    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'class_student', 'student_id', 'class_id');
    }

    /**
     * Get the attendance records for this student
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the fee records for this student
     */
    public function fees()
    {
        return $this->hasMany(Fee::class);
    }
}
