<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Model;
use App\Models\clinic\SurrogacyClinicApplicationNo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankModel extends Model
{
    use HasFactory;
      // Define the table name if it's different from the plural of the model name
      protected $table = 'artbank';
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
        'otherstaff', 
        'equipment',
        'ejaculation', 
        'electroejaculation', 
        'processingsperm', 
        'storagesperm', 
        'oocytedonor', 
        'spermandoocyte', 
        'cryopreservation', 
        'spermslow', 
        'spermvitrification', 
        'tisticulartissue',
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
    public function bapp_no()
    {
        return $this->belongsTo(BankApplicationNo::class, 'id', 'bank_id');
    }  
    public function signup()
    {
        return $this->belongsTo(signup::class, 'userid', 'id');
    }

    public function certificate()
    {
        return $this->hasOne(BankCertificateDetails::class, 'userid', 'userid');
    }
    public function otherStaff()
    {
        return $this->hasMany(BankOtherStaffModel::class, 'artbank_id', 'id');
    }

    public function eq()
    {
        return $this->hasMany(BankEquipmentModel::class, 'artbank_id', 'id');
    }
    
}
