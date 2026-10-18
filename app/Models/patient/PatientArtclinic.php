<?php

namespace App\Models\patient;

use App\Models\clinic\signup;
use Illuminate\Database\Eloquent\Model;
use App\Models\clinic\ClinicApplicationNo;
use App\Models\patient\PatientPeriodReportingTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientArtclinic extends Model
{
    
    protected $connection = 'patient_clinic_database'; // Connects to the 'noc_registry' database
    protected $table = 'patient_artclinic';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = [
        'previous_treatment',
        'quarter',
        'year',
        'clinic_id',
        'clinic_level1_reg_num',
        'name_of_clinic',
        'patient_uhid',
        'case_of',
        'declaration',
        'declaration1',
        'nationality',
        'other_nationality',
        'nationality_wife',
        'other_nationality_wife',
        'age_hus_wife',
        'wife_age',
        'age_of_women',
        'cause_of_infretily',
        'male_factor',
        'female_factor',
        'unexplained',
        'art_proc_undertaken',
        'art_undertaken_other',
        'types_of_treat',
        'types_of_treat1',
        'gamete_source',
        'semen_source',
        'egg_source',
        'total_num_of_cyc',
        'no_cycles',
        'cyc_canc_failure_reason',
        'treat_outcomes',
        'preganancy_outcome',
        'l_birth',
        // 'gender_child',
        'other_gender',
        'male_number',
        'female_number',
        'complicatoins_if_any',
        'remark',
        'status',
        'userid',
        'reporting_id',
        'ip',
        'part2_referenceno',
        'part2_reportingid',
        'part2_submissiondate',
        'aadhar_no_sw',
        'aadhar_no_semen',
        'self_oocyte',
        'donor_oocyte',
        'no_of_oocytes_used_retrived',
        'no_of_oocyted_used_for_embryo_creation',
        'no_of_oocyte_discarded',
        'no_of_frozen_oocyte',
        'aadhar_no_hus',
        'aadhar_no_wife',
        'aadhar_no_oocyte',
        'husband_semen',
        'donor_semen',
        'no_of_semen_vials_used',
        'no_of_semen_vials_discarded',
        'no_of_semen_vials_frozen',
        'no_of_embryos_transferred',
        'no_of_embryos_discarded',
        'no_of_frozen_embryos',
        'iui',
        'ivf_et',
        'icsi_et',
        
    ];
    public function Signupid()
    {
        return $this->hasMany(signup::class, 'id','userid');
    }
    
    public function ClinicAppNo()
    {
        return $this->belongsTo(ClinicApplicationNo::class, 'clinic_id','id');
    }
    // public function patient_clinic_signup()
    // {
    //     return $this->belongsTo(PatientArtclinic::class, 'userid', 'id');
    // }
    public function reporting(){
        return $this->belongsTo(PatientPeriodReportingTable::class, 'reporting_id','id');
    }
}
