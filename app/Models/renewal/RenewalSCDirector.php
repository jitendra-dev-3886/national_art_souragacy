<?php

namespace App\Models\Renewal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RenewalSCDirector extends Model
{
    use HasFactory;

    protected $table = 'renewal_sc_director';
    protected $primaryKey = 'id';

    protected $fillable = [
        'application_id',
        'clinic_id',
        'name_director',
        'quali_director',
        'reg_director',
        'userid',
        'status',
        'clinic_type',
        'application_no',
        'validitydate',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'validitydate',
    ];
}
