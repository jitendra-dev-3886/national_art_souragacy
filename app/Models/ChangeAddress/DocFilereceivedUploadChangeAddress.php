<?php

namespace App\Models\ChangeAddress;

use App\Models\clinic\signup;
use App\Models\Noc\docmastertable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocFilereceivedUploadChangeAddress extends Model
{
    use HasFactory;
    // protected $connection = 'patient_clinic_database';
    protected $table = 'change_address_doc_file_uploads_receiving_applications';
    protected $fillable = [
        'userid',
        'clinic_id',
        'doc_id',
        'app_id',
        'application_type',
        'clinic_type',
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
   
}
