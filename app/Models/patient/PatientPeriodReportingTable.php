<?php

namespace App\Models\patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientPeriodReportingTable extends Model
{
    use HasFactory;
    protected $connection = 'patient_clinic_database'; // Connects to the 'noc_registry' database
    protected $table = 'patient_period_reporting_table';
    protected $primaryKey = 'id';
    public $timestamps = true;
    
    protected $fillable = [ 
        'clinic_id',
        'type_clinic',      
        'quarter',
        'year',
        'userid',
        'clinic_reg_id',
        'status',
        'is_nilldata',
        'final_submit_date',
        'ip_address',
        'clinic_reg_id'
    ];  
    public function quarter()
    {
        return $this->belongsTo(QuarterTable::class, 'quarter', 'id');
    }
    
}
