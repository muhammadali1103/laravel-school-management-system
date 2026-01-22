<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'credits',
    ];

    /**
     * Get the classes that have this course
     */
    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'class_course', 'course_id', 'class_id')->withPivot('teacher_id')->withTimestamps();
    }

    /**
     * Get the timetable entries for this course
     */
    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }
    /**
     * Get the teachers for this course
     */
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'course_teacher', 'course_id', 'teacher_id')->withTimestamps();
    }
}
