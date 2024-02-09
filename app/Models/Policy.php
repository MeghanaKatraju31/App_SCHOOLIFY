<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'policies'; // Specify the table name if it differs from the model name
    protected $primaryKey = 'policy_id'; // Specify the primary key if it's different from 'id'

    protected $fillable = [
        'policy_title',
        'policy_type',
        'policy_desc',
        'qa_id',
        'last_updated',
    ];

}
