<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PgPermissions extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'programco_permissions'; // Assuming the table name is 'ins_activity'

    protected $fillable = [
        'program_co_id',
        'permission_id',
    ];
}
