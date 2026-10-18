<?php

namespace App\Models\ChangeManpower;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\clinic\ClinicRegistrationModel;

class ChangeManpowerApplication extends Model
{
    use HasFactory;

    protected $table = 'change_manpower_application';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'clinic_id',
        'clinic_type',
        'registration_no',
        'application_no',
        'clinicname',
        'email',
        'mobile',
        'current_registration_date',
        'address',
        'pincode',
        'state',
        'district',
        'nature',
        'level',
        'userid_applicant',
        'clinic_director',
        'name_signatory',
        'declaration_designation',
        'declaration_contact',
        'declaration_date',
        'status',
        'app_status',
        'date_of_submisstion',
        'date_app_received_ssa',
        'remark',
        'reject_order_no',
        'director_checked',
    ];

    public function clinic()
    {
        return $this->belongsTo(ClinicRegistrationModel::class, 'clinic_id', 'clinic_id');
    }
}
