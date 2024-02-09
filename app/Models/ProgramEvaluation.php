<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramEvaluation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'program_evaluation'; // Assuming the table name is 'ins_activity'
    protected $primaryKey = 'evaluation_id'; // Assuming 'program_co_id' is the primary key

    protected $fillable = [
        'question',
        'option',
        'pc_id'
    ];
}
