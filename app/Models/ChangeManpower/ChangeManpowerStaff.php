<?php

namespace App\Models\ChangeManpower;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChangeManpowerStaff extends Model
{
    use HasFactory;

    protected $table = 'ch_manpower_staff';
    protected $primaryKey = 'id';

    protected $fillable = [
        'clinic_id',
        'cm_id',
        'application_no',
        'post',
        'anyotherpost',
        'name',
        'qualification',
        'anyotherdegree',
        'regno',
        'expiry_date',
        'status',
        'clinic_type',
        'type',
    ];
}
