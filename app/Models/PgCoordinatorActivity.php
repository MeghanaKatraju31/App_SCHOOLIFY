<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PgCoordinatorActivity extends Model
{
    use HasFactory;
    protected $table = 'programco_activities'; // Assuming the table name is 'pc_activity'
    protected $primaryKey = 'pc_activity_id'; // Assuming 'pc_activity_id' is the primary key
    public $timestamps = false;

    protected $fillable = [
        'pc_activity',
        'pc_id',
        'time_stamp',
    ];
}
