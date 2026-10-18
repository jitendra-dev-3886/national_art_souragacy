<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtClinicCertificateDetails extends Model
{
    use HasFactory;
    protected $table = 'artclinic_certificate_details';
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
    
    public function clinic_regi_no()
    {
        return $this->belongsTo(signup::class, 'id','userid');
    }
    public function clinic()
    {
        return $this->belongsTo(ArtClinicModel::class, 'userid', 'userid');
    }
}
