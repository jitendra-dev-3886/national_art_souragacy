<?php

namespace App\Models\patient;

use App\Models\clinic\BankApplicationNo;
use App\Models\clinic\signup;
use Illuminate\Database\Eloquent\Model;
use App\Models\clinic\SurrogacyClinicApplicationNo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SummaryPatientBankClinic extends Model
{
    use HasFactory;
    protected $connection = 'patient_clinic_database'; // Connects to the 'noc_registry' database
    protected $table = 'summary_patient_bank';
    protected $primaryKey = 'id';
    public $timestamps = true;
    
    protected $fillable = [  
        'userid',
        'clinic_id',      
        'bank_reg_num',
        'name_of_bank',
        'quarter',
        'year',
        'clinic_id',
        'no_oocyte_donors_screened',
        'no_oocyte_cryo',
        'no_donor_oocyte',
        'no_donor_surro',
        'no_semen_donors_screened',
        'no_donor_semen_cryo',
        'no_patient_semen_cryo',
        'no_patient_oocytes_supplied_surrogacy',
        'total_semen_donor',
        'total_semen_sample_store',
        'donor_semen_sample_store',
        'patient_semen_sample_store',
        'total_semen_sample_supplied',
        'no_donor_semen_art',
        'no_donor_semen_surrogacy',
        'no_patient_semen_artclinic',
        // 'no_patient_own_semen_sclinic', 
        'no_patient_semen_supplied_surrogacy',
        'date_of_submission', 
        'total_oocyte_stored',   
        'total_oocyte_stored',
        'userid',
        'status',
        'ip'
    ];  
    public function Signupid()
    {
        return $this->belongsTo(signup::class, 'userid','id');
    }
    
    public function ClinicAppNo()
    {
        return $this->belongsTo(BankApplicationNo::class, 'bank_reg_id','id');
    }
    public function quarterdesc()
    {
        return $this->belongsTo(QuarterTable::class, 'quarter', 'quarter');
    }
}
