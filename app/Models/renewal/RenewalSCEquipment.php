<?php

namespace App\Models\renewal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RenewalSCEquipment extends Model
{
    use HasFactory;

    protected $table = 'renewal_sc_equipment';
    protected $primaryKey = 'id';

    protected $fillable = [
        'application_id',
        'clinic_id',
        'equipmentname',
        'status',
        'userid',
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
