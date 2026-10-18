<?php

namespace App\Models\Noc;

use App\Models\DocFileForeignerupload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Nocforeigner extends Model
{
    use HasFactory;
    // Define the table name if it's different from the plural of the model name
    protected $table = 'noc_form_foreigners';
    protected $fillable = [
                            'application_no',
                            'gender',
                            'name_applicant',
                            'nationality_applicant',
                            'country_applicant',
                            'm_status',
                            'name_spouse',
                            'nationality_spouse',
                            'country_applicant_spouse',
                            'email_spouse',
                            'mobile_spouse',
                            'address',
                            'pincode',
                            'state',
                            'district',
                            'mobileno',
                            'email',
                            'transfer',
                            'transfer_of',
                            'embryos_number',
                            'sperm_vials',
                            'oocytes_number',
                            'purpose_of_transfer',
                            'aadhar_applicant',
                            'voterid_applicant',
                            'passport_applicant',
                            'pan_applicant',
                            'dob_applicant',
                            'aadhar_spouse',
                            'passport_spouse', 
                            'pan_spouse',
                            'dob_spouse',
                            'voterid_spouse',
                            'status_clinic',
                            'status_from_clinic',
                            'from_name_clinic',
                            'from_name_clinic1',
                            'from_name_clinic2',
                            'from_doctor',
                            'from_applicationno',
                            'from_regno',
                            'from_address',
                            'f_pincode',
                            'f_state',
                            'f_district',
                            'f_contact',
                            'f_email',
                            'to_status_clinic',
                            'to_doctor',
                            'to_status_from_clinic',
                            'to_name_clinic',
                            'to_name_clinic2',
                            'to_name_clinic1',
                            'to_applicationno',
                            'to_regno',
                            'to_address',
                            't_pincode',
                            'country',
                            't_state',
                            't_district',
                            't_contact',
                            't_email',
                            'doc_id_old',
                            'doc_type_old',
                            'dob_proof_ap',
                            'application_pdf',
                            'oci_applicant',
                            'oci_spouse',
                            'identity_proof_applicant',
                            'copy_of_identity_proof_applicant',
                            'identity_proof_applicant_spouse',
                            'copy_of_identity_proof_spouse',
                            'dob_proof_applicant',
                            'dob_proof_spouse',
                            'noc_userid',
                            'action',                
                            'level',
                            'status',
                            'zipcode',
                            'created_at',
                            'updated_at'
                          
       
                ];

    public function userRequest()
    {
        return $this->belongsTo(requesttable::class, 'noc_user_id', 'id');
    }    
    public function docFileUploads()
    {
        return $this->hasMany(DocFileForeignerUpload::class, 'app_id', 'id');
    }
 
}