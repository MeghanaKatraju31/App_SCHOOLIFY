<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentActivity extends Model
{
    use HasFactory;
    protected $table = 'student_activities'; // Assuming the table name is 'std_activity'
    protected $primaryKey = 'std_activity_id'; // Assuming 'std_activity_id' is the primary key
    public $timestamps = false;

    protected $fillable = [
        'std_activity',
        'std_id',
        'time_stamp',
    ];
}
