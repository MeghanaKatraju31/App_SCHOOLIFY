<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'curriculum'; // Assuming the table name is 'ins_activity'
    protected $primaryKey = 'cr_id'; // Assuming 'program_co_id' is the primary key

    protected $fillable = [
        'cr_title',
        'cr_description',
        'pc_id'
    ];
}
