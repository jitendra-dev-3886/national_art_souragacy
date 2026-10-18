<?php

namespace App\Models\clinic;

use App\Models\ApplicantProfile;
use App\Models\DocFilePatientUpload;
use App\Models\patient\PatientArtbank;
use Illuminate\Database\Eloquent\Model;
use App\Models\patient\PatientArtclinic;
use App\Models\clinic\SurrogacyClinicModel;
use App\Models\clinic\BankCertificateDetails;
use App\Models\patient\PatientSurrogacyClinic;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class signup extends Model
{
    use HasFactory;  
  //   protected $connection = 'artregistry';
    protected $table = 'signup';
    protected $fillable = [
       'id', 'clinicname', 'address', 'pincode', 'state','district','nature','email','contactno','personname','mobile','email_contact_person','password','status','token'
    ];

    public function artclinics()
    {
        return $this->belongsTo(ArtClinicModel::class,'id', 'userid');
    }

    public function surrogacyclinics()
    {
        return $this->belongsTo(SurrogacyClinicModel::class,'id', 'userid');
    }

    public function bankclinics()
    {
        return $this->belongsTo(BankModel::class,'id', 'userid');
    }

    public function state()
    {
        return $this->belongsTo(statetable::class, 'id', 'stateid');
    }

    public function clinic_reg_no()
    {
        return $this->belongsTo(ArtClinicCertificateDetails::class, 'id','userid');
    }

    public function surrogacy_reg_no()
    {
        return $this->belongsTo(SurrogacyClinicCertificateDetails::class, 'id','userid');
    }

    public function bank_reg_no()
    {
        return $this->belongsTo(BankCertificateDetails::class, 'id','userid');
    }

    public function signup_upload()
    {
        return $this->belongsTo(DocFilePatientUpload::class, 'id', 'userid');
    }

    public function patient_clinic_applications()
    {
        return $this->hasMany(PatientArtclinic::class, 'id', 'userid');
    }

    public function patient_bank_applications()
    {
        return $this->hasMany(PatientArtbank::class, 'id', 'userid');
    }

    public function patient_surrogacy_applications()
    {
        return $this->hasMany(PatientSurrogacyClinic::class, 'id', 'userid');
    }


     public function artclinicreg()
    {
        return $this->belongsTo(ClinicRegistrationModel::class,'id', 'clinic_id');
    }
    
}