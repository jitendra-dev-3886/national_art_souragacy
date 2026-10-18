<?php

namespace App\Models\patient;

use App\Models\clinic\signup;
use Illuminate\Database\Eloquent\Model;
use App\Models\clinic\SurrogacyClinicApplicationNo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientSurrogacyClinic extends Model
{
    use HasFactory;
    protected $connection = 'patient_clinic_database'; // Connects to the 'noc_registry' database
    protected $table = 'patient_surrogacyclinic';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id',
        'previous_treatment',
        'quarter',
        'year',
        'clinic_id',
        'cli_reg_name',
        'name_of_clinic',
        'pati_uhid',
        'case_of',
        'declaration',
        'declaration1',
        'declaration3',
        'declaration4',
        'nationality',
        'other_nationality',
        'nationality_wife',
        'other_nationality_wife',
        'age',
        'wife_age',
        'age_of_women',
        'num_pre_child',
        'child_give_details',
        'types_of_treat',
        'types_of_treat1',
        'medical_surrogacy',
        'male_factor',
        'uterus_ab',
        'ivf_failure',
        'preg_loss',
        'life_threat',
        'medical_certificate',
        'child_medical_certificate',
        'surrogate_mother_age',
        'art_undertaken',
        'art_undertaken_other',
        'total_nun_cycles',
        'no_cycles',
        'Cycle_fail_reason',
        'tratment_Outcome',
        'preganancy_outcome',
        'l_birth',
        // 'gender_child',
        'other_gender',
        'male_number',
        'female_number',
        'comp_if_any',
        'remark',
        'status',
        'userid',
        'reporting_id',
        'part2_referenceno',
        'part2_reportingid',
        'part2_submissiondate',
        'ip',
        'treatment_type',
        'art_case_of',
        'art_nationality',
        'art_other_nationality',
        'art_nationality_wife',
        'art_other_nationality_wife',
        'art_age_hus_wife',
        'art_wife_age',
        'art_age_of_women',
        'art_male_factor',
        'art_female_factor',
        'art_unexplained',
        'art_cause_of_infretily',
        'art_proc_undertaken',
        'art_undertaken_other_2',
        'art_types_of_treat',
        'art_types_of_treat1',
        'art_total_num_of_cyc',
        'art_no_cycles',
        'art_cyc_canc_failure_reason',
        'art_treat_outcomes',
        'art_complicatoins_if_any',
        'art_remark',
        'art_declaration1',
        'art_declaration',

    ];
    
    public function Signupid()
    {
        return $this->belongsTo(signup::class, 'userid', 'id');
    }

    public function ClinicAppNo()
    {
        return $this->belongsTo(SurrogacyClinicApplicationNo::class, 'surrogacy_reg_id', 'id');
    }

    public function documents()
    {
        return $this->hasMany(\App\Models\DocFilePatientUpload::class, 'app_id', 'id');
            // ->where('userid', $this->userid);
    }
    public function reporting(){
        return $this->belongsTo(PatientPeriodReportingTable::class, 'reporting_id','id');
    }
}
