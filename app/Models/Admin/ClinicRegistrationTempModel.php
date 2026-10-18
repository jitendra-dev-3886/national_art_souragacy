<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


// Create by Wasim Gour
class ClinicRegistrationTempModel extends Model
{
    use HasFactory;
    protected $table = 'clinic_registration_temp2';
    protected $primaryKey = 'id'; 
    public $incrementing = true; 
    public $timestamps = false;

  
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
        'nature',
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
        'state_authority_id',
        'verify_certificate',
        'created_date',
        'update_date',
        'validitydate',
        'ip_address',
        'otherprocedure',
        'contact_person_name',
        'contact_person_email'
    ];
}
