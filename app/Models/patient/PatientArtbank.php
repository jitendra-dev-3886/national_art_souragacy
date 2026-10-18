<?php

namespace App\Models\patient;

use App\Models\clinic\signup;
use Illuminate\Database\Eloquent\Model;
use App\Models\clinic\BankApplicationNo;
use App\Models\patient\PatientPeriodReportingTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientArtbank extends Model
{
    use HasFactory;
    protected $connection = 'patient_clinic_database'; // Connects to the 'noc_registry' database
    protected $table = 'patient_artbank';
    protected $primaryKey = 'id';
    public $timestamps = true;
    
    protected $fillable = [
        'previous_treatment',
        'quarter',
        'year',
        'clinic_id',
        'bank_reg_num',
        'name_of_bank',
        'donor_id',
        'declaration',
        'declaration1',
        'gender_donor',
        'donor_age',
        'oocyte_age',
        'marital_status',
        'nationality',
        'other_nationality',
        'gamete_details',
        'no_oocyte_semen_stored',
        'complicatoins_if_any',
        'remark',
        'status',
        'userid',
        'reporting_id',
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
    public function reporting(){
        return $this->belongsTo(PatientPeriodReportingTable::class, 'reporting_id','id');
    }


}
