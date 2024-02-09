<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QaOfficer extends Model
{
    use HasFactory;
    protected $table = 'qa_officer'; // Assuming the table name is 'qa'
    protected $primaryKey = 'qa_id'; // Assuming 'qa_id' is the primary key
    public $timestamps = false;

    protected $fillable = [
        'qa_name',
        'qa_father_name',
        'employee_id',
        'qa_identity_no',
        'qa_dept',
        'qa_email',
        'qa_phone_no',
        'qa_password',
        'qa_image',
        'user_id'
    ];
}
