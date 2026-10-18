<?php

namespace App\Models\ChangeAddress;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\clinic\ClinicRegistrationModel;
use App\Models\ChangeAddress\ChangeAddressDirector;
use App\Models\ChangeAddress\ChangeAddressStaff;
use App\Models\ChangeAddress\ChangeAddressEquipment;

class ChangeAddressApplication extends Model
{
    use HasFactory;

    protected $table = 'change_address_applications';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'clinic_id',
        'fax',
        'website',
        'dateestab',
        'mtpact',
        'pcpndtact',
        'director',
        'otherstaff',
        'equipment',
        'iuih',
        'iuid',
        'ivfet',
        'icsi',
        'pgt',
        'spermandoocyte',
        'anyotherprocedure',
        'otherprocedure',
        'otherdetails',
        'status',
        'appstatus',
        'comment',
        'userid',
        'archive_status',
        'action_taken_by',
        'action_taken_id',
        'action_taken_approve_by',
        'type_of_clinic',
        'ip_address',
        'datetime_decision',
        'app_received',
        'app_date_recieve',
        'app_date_payment',
        'mode_payment',
        'transaction_id',
        'fee_amount',
        'receipt_pdf',
        'clinicname',
        'clinic_type',
        'address',
        'pincode',
        'state',
        'district',
        'nature',
        'email',
        'contactno',
        'contact_person_name',
        'contact_person_mobile',
        'contact_person_email',
        'applicationno',
        'registration_no',
        'application_datetime_submission',
        'application_type',
        'doc_type',
        'doc_desc',
        'doc_partial_path',
        'ip',
        'approved_rejected',
        'date_of_reg',
        'first_registration_date',
        'current_registration_date',
        'reg_valid_upto',
        'state_authority_id',
        'verify_certificate',
        'date_of_rej',
        'rejection_no',
        'fee_recieved_by',
        'fee_recieved_datetime',
        'ejaculation',
        'electrojaculation',
        'processing_sperm',
        'storage_sperm',
        'oocyte_doner',
        'cryopreservation_of_sperm',
        'methode_of_freezing_of_sperm',
        'sperm_vitrification',
        'freezing_of_testicular_tissue',
        'cliniclevel',
        'aproved_rejected',
        'final_action_taken_by',
        'final_action_takan_datetime',
        'fees_via_application_no',
        'is_resubmission'
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts (Recommended)
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'application_datetime_submission' => 'datetime',
        'app_date_payment' => 'datetime',
        'first_registration_date' => 'date',
        'current_registration_date' => 'date',
        'date_of_reg' => 'date',
        'reg_valid_upto' => 'date',
        'date_of_rej' => 'date',
        'fee_recieved_datetime' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function clinic()
    {
        return $this->belongsTo(ClinicRegistrationModel::class, 'clinic_id', 'clinic_id');
    }

    public function directors()
    {
        return $this->hasMany(ChangeAddressDirector::class, 'application_id');
    }

    public function staff()
    {
        return $this->hasMany(ChangeAddressStaff::class, 'application_id');
    }

    public function equipment()
    {
        return $this->hasMany(ChangeAddressEquipment::class, 'application_id');
    }
}