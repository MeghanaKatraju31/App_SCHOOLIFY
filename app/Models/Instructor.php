<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'instructor'; // Assuming the table name is 'instructors'
    protected $primaryKey = 'instructor_id'; // Assuming 'instructor_id' is the primary key

    protected $fillable = [
        'instructor_name',
        'instructor_father_name',
        'employee_id',
        'instructor_identity_no',
        'instructor_dept',
        'instructor_program',
        'instructor_designation',
        'instructor_email',
        'instructor_phone_no',
        'instructor_password',
        'ins_image',
        'user_id',
    ];
}
