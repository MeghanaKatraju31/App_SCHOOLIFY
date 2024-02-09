<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recomendation extends Model
{
    use HasFactory;
    protected $table = 'recommendations'; // Specify the table name if it differs from the model name
    protected $primaryKey = 'recommendation_id'; // Specify the primary key if it's different from 'id'
    public $timestamps = false;

    protected $fillable = [
        'recommendation_title',
        'related_to',
        'recommedation_desc',
        'qa_id',
        'last_updated',
    ];
}
