<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Model;
use App\Models\clinic\SurrogacyClinicApplicationNo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SurrogacyClinicModel extends Model
{
    use HasFactory;
      // Define the table name if it's different from the plural of the model name
      protected $table = 'surrogacyclinic';
      //public $timestamps = false;
      protected $primaryKey = 'id'; // Default is 'id'
      public $incrementing = true; // Ensure auto-increment is enabled

      // Specify the fillable attributes (optional for mass assignments)
      protected $fillable = [ 
        'clinicname',
        'address',
        'pincode',
        'state',
        'district',
        'nature',
        'email',
        'contactno',
        'contact_person_name',
        'contact_person_mobile',
        'contact_person_email',
        'fax',
        'website', 
        'dateestab', 
        'mtpact', 
        'pcpndtact', 
        'director', 
        'otherstaff', 
        'equipment',
        'iuih', 
        'iuid', 
        'ivfet', 
        'icsi', 
        'pgt', 
        'spermandoocyte', 
        'anyotherprocedure', 
        'otherprocedure', 
        'otherdetails', 
        'status', 
        'userid', 
        'appstatus',
		'archive_status',		
        'app_received', 
        'app_date_recieve', 
        'app_date_payment',
        'mode_payment',
        'transaction_id',
        'fee_amount',
        'receipt_pdf',
        'comment', 
        'datetime_decision',
        'applicationno',
        'applicationno_datetime_submission',
        'incomplete_withdrawal_cancelled',
        'physical_application',
        'reason_for_rejection'
    ];
    public function sapp_no()
    {
        return $this->belongsTo(SurrogacyClinicApplicationNo::class, 'id', 'surrogacy_id');
    }  
    public function signup()
    {
        return $this->belongsTo(signup::class, 'userid', 'id');
    }

    public function certificate()
    {
        return $this->hasOne(SurrogacyClinicCertificateDetails::class, 'userid', 'userid');
    }

    
}
