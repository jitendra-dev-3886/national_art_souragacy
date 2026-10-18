<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtClinicModel extends Model
{
    use HasFactory;
      // Define the table name if it's different from the plural of the model name
      protected $table = 'artclinic';
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
        'cliniclevel',
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
    public function app_no()
    {
        return $this->belongsTo(ClinicApplicationNo::class, 'id', 'clinic_id');
    }  
    public function signup()
    {
        return $this->belongsTo(signup::class, 'userid', 'id');
    }

    public function certificate()
    {
        return $this->hasOne(ArtClinicCertificateDetails::class, 'userid', 'userid');
    }

    // ArtClinicModel.php
    public function directors()
    {
        return $this->hasMany(ArtClinicDirectorModel::class, 'artclinic_id', 'id');
    }

    public function otherStaff()
    {
        return $this->hasMany(ArtClinicOtherStaffModel::class, 'artclinic_id', 'id');
    }

    public function eq()
    {
        return $this->hasMany(ArtClinicEquipmentModel::class, 'artclinic_id', 'id');
    }
    
}
