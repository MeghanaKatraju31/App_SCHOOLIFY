<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestionare extends Model
{
    use HasFactory;
    protected $table = 'exam_questionnaire'; // Specify the table name if it differs from the model name
    protected $primaryKey = 'quest_id'; // Specify the primary key if it's different from 'id'
    public $timestamps = false;

    protected $fillable = [
        'question',
        'option_1',
        'option_2',
        'correct_option',
        'exam_id',
    ];
}
