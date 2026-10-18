<?php

namespace App\Models;

use App\Models\clinic\signup;
use App\Models\Noc\docmastertable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\clinic\SurrogacyClinicCertificateDetails;

class DocFilereceivedUpload extends Model
{
    use HasFactory;
   // protected $connection = 'patient_clinic_database';
    protected $table = 'doc_file_uploads_receiving_application';
    protected $fillable = [
        'userid',
        'app_id',
        'clinic_id',
        'doc_id',
        'doc_type',
        'doc_upload_ref',
        
    ];
    
    public function docFile_Uploads()
    {
        return $this->hasMany(docmastertable::class);
    }
    public function signup_userid()
    {
        return $this->belongsTo(signup::class, 'userid', 'id');
    }
    public function app_id()
    {
        return $this->belongsTo(SurrogacyClinicCertificateDetails::class, 'app_id', 'id');
    }
}
