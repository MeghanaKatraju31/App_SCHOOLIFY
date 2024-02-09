<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorPermissions extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'instructor_permissions'; // Assuming the table name is 'ins_activity'

    protected $fillable = [
        'instructor_id',
        'permission_id',
    ];
}
