<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'student';
    public $timestamps = false;
    protected $fillable = [
        'std_id',
        'std_name',
        'std_father_name',
        'std_reg_no',
        'std_identity_no',
        'std_dept',
        'std_program',
        'std_semester',
        'std_admission_year',
        'std_email',
        'std_phone_no',
        'std_password',
        'std_image',
        'activation_key',
        'user_id',
    ];
}
