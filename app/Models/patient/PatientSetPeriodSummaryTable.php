<?php

namespace App\Models\patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientSetPeriodSummaryTable extends Model
{
    use HasFactory;
    protected $connection = 'patient_clinic_database'; // Connects to the 'noc_registry' database
    protected $table = 'patient_set_period_summary_table';
    protected $primaryKey = 'id';
    public $timestamps = true;
    
    protected $fillable = [ 
        'clinic_id',
        'type_clinic',      
        'quarter',
        'year',
        'userid',
        'status',
    ];  
    public function quarter()
    {
        return $this->belongsTo(QuarterTable::class, 'quarter', 'id');
    }
    
}
