<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\clinic\ClinicRegistrationModel;

class ClinicSuspension extends Model
{
    use HasFactory;

    protected $table = 'clinic_suspension_applications';

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
        'suspension_date',
        'suspension_reason',
        'suspension_description',
        'authorized_signatory',
        'status',
        'suspension_from_date',
        'suspension_to_date',
        'suspension_order_document',
        'suspension_cancellation',
        'created_by',
        'updated_at',
        'created_at'
    ];

    public function clinic()
    {
        return $this->belongsTo(ClinicRegistrationModel::class, 'clinic_id', 'clinic_id');
    }
}