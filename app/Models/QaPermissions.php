<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QaPermissions extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'qa_permissions'; // Assuming the table name is 'ins_activity'

    protected $fillable = [
        'qa_id',
        'permission_id',
    ];
}
