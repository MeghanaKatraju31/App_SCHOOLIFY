<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorActivity extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'instructor_activities'; // Assuming the table name is 'ins_activity'
    protected $primaryKey = 'ins_activity_id'; // Assuming 'ins_activity_id' is the primary key

    protected $fillable = [
        'ins_activity',
        'ins_id',
        'time_stamp',
    ];
}
