<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCourse extends Model
{
    use HasFactory;
    protected $table = 'student_courses'; // Assuming the table name is 'student_courses'
    protected $primaryKey = 'student_courses_id'; // Assuming 'student_courses_id' is the primary key

    protected $fillable = [
        'semester_no',
        'std_id',
        'course_id',
    ];

    // Assuming there are timestamps (created_at, updated_at) in the table
    public $timestamps = false;
}
