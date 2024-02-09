<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses'; // Assuming the table name is 'courses'
    protected $primaryKey = 'course_id'; // Assuming 'course_id' is the primary key
    public $timestamps = false;

    protected $fillable = [
        'course_title',
        'course_desc',
        'credit_hours',
        'class_duration',
        'class_per_week',
        'course_image',
        'teacher_id',
    ];


}
