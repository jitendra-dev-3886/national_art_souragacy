<?php

namespace App\Models\patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuarterTable extends Model
{
    use HasFactory;
    protected $connection = 'patient_clinic_database'; // Connects to the 'noc_registry' database
    protected $table = 'quarter_table';
    protected $primaryKey = 'id';
    public $timestamps = true;
    
    protected $fillable = [        
        'quarter',
        'description'
        
    ];
      
    public function patientReports()
    {
        return $this->hasMany(PatientPeriodReportingTable::class, 'quarter', 'quarter');
    }
    
}
