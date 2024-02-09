<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseContent extends Model
{
    use HasFactory;
    protected $table = 'course_content'; // Assuming the table name is 'course_content'
    protected $primaryKey = 'content_id'; // Assuming 'content_id' is the primary key
    public $timestamps = false;

    protected $fillable = [
        'content_title',
        'content_description',
        'course_id',
    ];


}
