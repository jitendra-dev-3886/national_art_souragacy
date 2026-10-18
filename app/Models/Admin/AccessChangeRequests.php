<?php

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessChangeRequests extends Model
{
    use HasFactory;
    protected $table ="accesschangerequests";
    protected $fillable = [
		'request_id',
        'application_no',
        'registration_no',
        'registration_date',
        'clinic_name',
        'address',
        'state',
        'district',
        'clinic_type',
        'clinic_level',
        'contact_person_name',
        'contact_mobile',
        'clinic_phone',
        'old_clinic_email',
        'hold_status',
        'revoked_at',
        'revoked_by',
        'stop_confirmed_at',
        'new_clinic_email',
        'email_sent',
        'new_clinic_mobile',
        'change_reason',
        'request_letter_path',
		// Authority Person Details
        'authorized_person_name',
        'authorized_person_designation',
        'authorized_person_mobile',
        'authorized_person_email',
		// Audit / Processing
		'created_by',	 // authority_id
		'created_at',
		'updated_by',
		'updated_at',	
		'status',
		'token',
		'is_active'
    ];
}