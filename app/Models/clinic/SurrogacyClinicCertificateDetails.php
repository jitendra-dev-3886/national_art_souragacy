<?php

namespace App\Models\clinic;

use App\Models\DocFileUpload;
use App\Models\DocFilePatientUpload;
use Illuminate\Database\Eloquent\Model;
use App\Models\patient\PatientArtclinic;
use App\Models\patient\PatientSurrogacyClinic;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SurrogacyClinicCertificateDetails extends Model
{
    use HasFactory;
    protected $table = 'surrogacy_certificate_details';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = [
        'application_no',
        'approved_rejected',
        'date_reg',
        'validity_upto',
        'registration_no',
        'date_rej',
        'rejection_no',
        'reg_no_file',
        'userid',
        'datetime_decision'
    ];
    
    protected $casts = [
        'datetime_decision' => 'datetime',
    ];
    
    public function surrogacy_regi_no()
    {
        return $this->belongsTo(PatientSurrogacyClinic::class, 'userid','userid');
    }

    public function upload_app_id()
    {
        return $this->belongsTo(DocFilePatientUpload::class, 'id', 'app_id');
    }
    public function clinic()
    {
        return $this->belongsTo(SurrogacyClinicModel::class, 'userid', 'userid');
    }


}
