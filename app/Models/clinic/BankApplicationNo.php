<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankApplicationNo extends Model
{
    use HasFactory;
   // protected $connection = 'mysql';
    protected $table = 'bank_applicationno';
    //public $timestamps = false;
    protected $primaryKey = 'id'; // Default is 'id'
    public $incrementing = true; // Ensure auto-increment is enabled
    public $timestamps = false;
   
    protected $fillable = [ 
      'id',
      'applicationno',    
      'bank_id ',
      'datetime_submission',
     

  ];
  public function artbank_id()
    {
        return $this->belongsTo(BankCertificateDetails::class, 'applicationno', 'application_no');
    }  
}
