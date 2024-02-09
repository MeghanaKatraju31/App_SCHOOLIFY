<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'inquiry';
    public $timestamps = false;


    protected $fillable = ['inq_id','inq_sender_name',	'inq_sender_query',	'sender_email'];

}
