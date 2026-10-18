<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicNameChangeApplication extends Model
{
    use HasFactory;

    protected $table = 'clinic_name_change_applications';

    protected $fillable = [
        'clinic_id',
        'registration_no',
        'name',
        'clinic_type',
        'nature',
        'email',
        'contact_number_clinic',
        'level',
        'rgistration_date',
        'address',
        'pincode',
        'state',
        'district',
        'proposed_clinic_name',
        'name_change_effective_date',
        'reason_for_name_change',
        'authorized_signatory_name',
        'designation',
        'contact_number',
        'declaration_accepted',
        'declaration_date',
        'status',
        'application_no',
        'userid',
        'app_date_recieve',
        'rejection_no',
        'date_rej',
        'reason_for_rejection',
        'app_rejected_by_ip',
        'app_rejected_by_id',
        'state_request_rejected_datetime'


    ];
}