<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\clinic\ClinicRegistrationModel;

class ClinicWithdrawal extends Model
{
    use HasFactory;

    protected $table = 'clinic_withdrawal_applications';

    protected $fillable = [
        'clinic_id',
        'registration_no',
        'applicationno',
        'userid',
        'clinic_name',
        'clinic_type',
        'app_received_date',
        'address',
        'pincode',
        'state',
        'district',
        'appstatus',
        'application_date',
        'withdrawal_date',
        'withdrawal_reason',
        'withdrawal_description',
        'authorized_signatory',
        'declaration',
        'designation',
        'contact_no',
        'declaration_date',
        'status',
        'created_by',
        'cancel_remarks',
        'applied_by_ip',
        'approved_reject_by_ip',
        'approved_reject_by_id',
        'applied_by_id',
        'updated_by'
    ];

    public function withdrawalDocuments()
    {
        return $this->hasMany(ClinicWithdrawalDocument::class, 'withdrawal_application_id');
    }

    public function clinic()
    {
        return $this->belongsTo(ClinicRegistrationModel::class, 'clinic_id', 'clinic_id');
    }
}