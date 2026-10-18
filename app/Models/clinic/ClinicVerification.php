<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ClinicVerification extends Model
{
    use HasFactory;
    protected $table = 'clinic_verifications'; // specify the table name
    protected $primaryKey = 'id'; // primary key, default is 'id'
    public $timestamps = true; // set to false if no created_at/updated_at columns
    // Columns that are mass assignable
    protected $fillable = [
        'request_id',
        'application_no',
        'registration_no',

        // Clinic verification inputs
        'old_email',
        'verify_new_email',   
        'old_phone',
        'verify_new_phone',

        // Reason and notes
        'reason_for_change',
        'remarks',

        // Verification Outcome
        'verified_status',    // pending, verified, rejected, failed
        'verified_at',
        'verified_by',        // future: clinic user id if login exists
        
        // Security / Logging
        'ip_address',
		'created_at',
		'updated_at'

    ];
}