<?php

namespace App\Models\Renewal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RenewalSCStaff extends Model
{
    use HasFactory;

    protected $table = 'renewal_sc_staff';
    protected $primaryKey = 'id';

    protected $fillable = [
        'clinic_id',
        'application_id',
        'name',
        'post',
        'qualification',
        'application_no',
        'regno',
        'status',
        'userid',
        'clinic_type',
        'type_emp',
        'validitydate',
    ];

    // protected $dates = [
    //     'created_at',
    //     'updated_at',
    //     'validitydate',
    // ];
}
