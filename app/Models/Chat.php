<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $table = 'chat'; // Assuming the table name is 'exam'
    protected $primaryKey = 'chat_id'; // Assuming 'exam_id' is the primary key
    public $timestamps = false;

    protected $fillable = [
        'chat_from_user_id',
        'chat_to_user_id',
        'chat_from_user_role',
        'chat_to_user_role',
        'chat_message',
        'chat_date_time',
        'read_message',
    ];
}
