<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprehensiveReportsThirdAnnexure extends Model
{
    use HasFactory;
    public $timestamps = true; 
    protected $table = 'comprehensive_reports_third_annexures';    
    protected $fillable = ['id','report_id','question_id','case_filed_by','case_filed_against','section_act_for_violation','issue_details','persons_arrested','case_outcome','status'];
}  
