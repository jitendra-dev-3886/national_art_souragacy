<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicApplicationNo extends Model
{
    use HasFactory;
    protected $table = 'clinic_applicationno';
    //public $timestamps = false;
    protected $primaryKey = 'id'; // Default is 'id'
    public $incrementing = true; // Ensure auto-increment is enabled
    public $timestamps = false;
   
    protected $fillable = [ 
      'id',
      'applicationno',    
      'clinic_id ',
      'datetime_submission',
     

  ];
  public function artclinic_id()
    {
        return $this->belongsTo(ArtClinicCertificateDetails::class, 'applicationno', 'application_no');
    }  
    // public function artclinic_regid()
    // {
    //     return $this->belongsTo(ClinicApplicationNo::class, 'id', 'clinic_id');
    // } 
    
}
