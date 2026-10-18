<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


// Create by Wasim Gour
class ClinicRegistrationModel extends Model
{
    use HasFactory;
    protected $table = 'clinic_registration';
    protected $primaryKey = 'id'; 
    public $incrementing = true; 

    protected $fillable = [
        'level',
        'clinic_id',
        'name',
        'address',
        'state',
        'district',
        'pincode',
        'mobile',
        'email',
        'contact_number_clinic',
        'fax_number',
        'apply_registration',
        'website',
        'date_of_establishment',
        'clinic_reg_mpt',
        'clinic_reg_pcpndt',
        'clinic_director',
        'iui_h_s',
        'iui_d_s',
        'ivf_et',
        'icsi',
        'pgt',
        'sperm_oocyte',
        'any_other_procedure',
        'any_other_detail',
        'ejaculation',
        'electrojaculation',
        'processing_sperm',
        'storage_sperm',
        'oocyte_doner',
        'cryopreservation_of_sperm',
        'methode_of_freezing_of_sperm',
        'sperm_vitrification',
        'freezing_of_testicular_tissue',
        'application_no',
        'registration_no',
        'certificate_valid_date',
        'certificate_path',
        'status',
        'clinic_type',
        'userid_applicant',
        'rgistration_date',
        'first_registration_date',
        'state_authority_id',
        'verify_certificate',
        'created_date',
        'update_date',
        'validitydate',
        'ip_address',
        'application_type',
    ];
    
    protected $casts = [
        'id' => 'integer',
        'level' => 'string',
        'clinic_id' => 'string',
        'name' => 'string',
        'address' => 'string',
        'state' => 'string',
        'district' => 'string',
        'pincode' => 'string',
        'mobile' => 'string',
        'email' => 'string',
        'contact_number_clinic' => 'string',
        'fax_number' => 'string',
        'apply_registration' => 'string',
        'website' => 'string',
        'date_of_establishment' => 'string',
        'clinic_reg_mpt' => 'string',
        'clinic_reg_pcpndt' => 'string',
        'clinic_director' => 'string',
        'iui_h_s' => 'string',
        'iui_d_s' => 'string',
        'ivf_et' => 'string',
        'icsi' => 'string',
        'pgt' => 'string',
        'sperm_oocyte' => 'string',
        'any_other_procedure' => 'string',
        'any_other_detail' => 'string',
        'ejaculation' => 'string',
        'electrojaculation' => 'string',
        'processing_sperm' => 'string',
        'storage_sperm' => 'string',
        'oocyte_doner' => 'string',
        'cryopreservation_of_sperm' => 'string',
        'methode_of_freezing_of_sperm' => 'string',
        'sperm_vitrification' => 'string',
        'freezing_of_testicular_tissue' => 'string',
        'application_no' => 'string',
        'registration_no' => 'string',
        'certificate_valid_date' => 'string',
        'certificate_path' => 'string',
        'status' => 'string',
        'clinic_type' => 'string',
        'userid_applicant' => 'string',
        'rgistration_date' => 'string',
        'first_registration_date' => 'string',
        'state_authority_id' => 'string',
        'verify_certificate' => 'string',
        'created_date' => 'string',
        'update_date' => 'string',
        'validitydate' => 'datetime',
        'ip_address' => 'string',
    ];

    public function clinic_reg_no()
    {
        return $this->belongsTo(ArtClinicCertificateDetails::class, 'id','userid');
    }
    public function establishment()
    {
        return $this->hasOne(\App\Models\Admin\ClinicEstbTempModel::class, 'clinic_id', 'clinic_id');
    }
    public function suspension_application()
    {
        return $this->hasOne(ClinicSuspension::class, 'clinic_id', 'clinic_id');
    }
}
