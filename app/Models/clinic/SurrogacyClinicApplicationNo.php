<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurrogacyClinicApplicationNo extends Model
{
    use HasFactory;
    protected $table = 's_applicationno';
    //public $timestamps = false;
    protected $primaryKey = 'id'; // Default is 'id'
    public $incrementing = true; // Ensure auto-increment is enabled
    public $timestamps = false;
   
    protected $fillable = [ 
      'id',
      'applicationno',    
      'surrogacy_id ',
      'datetime_submission',
     

  ];
  public function surrogacyclinic_id()
    {
        return $this->belongsTo(SurrogacyClinicCertificateDetails::class, 'applicationno', 'application_no');
    }  
}
