<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'admin'; // Assuming the table name is 'admin'
    protected $primaryKey = 'admin_id'; // Assuming 'admin_id' is the primary key

    protected $fillable = [
        'admin_name',
        'admin_father_name',
        'employee_id',
        'admin_identity_no',
        'admin_dept',
        'admin_email',
        'admin_phone_no',
        'admin_password',
        'admin_image',
        'activation_key',
    ];

    // Mutator to automatically hash the password when setting it
    public function setAdminPasswordAttribute($value)
    {
        $this->attributes['admin_password'] = Hash::make($value);
    }
}
