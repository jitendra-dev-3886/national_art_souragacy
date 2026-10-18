<?php

namespace App\Models\patient;

use App\Models\clinic\signup;
use Illuminate\Database\Eloquent\Model;
use App\Models\clinic\ClinicApplicationNo;
use App\Models\clinic\SurrogacyClinicApplicationNo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SummaryPatientArtLevelOneClinic extends Model
{
    use HasFactory;
    protected $connection = 'patient_clinic_database'; // Connects to the 'noc_registry' database
    protected $table = 'summary_patient_artclinic_levelone';
    protected $primaryKey = 'id';
    public $timestamps = true;
    
    protected $fillable = [        
        'clinic_level1_reg_num',
        'name_of_clinic',
        'year',
        'clinic_id',
        'quarter',   
        'no_patient_IUI_onoing',
        'no_married_couples',             
        'no_ongoing_self_gametes',
        'no_ongoing_donor_semen',
        'no_ongoing_single_woman',
        'no_patient_IUI_completed',
        'no_married_couple', 
        'no_completed_self_gametes',
        'no_completed_donor_semen',
        'no_completed_single_woman',  
        'date_of_submission',           
        'userid',  
        'ip'
    ];  
    public function Signupid()
    {
        return $this->belongsTo(signup::class, 'userid','id');
    }
    
    public function ClinicAppNo()
    {
        return $this->belongsTo(ClinicApplicationNo::class, 'clinic_reg_id','id');
    }
    public function quarterdesc()
    {
        return $this->belongsTo(QuarterTable::class, 'quarter', 'quarter');
    }
    
}
