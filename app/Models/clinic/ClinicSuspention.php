<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\clinic\ClinicRegistrationModel;

class ClinicSuspention extends Model
{
    use HasFactory;

    protected $table = 'clinic_suspention_applications';

    protected $fillable = [
        'clinic_id',
        'registration_no',
        'applicationno',
        'userid',
        'clinic_name',
        'clinic_type',
        'address',
        'pincode',
        'state',
        'district',
        'appstatus',
        'application_date',
        'suspention_date',
        'suspention_reason',
        'suspention_description',
        'authorized_signatory',
        'status',
        'approved_reject_ip',
        'approved_reject_id',
        'created_by',
        'updated_at',
        'created_at'
    ];

    public function clinic()
    {
        return $this->belongsTo(ClinicRegistrationModel::class, 'clinic_id', 'clinic_id');
    }
}