<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $table = 'exams'; // Assuming the table name is 'exam'
    protected $primaryKey = 'exam_id'; // Assuming 'exam_id' is the primary key
    public $timestamps = false;

    protected $fillable = [
        'exam_title',
        'exam_desc',
        'exam_due_date',
        'exam_total_marks',
        'teacher_id',
        'course_id',
        'status',
        'time_alloted',
        'is_deleted',
        'is_graded',
    ];

}
