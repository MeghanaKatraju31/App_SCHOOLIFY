<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'permissions'; // Assuming the table name is 'program_co'
    protected $primaryKey = 'permission_id'; // Assuming 'program_co_id' is the primary key

    protected $fillable = [
        'permission_action',
        'permission_allow',
    ];
}
