<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QaOfficerActivity extends Model
{
    use HasFactory;
    protected $table = 'qa_activities'; // Assuming the table name is 'qa_activity'
    protected $primaryKey = 'qa_activity_id'; // Assuming 'qa_activity_id' is the primary key
    public $timestamps = false;

    protected $fillable = [
        'qa_activity',
        'qa_id',
        'time_stamp',
    ];
}
