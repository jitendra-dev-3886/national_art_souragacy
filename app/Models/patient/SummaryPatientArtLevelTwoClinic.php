<?php

namespace App\Models\patient;

use App\Models\clinic\signup;
use Illuminate\Database\Eloquent\Model;
use App\Models\clinic\ClinicApplicationNo;
use App\Models\clinic\SurrogacyClinicApplicationNo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SummaryPatientArtLevelTwoClinic extends Model
{
    use HasFactory;
    protected $connection = 'patient_clinic_database'; // Connects to the 'noc_registry' database
    protected $table = 'summary_patient_artclinic_leveltwo';
    protected $primaryKey = 'id';
    public $timestamps = true;
    
    protected $fillable = [  
        'id',      
        'clinic_level1_reg_num',
        'name_of_clinic',
        'quarter',
        'year',

        'no_patient_undergoing_IVF_procedure',
        'no_married_couples',

        'no_ongoing_self_gametes',
        'no_donor_gametes',
        'no_ongoing_donor_gamete',

        'no_one_donor_sperm',
        'no_one_donor_gamete',

        'no_ongoing_donor_bothgamete',
        'no_ongoing_single_woman',

        'no_using_donor_sperm',
        'no_using_donor_gamete',

        'no_patient_undergoing_IVF_procedure_completed',
        'no_married_couple',

        'no_completed_self_gametes',
        'no_donor_gamete',
        'no_completed_donor_gamete', 
        
        'no_one_donor_sperms',
        'no_one_donor_gametes',

        'no_completed_donor_bothgamete',
        'no_completed_single_woman' ,

        'no_using_donor_sperms',
        'no_using_donor_gametes',
        'no_surgical_semen_completed',

        'no_oocyte_retrievals_done',

        'no_oocyte_donor',
        'no_self_oocyte_patient',        
        'no_created_self_gametes',
        'no_created_one_donor_gamete',

        'no_donor_sperm',
        'no_donor_oocyte',

        'no_created_both_donor_gamete',
        'no_embryos_cryopreserved',
        'no_patient_sperm_cryo',
        'no_patient_oocyte_cryo',
        'no_donor_sperm_cryo',
        'no_donor_oocyte_cryo',
        'userid',
        'clinic_reg_id',      
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
