<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprehensiveReportFirstAnnexure extends Model
{
   
    use HasFactory;
        public $timestamps = true; 
    protected $table = 'comprehensive_reports_first_annexures';    
    protected $fillable = ['id','report_id','question_id','clinic_name','operating_since','action_taken','status'];


}
 	
