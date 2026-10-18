<?php

namespace App\Models\patient;

use App\Models\clinic\signup;
use Illuminate\Database\Eloquent\Model;
use App\Models\clinic\SurrogacyClinicApplicationNo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SummaryPatientSurrogacyClinic extends Model
{
    use HasFactory;
    protected $connection = 'patient_clinic_database'; // Connects to the 'noc_registry' database
    protected $table = 'summary_patient_surrogacyclinic';
    protected $primaryKey = 'id';
    public $timestamps = true;
    
    protected $fillable = [        
        'cli_reg_name',
        'name_of_clinic',
        'quarter',
        'year',
        'clinic_id',
        'no_patient_undergoing_procedure',

        'no_indian_nationals',
        'no_foreign_nationals',

        'no_patient_surrogacy_ongoing',
        'no_married_couples',
        
        'no_ongoing_self_gametes',
        'no_ongoing_oocytes_donor_semen',
        'no_ongoing_semen_donor_oocytes',
        'no_ongoing_single_woman',

        'no_patient_surrogacy_completed',
        'no_married_couple',

        'no_completed_self_gametes',
        'no_completed_oocytes_donor_semen',
        'no_completed_semen_donor_oocytes',
        'no_completed_single_woman',

        'no_surrogate_mothers',

        'no_surrogate_mother_ongoing',
        'no_surrogate_mother_completed',
        'no_surgical_retrival_done',

        'no_oocyte_retrievals',

        'no_oocyte_donor',
        'no_self_oocyte_patient',
        'no_patient_semen_cryopreserved',
        'no_patient_oocyte_cryopreserved',
        
        'no_created_using_self_gametes',
        'no_donor_sperm',
        'no_donor_oocyte',


        'no_created_using_one_donor_gamete',
        'no_created_using_both_donor_gamete',
        'no_donor_sperm_cryopreserved',
        'no_donor_oocyte_cryopreserved',
        'no_embryos_cryopreserved',        
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
        return $this->belongsTo(SurrogacyClinicApplicationNo::class, 'surrogacy_reg_id','id');
    }
    public function quarterdesc()
    {
        return $this->belongsTo(QuarterTable::class, 'quarter', 'quarter');
    }
}
