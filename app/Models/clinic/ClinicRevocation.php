<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\clinic\ClinicRegistrationModel;

class ClinicRevocation extends Model
{
    use HasFactory;

    protected $table = 'clinic_revocation_applications';

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
        'revocation_date',
        'revocation_reason',
        'revocation_description',
        'authorized_signatory',
        'declaration',
        'designation',
        'contact_no',
        'auth_date',
        'sus_application_id',
        'status',
        'created_at',
        'updated_at',
    ];

    public function clinic()
    {
        return $this->belongsTo(ClinicRegistrationModel::class, 'clinic_id', 'clinic_id');
    }
}