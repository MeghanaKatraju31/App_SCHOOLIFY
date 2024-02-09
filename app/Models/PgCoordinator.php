<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PgCoordinator extends Model
{
    use HasFactory;
    protected $table = 'program_coordinator'; // Assuming the table name is 'program_co'
    protected $primaryKey = 'program_co_id'; // Assuming 'program_co_id' is the primary key
    public $timestamps = false;

    protected $fillable = [
        'program_co_name',
        'program_co_father_name',
        'employee_id',
        'program_co_identity_no',
        'program_co_dept',
        'program_co_email',
        'program_co_phone_no',
        'program_co_password',
        'program_co_image',
        'user_id',
    ];
}
