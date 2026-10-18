<?php

namespace App\Models\patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientPeriodReportingSnapshot extends Model
{
    use HasFactory;
    protected $connection = 'patient_clinic_database'; // Connects to the 'noc_registry' database
    protected $table = 'patient_period_reporting_snapshot';
    protected $primaryKey = 'id';
    public $timestamps = true;
    
    protected $fillable = [ 
        'reporting_id',
        'clinic_id',      
        'type_clinic',
        'quarter',
        'year',
        'userid',
        'previous_status',
        'previous_is_nilldata',
        'previous_final_submit_date',
        'previous_ip_address',
        'original_created_at',
        'original_updated_at',
        'revised_userid',
        'revision_reason',
        'revised_ip',
        
    ];  
    public function quarter()
    {
        return $this->belongsTo(QuarterTable::class, 'quarter', 'id');
    }
    
}
