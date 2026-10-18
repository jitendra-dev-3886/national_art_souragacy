<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class servicesTable extends Model
{
    use HasFactory;

    // Specify the correct table name
    protected $table = 'services_table';

    // Fillable fields for mass assignment
    protected $fillable = [
        'service_name', 'service_description','is_active'
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