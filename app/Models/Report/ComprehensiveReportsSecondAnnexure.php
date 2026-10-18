<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprehensiveReportsSecondAnnexure extends Model
{
    use HasFactory;
    public $timestamps = true; 
    protected $table = 'comprehensive_reports_second_annexures';    
    protected $fillable = ['id','report_id','question_id','complaint_source','filed_by','filed_against','issue_details','action_taken','outcome','status'];
}
 
