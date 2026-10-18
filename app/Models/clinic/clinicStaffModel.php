<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clinicStaffModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_clinic_staff'; // specify the table name
    protected $primaryKey = 'id'; // primary key, default is 'id'
    public $timestamps = true; // set to false if no created_at/updated_at columns

    // Columns that are mass assignable
    protected $fillable = [
        'clinic_id',
        'name',
        'post',
        'qualification',
        'application_no',
        'regno',
        'status',
        'clinic_type',
        'type_emp',
        'validitydate',
        'relieving_date',
    ];
}
