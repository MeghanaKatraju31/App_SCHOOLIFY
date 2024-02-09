<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class   StudentExam extends Model
{
    use HasFactory;
    protected $table = 'student_exam'; // Assuming the table name is 'student_exam'
    protected $primaryKey = 'std_exam_id'; // Assuming 'std_exam_id' is the primary key
    public $timestamps = false;

    protected $fillable = [
        'std_id',
        'exam_id',
        'submitted_date',
        'marks_obtained',
        'remarks',
        'reason',
        'is_graded',
    ];

}
