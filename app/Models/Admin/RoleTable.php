<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleTable extends Model
{
    use HasFactory;

    // Specify the correct table name
    protected $table = 'role_table';

    // Fillable fields for mass assignment
    protected $fillable = [
        'role_name', 'description', 'created_by', 
        'deactivated_by','is_active'
    ];

    // Optional: You might want to hide sensitive fields like password in the API response
    // protected $hidden = [
    //     'password',
    // ];

    // Optional: If you want to cast the "Is_Active_and_Deactive" column to a boolean
    // protected $casts = [
    //     'is_active' => 'boolean',
    // ];
}