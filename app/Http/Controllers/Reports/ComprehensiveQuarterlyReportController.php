<?php
namespace App\Helpers;
namespace App\Http\Controllers\Reports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Validation\Rule;
use App\Models\Report\ComprehensiveQuarterlyReport;
use App\Models\Report\ComprehensiveReportFirstAnnexure;
use App\Models\Report\ComprehensiveReportsSecondAnnexure;
use App\Models\Report\ComprehensiveReportsThirdAnnexure;
use App\Models\clinic\SurrogacyClinicModel; 
use App\Models\clinic\BankModel;
use App\Models\clinic\ArtClinicModel;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log as log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ComprehensiveQuarterlyReportController extends Controller
{

    //Report quater and year filter code
    public function quarterlyReport(Request $request)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }
        $quarters = DB::table('patient_clinic_database.quarter_table')->get();
        return view('reports.comprehensive_quarterly_form', compact('quarters'));
    }

    //After filter submition method

    public function quarterlyReportForm(Request $request)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }
         // print_r(session()->all());die;
           
        $currentYear =Carbon::now()->year;
        $currentQuarter = Carbon::now()->quarter;
        //echo  $currentQuarter;die;
        $validated = $request->validate([
                            'year'  => ['required', 'digits:4', 'integer', 'min:2000', 'max:' . date('Y'),
                                                function ($attribute, $value, $fail) use ($request, $currentYear, $currentQuarter) {
                                                    if ($request->year == $currentYear && $request->quarter >= $currentQuarter) {
                                                        $fail('For the current year, you can select only quarters before the current quarter.');
                                                    }
                                                }
                                            ],        
                            'quarter' => ['required', 'integer',
                                            Rule::when(
                                            $request->year == 2022,
                                            ['in:4'],          // allow only Oct–Dec
                                            ['in:1,2,3,4']  // normal years
                                            ),                                             
                                            function ($attribute, $value, $fail) use ($request, $currentYear, $currentQuarter) {

                                            //  Before 2022
                                            if ($request->year < 2022) {
                                                $fail('Reports for years before 2022 are not allowed.');
                                            }

                                            //  Year 2022 → only Q4
                                            if ($request->year == 2022 && $request->quarter > 4) {
                                                $fail('For the year 2022, only quarter 4 (Oct–Dec) is allowed.');
                                            }                
                                            }
                                        ] 
                                        
                        ]);
 
      
            $userId  = Session::get('id'); 
   
             $quarters =[];
            $reportResult=['']; 
            $firstAnnexureResultQ9=[];
            $secondAnnexureResultQ15=[]; 
            $secondAnnexureResultQ16 =[]; 
            $thirdAnnexureResultQ18 =[];
            $thirdAnnexureResultQ22 =[];
            //main master query
            $filterYear=$request->year;
            $filterQuarter=$request->quarter; 
           $reportResult = ComprehensiveQuarterlyReport::where('state_auth_id', $userId)
            ->where('year', $filterYear)
            ->where('quarter', $filterQuarter)
            ->first(); 
 
            // first Annexure Result Question 9
            if(isset($reportResult->report_id))
            {
              $reportID=$reportResult->report_id;  
            }else {
                 $reportID=0;
            }  
      
            $firstAnnexureResultQ9 = ComprehensiveReportFirstAnnexure::select('id','report_id','question_id','clinic_name','operating_since','action_taken')          
            ->where('report_id', $reportID)
            ->where('status', 1)
            ->get(); 
                 
             // Second Annexure Result Question 15
              $secondAnnexureResultQ15 = ComprehensiveReportsSecondAnnexure::select('id','report_id','question_id','complaint_source','filed_by','filed_against','issue_details','action_taken','outcome')          
            ->where('report_id', $reportID)
             ->where('question_id', 15)
            ->where('status', 1)
            ->get(); 
            // Second Annexure Result Question 16
             $secondAnnexureResultQ16 = ComprehensiveReportsSecondAnnexure::select('id','report_id','question_id','complaint_source','filed_by','filed_against','issue_details','action_taken','outcome')          
            ->where('report_id', $reportID)
             ->where('question_id', 16)
            ->where('status', 1)
            ->get(); 
            // Third Annexure Result Question 18
            $thirdAnnexureResultQ18 = ComprehensiveReportsThirdAnnexure::select('id','report_id','question_id','case_filed_by','case_filed_against','section_act_for_violation','issue_details','persons_arrested','case_outcome')          
            ->where('report_id', $reportID)
             ->where('question_id', 18)
            ->where('status', 1)
            ->get(); 
             // Third Annexure Result Question 22
            $thirdAnnexureResultQ22 = ComprehensiveReportsThirdAnnexure::select('id','report_id','question_id','case_filed_by','case_filed_against','section_act_for_violation','issue_details','persons_arrested','case_outcome')          
            ->where('report_id', $reportID)
             ->where('question_id', 22)
            ->where('status', 1)
            ->get(); 
           	
         
        $quartersName = DB::table('patient_clinic_database.quarter_table')->select('description')->where('quarter', $filterQuarter)->first();  
        
        $filterData['Year'] = $filterYear;
        $filterData['Quarter'] = $filterQuarter;
        $filterData['Quartername'] = $quartersName->description;
        $state_name = Session::get('state_name');
        $filterData['state_name'] = $state_name;
        [$from_date, $to_date] = $this->getQuarterDateRange($filterYear, $filterQuarter);
        $artclinic = ArtClinicModel::where('state', $state_name)
                    ->where('status',1)
                    ->whereIn('archive_status', [0, 1])
                    ->whereBetween('applicationno_datetime_submission', [
                        $from_date,
                        $to_date
                    ])
                    ->count();
        $artclinic2 = ArtClinicModel::where('state', $state_name)->where('status',1)->whereIn('archive_status', [0, 1])->whereDate('applicationno_datetime_submission', '<=', $to_date)->count();
        $artbank = BankModel::where('state', $state_name)
                    ->where('status',1)
                    ->whereIn('archive_status', [0, 1])
                    ->whereBetween('applicationno_datetime_submission', [
                        $from_date,
                        $to_date
                    ])
                    ->count();
        $artbank2 = BankModel::where('state', $state_name)->where('status',1)->whereIn('archive_status', [0, 1])->whereDate('applicationno_datetime_submission', '<=', $to_date)->count();
        $surrogacy_clinic = SurrogacyClinicModel::where('state', $state_name)
                    ->where('status',1)
                    ->whereIn('archive_status', [0, 1])
                    ->whereBetween('applicationno_datetime_submission', [
                        $from_date,
                        $to_date
                    ])
                    ->count();
        $surrogacy_clinic2 = SurrogacyClinicModel::where('state', $state_name)->where('status',1)->whereIn('archive_status', [0, 1])->whereDate('applicationno_datetime_submission', '<=', $to_date)->count();
    //     dd($from_date, $to_date,
    //     $artclinic,
    //     $artclinic2,
    //     $artbank,
    //     $artbank2,
    //     $surrogacy_clinic,
    //     $surrogacy_clinic2
    // );

        $prefillData['artclinic'] = $artclinic ;
        $prefillData['qtrartclinic'] = $artclinic2 ;
        $prefillData['artbank'] =  $artbank;
        $prefillData['qtrartbank'] =  $artbank2;
        $prefillData['surrogacy_clinic'] =  $surrogacy_clinic;
        $prefillData['qtrsurrogacy_clinic'] =  $surrogacy_clinic2;


        if (!$reportResult) {
            return view('reports.comprehensive_quarterly_reports',compact('prefillData','filterData','quartersName', 'reportResult','firstAnnexureResultQ9','secondAnnexureResultQ15','secondAnnexureResultQ16','thirdAnnexureResultQ18','thirdAnnexureResultQ22'));
        }
        if ($reportResult->status == 1) {
            return redirect()->route('report.Quarterlyreport')->with('warning', 'The quarterly report submission has already been completed.');
        } elseif ($reportResult->status == 2 || is_null($reportResult->status)) {

            return view('reports.comprehensive_quarterly_reports', compact('prefillData','filterData','quarters','reportResult', 'firstAnnexureResultQ9','secondAnnexureResultQ15','secondAnnexureResultQ16','thirdAnnexureResultQ18','thirdAnnexureResultQ22'));
        } else {
            $quarters = DB::table('patient_clinic_database.quarter_table')->get();
            return view( 'reports.comprehensive_quarterly_form', compact('quarters'));
        }         
    }
    public function quarterlyReportFormCreate(Request $request)
    {       
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }
        $userId = Session::get('id'); 
        $stateId  = Session::get('state'); 
        $formData = $request->all();  
        
        //Validation work
         $currentYear =now()->year;
        $currentQuarter =now()->quarter;
        if($formData['common'] != 'draft') {
                $validator = Validator::make($request->all(), [
                'applicant_name'=> ['required'] ,
           'designation'=> ['required'] , 
           'place'=> ['required'] ,
            'year' => [
                'required',
                'digits:4',
                'integer',
                'min:2000',
                'max:' . date('Y'),
            ],

            'quarter' => [
                'required',
                'integer',
                'between:1,4',

                // Year 2022 → only Q4
                Rule::when(
                    $request->year == 2022,
                    ['in:4'],
                    ['in:1,2,3,4']
                ),

                function ($attribute, $value, $fail) use ($request, $currentYear, $currentQuarter) {

                    //  Before 2022
                    if ($request->year < 2022) {
                        $fail('Reports for years before 2022 are not allowed.');
                    }

                    //  Current year → only before current quarter
                    if ($request->year == $currentYear && $request->quarter >= $currentQuarter) {
                        $fail('For the current year, you can select only quarters before the current quarter.');
                    }
                }
            ],

        ]);
        //  Redirect to specific route if validation fails
        if ($validator->fails()) {
            return redirect()
                ->route('report.Quarterlyreport')
                ->withErrors($validator)
                ->withInput();
        }

        // ✅ Validation passed
        $validated = $validator->validated(); 
        }
                
        //Check DB if record already submited
        $reportResult = ComprehensiveQuarterlyReport::where('state_auth_id', $userId)
        ->where('year', $formData['year'])
        ->where('quarter', $formData['quarter'])
        ->first();

        // ✅ Always check if record exists
        if ($reportResult && $reportResult->status == 1) {
        return redirect()
        ->route('report.Quarterlyreport')
        ->with('warning', 'Quarterly report submission already completed.');
       }
       //End Validation and start Insert/update code  
        $draft = [];         
        if($formData['common'] == 'draft') {
            $status=2;  //Set Status Save as Draft
            //Query check record is exist or not           
            $draft = ComprehensiveQuarterlyReport::select('report_id')->where([
                ['state_auth_id', '=', $userId],
                ['quarter', '=', $formData['quarter']],
                ['year', '=', $formData['year']],
                ['status', '=', 2],
            ])->first();    //->toSql() 
          
            if ($draft) {
                // Record exists
                $queryStatus = 'Update';
                $report_id = $draft['report_id'];               
            } else {
                // Record does not exist
                $queryStatus = 'Insert';
                $report_id = 0;                  
            }             
        }else{
            
               $status=1;   //Set Status Final Submit
               //Query check record is exist or not
               $submit = ComprehensiveQuarterlyReport::select('report_id')->where([
                ['state_auth_id', '=', $userId],
                ['quarter', '=', $formData['quarter']],
                ['year', '=', $formData['year']],
                ['status', '=', 2],
            ])->first(); 
            if($submit){

                $rules = require app_path('Http/Validations/comprehensive_quarterly_report_validations.php');
                // dd($rules);
                if(!$rules){
                    dd('something went wrong please contact support');
                }
                $errors = [];

                foreach ($rules as $r) {
                    $firstVal = (int) $request->input($r['first'], 0);
                    $secondVal = (int) $request->input($r['second'], 0);

                    if ($r['rule'] === 'secondLessThanFirst' && $secondVal < $firstVal) {
                        $errors[$r['errorId']] = $r['message'];
                    }
                        if ($r['rule'] === 'secondGreaterThanFirst' && $secondVal > $firstVal) {
                            $errors[$r['errorId']] = $r['message'];
                        }
                }
                if (!empty($errors)) {
                    return redirect()
                    ->route('report.Quarterlyreport')
                    ->withErrors($errors)
                    ->withInput();
                }
                 // Record exists
                $queryStatus = 'Update';
                $report_id = $submit['report_id'];   

            }else{
                  // Record does not exist
               $queryStatus = 'Insert';
               $report_id = 0; 
            }    
        }
          
        try {
            $rowdata = [];
            $rowdata['year'] =     $formData['year'];
            $rowdata['quarter'] = $formData['quarter'];
            $rowdata['applicant_name'] = $formData['applicant_name'];
            $rowdata['designation'] = $formData['designation'];
            $rowdata['place'] = $formData['place'];              
            $rowdata['ip_address'] = $request->ip();
            $rowdata['state_auth_id'] = $userId;
            $rowdata['state_id'] = $stateId;
             
            $rowdata['status'] = $status;       
            $rowdata['reports_status'] = 1;  
            if($status==1){$rowdata['final_date']=now();}          
             for ($a = 1; $a <= 13; $a++) {
                $rowdata['art_clinic_q' . $a] = $formData['art_clinic_q' . $a] ?? null;
                $rowdata['art_clinic_qtr_end_q' . $a] = $formData['art_clinic_qtr_end_q' . $a] ?? null;
                $rowdata['art_banks_q' . $a] = $formData['art_banks_q' . $a] ?? null;
                $rowdata['art_banks_qtr_end_q' . $a] = $formData['art_banks_qtr_end_q' . $a] ?? null;
                $rowdata['surrogacy_clinic_q' . $a] = $formData['surrogacy_clinic_q' . $a] ?? null;
                $rowdata['surrogacy_clinic_qtr_end_q' . $a] = $formData['surrogacy_clinic_qtr_end_q' . $a] ?? null;
            }
            $rowdata['appeal_rej_app_a_q14'] = $formData['appeal_rej_app_a_q14'] ?? null;
            $rowdata['appeal_rej_app_qtr_end_a_q14'] = $formData['appeal_rej_app_qtr_end_a_q14'] ?? null;
            $rowdata['appeals_disposed_b_q14'] = $formData['appeals_disposed_b_q14'] ?? null;
            $rowdata['appeals_disposed_qtr_end_b_q14'] = $formData['appeals_disposed_qtr_end_b_q14'] ?? null;
            $rowdata['forwarded_dhr_i_q15'] = $formData['forwarded_dhr_i_q15'] ?? null;
            $rowdata['forwarded_dhr_qtr_end_i_q15'] = $formData['forwarded_dhr_qtr_end_i_q15'] ?? null;
            $rowdata['received_stakeholders_ii_q15'] = $formData['received_stakeholders_ii_q15'] ?? null;
            $rowdata['received_stakeholders_qtr_end_ii_q15'] = $formData['received_stakeholders_qtr_end_ii_q15'] ?? null;
            $rowdata['suo_moto_cognizancеr_iii_q15'] = $formData['suo_moto_cognizancеr_iii_q15'] ?? null;
            $rowdata['suo_moto_cognizancеr_qtr_end_iii_q15'] = $formData['suo_moto_cognizancеr_qtr_end_iii_q15'] ?? null;
            $rowdata['action_taken_a_q16'] = $formData['action_taken_a_q16'] ?? null;
            $rowdata['action_taken_qtr_end_a_q16'] = $formData['action_taken_qtr_end_a_q16'] ?? null;
            $rowdata['art_clinics_b_q16'] = $formData['art_clinics_b_q16'] ?? null;
            $rowdata['art_clinics_qtr_end_b_q16'] = $formData['art_clinics_qtr_end_b_q16'] ?? null;
            $rowdata['art_banks_b_q16'] = $formData['art_banks_b_q16'] ?? null;
            $rowdata['art_banks_qtr_end_b_q16'] = $formData['art_banks_qtr_end_b_q16'] ?? null;
            $rowdata['surrogacy_clinics_b_q16'] = $formData['surrogacy_clinics_b_q16'] ?? null;
            $rowdata['surrogacy_clinics_qtr_end_b_q16'] = $formData['surrogacy_clinics_qtr_end_b_q16'] ?? null;
            $rowdata['appeal_received_a_q17'] = $formData['appeal_received_a_q17'] ?? null;
            $rowdata['appeal_received_qtr_end_a_q17'] = $formData['appeal_received_qtr_end_a_q17'] ?? null;
            $rowdata['appeals_disposed_b_q17'] = $formData['appeals_disposed_b_q17'] ?? null;
            $rowdata['appeals_disposed_qtr_end_b_q17'] = $formData['appeals_disposed_qtr_end_b_q17'] ?? null;
            $rowdata['complaints_filed_q18'] =  $formData['complaints_filed_q18'] ?? null;
            $rowdata['complaints_filed_qtr_end_q18'] = $formData['complaints_filed_qtr_end_q18'] ?? null;
            $rowdata['applications_received_i_a_q19'] = $formData['applications_received_i_a_q19'] ?? null;
            $rowdata['applications_received_qtr_end_i_a_q19'] = $formData['applications_received_qtr_end_i_a_q19'] ?? null;
            $rowdata['applications_received_ii_a_q19'] = $formData['applications_received_ii_a_q19'] ?? null;
            $rowdata['applications_received_qtr_end_ii_a_q19'] = $formData['applications_received_qtr_end_ii_a_q19'] ?? null;
            $rowdata['applications_received_iii_a_q19'] = $formData['applications_received_iii_a_q19'] ?? null;
            $rowdata['applications_received_qtr_end_iii_a_q19'] = $formData['applications_received_qtr_end_iii_a_q19'] ?? null;
            $rowdata['applications_received_iv_a_q19'] = $formData['applications_received_iv_a_q19'] ?? null;
            $rowdata['applications_received_qtr_end_iv_a_q19'] = $formData['applications_received_qtr_end_iv_a_q19'] ?? null;
            $rowdata['applications_granted_i_b_q19'] = $formData['applications_granted_i_b_q19'] ?? null;
            $rowdata['applications_granted_qtr_end_i_b_q19'] = $formData['applications_granted_qtr_end_i_b_q19'] ?? null;
            $rowdata['applications_granted_ii_b_q19'] = $formData['applications_granted_ii_b_q19'] ?? null;
            $rowdata['applications_granted_qtr_end_ii_b_q19'] = $formData['applications_granted_qtr_end_ii_b_q19'] ?? null;
            $rowdata['applications_granted_iii_b_q19'] = $formData['applications_granted_iii_b_q19'] ?? null;
            $rowdata['applications_granted_qtr_end_iii_b_q19'] = $formData['applications_granted_qtr_end_iii_b_q19'] ?? null;
            $rowdata['applications_granted_iv_b_q19'] =  $formData['applications_granted_iv_b_q19'] ?? null;
            $rowdata['applications_granted_qtr_end_iv_b_q19'] = $formData['applications_granted_qtr_end_iv_b_q19'] ?? null;
            $rowdata['applications_rejected_i_c_q19'] = $formData['applications_rejected_i_c_q19'] ?? null;
            $rowdata['applications_rejected_qtr_end_i_c_q19'] = $formData['applications_rejected_qtr_end_i_c_q19'] ?? null;
            $rowdata['applications_rejected_ii_c_q19'] = $formData['applications_rejected_ii_c_q19'] ?? null;
            $rowdata['applications_rejected_qtr_end_ii_c_q19'] = $formData['applications_rejected_qtr_end_ii_c_q19'] ?? null;
            $rowdata['applications_rejected_iii_c_q19'] = $formData['applications_rejected_iii_c_q19'] ?? null;
            $rowdata['applications_rejected_qtr_end_iii_c_q19'] = $formData['applications_rejected_qtr_end_iii_c_q19'] ?? null;
            $rowdata['applications_rejected_iv_c_q19'] = $formData['applications_rejected_iv_c_q19'] ?? null;
            $rowdata['applications_rejected_qtr_end_iv_c_q19'] = $formData['applications_rejected_qtr_end_iv_c_q19'] ?? null;
            $rowdata['appeals_against_rejection_a_q20'] = $formData['appeals_against_rejection_a_q20'] ?? null;
            $rowdata['appeals_against_rejection_qtr_end_a_q20'] = $formData['appeals_against_rejection_qtr_end_a_q20'] ?? null;
            $rowdata['appeals_disposed_b_q20'] = $formData['appeals_disposed_b_q20'] ?? null;
            $rowdata['appeals_disposed_qtr_end_b_q20'] = $formData['appeals_disposed_qtr_end_b_q20'] ?? null;
            $rowdata['meeting_date_q21'] = $formData['meeting_date_q21'] ?? null;
            $rowdata['meeting_date_qtr_end_q21'] = $formData['meeting_date_qtr_end_q21'] ?? null;
            $rowdata['chapter_v_art_q22'] = $formData['chapter_v_art_q22'] ?? null;
            $rowdata['chapter_v_art_qtr_end_q22'] = $formData['chapter_v_art_qtr_end_q22'] ?? null;
            $rowdata['surrogacy_chapter_vii_q22'] = $formData['surrogacy_chapter_vii_q22'] ?? null;
            $rowdata['surrogacy_chapter_qtr_end_vii_q22'] = $formData['surrogacy_chapter_qtr_end_vii_q22'] ?? null;  
            if ($queryStatus == 'Update') {   //Save As draft case                  
                ComprehensiveQuarterlyReport::where('report_id', $report_id)->update($rowdata);
                $insertedId = $report_id;
            } else {   //submit case
                 //Final Submit                 
                $report = ComprehensiveQuarterlyReport::create($rowdata);
                $insertedId = $report->id;
            }
            //Question 9 First Annexure
            if (isset($formData['clinic_name_q9'])) {                
                if (count($formData['clinic_name_q9']) > 0) {
                    $rowdata_q9 = [];
                    if ($queryStatus == 'Update') {   //Save As draft case   
                         ComprehensiveReportFirstAnnexure::where(['report_id' => $insertedId, 'question_id' => 9])->delete();
                    }
                    for ($i = 0; $i <= count($formData['clinic_name_q9']); $i++) {

                        if (!empty($formData['clinic_name_q9'][$i]) || !empty($formData['operating_since_q9'][$i])) {
                           // $os = date('Y-m-d', strtotime($formData['operating_since_q9'][$i]));
                            $rowdata_q9 = [
                                'report_id' =>   $insertedId,
                                'question_id' => 9,
                                'clinic_name'    => $formData['clinic_name_q9'][$i] ?? null,
                                'operating_since' => !empty($formData['operating_since_q9'][$i]) ? date('Y-m-d', strtotime($formData['operating_since_q9'][$i])): null,
                                'action_taken'    => $formData['action_taken_q9'][$i] ?? null,
                                'status'    => 1,
                            ];
                             ComprehensiveReportFirstAnnexure::create($rowdata_q9);
                        }
                    }
                }
            }
            //Question 15 Second Annexure
            if (isset($formData['complaint_source_q15'])) {
                // $rowdata_q15 = [];
                if (count($formData['complaint_source_q15']) > 0) {
                    $rowdata_q15 = [];
                    if ($queryStatus == 'Update') {   //Save As draft case
                        ComprehensiveReportsSecondAnnexure::where(['report_id' => $insertedId, 'question_id' => 15])->delete();
                    }
                    for ($j = 0; $j <= count($formData['complaint_source_q15']); $j++) {

                        if (!empty($formData['complaint_source_q15'][$j]) || !empty($formData['filed_by_q15'][$j]) || !empty($formData['filed_against_q15'][$j]) || !empty($formData['issue_details_q15'][$j]) || !empty($formData['action_taken_q15'][$j]) || !empty($formData['outcome_q15'][$j])) {
                            $rowdata_q15 = [
                                'report_id' => $insertedId,
                                'question_id' => 15,
                                'complaint_source'    => $formData['complaint_source_q15'][$j] ?? null,
                                'filed_by' => $formData['filed_by_q15'][$j] ?? null,
                                'filed_against' => $formData['filed_against_q15'][$j] ?? null,
                                'issue_details' => $formData['issue_details_q15'][$j] ?? null,
                                'action_taken'    => $formData['action_taken_q15'][$j] ?? null,
                                'outcome'    => $formData['outcome_q15'][$j] ?? null,
                                'status'    => 1,
                            ];
                            ComprehensiveReportsSecondAnnexure::create($rowdata_q15);
                        }
                    }
                }
            }
            //Question 16 Second Annexure
            if (isset($formData['complaint_source_q16'])) {
                if (count($formData['complaint_source_q16']) > 0) {
                    if ($queryStatus == 'Update') {   //Save As draft case
                         ComprehensiveReportsSecondAnnexure::where(['report_id' => $insertedId, 'question_id' => 16])->delete();
                    }
                    $rowdata_q16 = [];
                    for ($k = 0; $k <= count($formData['complaint_source_q16']); $k++) {
                        if (!empty($formData['complaint_source_q16'][$k]) || !empty($formData['filed_by_q16'][$k]) || !empty($formData['filed_against_q16'][$k]) || !empty($formData['issue_details_q16'][$k]) || !empty($formData['action_taken_q16'][$k]) || !empty($formData['outcome_q16'][$k])) {
                            $rowdata_q16 = [
                                'report_id' =>  $insertedId,
                                'question_id' => 16,
                                'complaint_source'    => $formData['complaint_source_q16'][$k] ?? null,
                                'filed_by' => $formData['filed_by_q16'][$k] ?? null,
                                'filed_against' => $formData['filed_against_q16'][$k] ?? null,
                                'issue_details' => $formData['issue_details_q16'][$k] ?? null,
                                'action_taken'    => $formData['action_taken_q16'][$k] ?? null,
                                'outcome'    => $formData['outcome_q16'][$k] ?? null,
                                'status'    => 1,
                            ];
                            ComprehensiveReportsSecondAnnexure::create($rowdata_q16);
                        }
                    }
                }
            }
            //Question 18 Second Annexure
            if (isset($formData['case_filed_by_q18'])) {
                if (count($formData['case_filed_by_q18']) > 0) {
                    if ($queryStatus == 'Update') {   //Save As draft case
                        ComprehensiveReportsThirdAnnexure::where(['report_id' => $insertedId, 'question_id' => 18])->delete();
                    }
                    $rowdata_q18 = [];
                    for ($l = 0; $l <= count($formData['case_filed_by_q18']); $l++) {
                        if (!empty($formData['case_filed_by_q18'][$l]) || !empty($formData['case_filed_against_q18'][$l]) || !empty($formData['section_act_for_violation_q18'][$l]) || !empty($formData['issue_details_q18'][$l]) || !empty($formData['persons_arrested_q18'][$l]) || !empty($formData['case_outcome_q18'][$l])) {

                            $rowdata_q18 = [
                                'report_id' =>  $insertedId,
                                'question_id' => 18,
                                'case_filed_by'    => $formData['case_filed_by_q18'][$l] ?? null,
                                'case_filed_against' => $formData['case_filed_against_q18'][$l] ?? null,
                                'section_act_for_violation' => $formData['section_act_for_violation_q18'][$l] ?? null,
                                'issue_details' => $formData['issue_details_q18'][$l] ?? null,
                                'persons_arrested'    => $formData['persons_arrested_q18'][$l] ?? null,
                                'case_outcome'    => $formData['case_outcome_q18'][$l] ?? null,
                                'status'    => 1,
                            ];
                            ComprehensiveReportsThirdAnnexure::create($rowdata_q18);
                        }
                    }
                }
            }
            //Question 22 Second Annexure
            if (isset($formData['case_filed_by_q22'])) {
                if (count($formData['case_filed_by_q22']) > 0) {
                    if ($queryStatus == 'Update') {   //Save As draft case
                         ComprehensiveReportsThirdAnnexure::where(['report_id' => $insertedId, 'question_id' => 22])->delete();
                    }
                    $rowdata_q22 = [];
                    for ($m = 0; $m <= count($formData['case_filed_by_q22']); $m++) {
                        if (!empty($formData['case_filed_by_q22'][$m]) || !empty($formData['case_filed_against_q22'][$m]) || !empty($formData['section_act_for_violation_q22'][$m]) || !empty($formData['issue_details_q22'][$m]) || !empty($formData['persons_arrested_q22'][$m]) || !empty($formData['case_outcome_q22'][$m])) {

                            $rowdata_q22 = [
                                'report_id' =>  $insertedId,
                                'question_id' => 22,
                                'case_filed_by'    => $formData['case_filed_by_q22'][$m] ?? null,
                                'case_filed_against' => $formData['case_filed_against_q22'][$m] ?? null,
                                'section_act_for_violation' => $formData['section_act_for_violation_q22'][$m] ?? null,
                                'issue_details' => $formData['issue_details_q22'][$m] ?? null,
                                'persons_arrested'    => $formData['persons_arrested_q22'][$m] ?? null,
                                'case_outcome'    => $formData['case_outcome_q22'][$m] ?? null,
                                'status'    => 1,
                            ];
                            ComprehensiveReportsThirdAnnexure::create($rowdata_q22);
                        }
                    }
                }
            }

            if ($status==2) {             
                           return redirect('/Quarterly-report')->with(['success' => 'Quarterly report saved as draft successfully.']);
               
            } else {         
                 $message= ($formData['common'] == 'draft') ? 'Quarterly report saved as draft successfully.' : 'Quarterly report has been submitted successfully.';
                 return redirect('/Quarterly-report')->with(['success' => $message]);                
            }
        } catch (\Exception $e) {            
            log::error("Error Quarterly report inserting data: " . $e->getMessage() . "..............userid: " . $userId);                     
             return redirect()->back()->with(['error' => 'Failed to insert data!', 'quarters' => $quarters]);          
        }
    }
    public function quarterlyReportList(Request $request,$flagid)
    { 
        if($flagid==2){
            if (empty(Session::has('id'))) {
                return redirect()->route('admin.loginssaform');
            }
            $userId = Session::get('id');        
            $viewpage='reports.quarterly_reports_view_ssa';
        }else{
                $userId ="";
            $viewpage='reports.quarterly_reports_view_admin';
        }

        if($flagid==2){
                $reportResult = ComprehensiveQuarterlyReport::from('comprehensive_quarterly_reports as cqr')
                ->select('cqr.report_id','cqr.year','cqr.quarter','qt.description as quarter_name','cqr.status','cqr.reports_status','cqr.final_date','s.state_name')
                ->leftJoin('patient_clinic_database.quarter_table as qt', 'qt.quarter', '=', 'cqr.quarter')
                ->leftJoin('state as s', 's.state_id', '=', 'cqr.state_id')
                ->when($userId, function ($query) use ($userId) {
                    $query->where('cqr.state_auth_id', $userId);
                })
                ->where('cqr.reports_status', 1)
                ->orderBy('cqr.year', 'desc')
                ->orderBy('cqr.quarter', 'desc')
                ->get();
        }else{
                $reportResult = ComprehensiveQuarterlyReport::from('comprehensive_quarterly_reports as cqr')
                ->select('cqr.report_id','cqr.year','cqr.quarter','qt.description as quarter_name','cqr.status','cqr.reports_status','cqr.final_date','s.state_name')
                ->leftJoin('patient_clinic_database.quarter_table as qt', 'qt.quarter', '=', 'cqr.quarter')
                ->leftJoin('state as s', 's.state_id', '=', 'cqr.state_id')
                ->when($userId, function ($query) use ($userId) {
                $query->where('cqr.state_auth_id', $userId);
                })
                ->where('cqr.reports_status', 1)
                ->orderBy('cqr.quarter', 'asc')
                ->orderBy('cqr.year', 'asc')
                ->get();
        }
        $quarters = DB::table('patient_clinic_database.quarter_table')->get();  
        $state = DB::table('state')->get();         
        return view($viewpage, compact('quarters','reportResult','state'));
       //  return view('reports.quarterly_reports_view_admin', compact('quarters','reportResult'));
        
    }
    function getAnxurData($reportID){
        $data=[];
        $firstAnnexureResultQ9=[];
        $secondAnnexureResultQ15=[]; 
        $secondAnnexureResultQ16 =[]; 
        $thirdAnnexureResultQ18 =[];
        $thirdAnnexureResultQ22 =[];
        $firstAnnexureResultQ9 = ComprehensiveReportFirstAnnexure::select('id','report_id','question_id','clinic_name','operating_since','action_taken')          
        ->where('report_id', $reportID)
        ->where('status', 1)
        ->get(); 
        $data['firstAnnexureResultQ9']=$firstAnnexureResultQ9;

        // Second Annexure Result Question 15  
        $secondAnnexureResultQ15 = ComprehensiveReportsSecondAnnexure::select('id','report_id','question_id','complaint_source','filed_by','filed_against','issue_details','action_taken','outcome')          
        ->where('report_id', $reportID)
        ->where('question_id', 15)
        ->where('status', 1)
        ->get(); 
        $data['secondAnnexureResultQ15']=$secondAnnexureResultQ15;
        // Second Annexure Result Question 16
        $secondAnnexureResultQ16 = ComprehensiveReportsSecondAnnexure::select('id','report_id','question_id','complaint_source','filed_by','filed_against','issue_details','action_taken','outcome')          
        ->where('report_id', $reportID)
        ->where('question_id', 16)
        ->where('status', 1)
        ->get(); 
        $data['secondAnnexureResultQ16']=$secondAnnexureResultQ16;
        // Third Annexure Result Question 18
        $thirdAnnexureResultQ18 = ComprehensiveReportsThirdAnnexure::select('id','report_id','question_id','case_filed_by','case_filed_against','section_act_for_violation','issue_details','persons_arrested','case_outcome')          
        ->where('report_id', $reportID)
        ->where('question_id', 18)
        ->where('status', 1)
        ->get(); 
        $data['thirdAnnexureResultQ18']=$thirdAnnexureResultQ18;
        // Third Annexure Result Question 22
        $thirdAnnexureResultQ22 = ComprehensiveReportsThirdAnnexure::select('id','report_id','question_id','case_filed_by','case_filed_against','section_act_for_violation','issue_details','persons_arrested','case_outcome')          
        ->where('report_id', $reportID)
        ->where('question_id', 22)
        ->where('status', 1)
        ->get(); 
        $data['thirdAnnexureResultQ22']=$thirdAnnexureResultQ22;
        return   $data;
    }
    public function quarterlyReportViewSsa(Request $request,$report_id){  
 
       $reportid = Crypt::decryptString($report_id);  
        if($reportid==""){
            return redirect()->back()->with(['error' => 'Oops! Something went wrong on our server.']);      
        }
            
        $reportResult=[];      
        //main master query  
        $reportResult = ComprehensiveQuarterlyReport::join('state as s', 's.state_id', '=', 'comprehensive_quarterly_reports.state_id')
        ->leftJoin('patient_clinic_database.quarter_table as qt', 'qt.quarter', '=', 'comprehensive_quarterly_reports.quarter')
        ->where('comprehensive_quarterly_reports.report_id', $reportid)
        ->select('comprehensive_quarterly_reports.*','s.state_name','qt.description')
        ->first();
        $annexureResult=$this->getAnxurData($reportid);   //Anuxer Data  
         
        return view('reports.comprehensive_quarterly_report_view_ssa',compact('reportResult','annexureResult'));
    } 
    //Admin
    public function quarterlyReportViewAdmin(Request $request,$report_id){  
       // print_r($request->all());die;
        $reportid = Crypt::decryptString($report_id); 
        if($reportid==""){
            return redirect()->back()->with(['error' => 'Oops! Something went wrong on our server.']);      
        }
            
        $reportResult=[];      
        //main master query  
        $reportResult = ComprehensiveQuarterlyReport::join('state as s', 's.state_id', '=', 'comprehensive_quarterly_reports.state_id')
        ->leftJoin('patient_clinic_database.quarter_table as qt', 'qt.quarter', '=', 'comprehensive_quarterly_reports.quarter')
        ->where('comprehensive_quarterly_reports.report_id', $reportid)
        ->select('comprehensive_quarterly_reports.*','s.state_name','qt.description')
        ->first();
        $annexureResult=$this->getAnxurData($reportid);   //Anuxer Data  

       //  return view('reports.comprehensive_quarterly_report_view_ssa',compact('reportResult','annexureResult'));
         
        return view('reports.comprehensive_quarterly_report_view_admin',compact('reportResult','annexureResult'));
    }     
 
    public function quarterlyReportPdf(Request $request,$reportID){ 
     
        $reportID = Crypt::decryptString($reportID);
        if ($reportID==""){      
            return response()->view('errors.fancy', [], 404);
        }          
        $reportResult = ComprehensiveQuarterlyReport::join('state as s', 's.state_id', '=', 'comprehensive_quarterly_reports.state_id')
        ->leftJoin('patient_clinic_database.quarter_table as qt', 'qt.quarter', '=', 'comprehensive_quarterly_reports.quarter')
        ->where('comprehensive_quarterly_reports.report_id', $reportID)
        ->select('comprehensive_quarterly_reports.*','s.state_name','qt.description')
        ->first();

        if (!$reportResult) {    
          return response()->view('errors.fancy', [], 404);
       }
        $annexureResult=$this->getAnxurData($reportID);  
        $pdf = Pdf::loadView(
        'reports.comprehensive_quarterly_report_view_pdf',
        compact('reportResult','annexureResult')
        )
        ->setPaper('A3', 'portrait')
        ->setOptions(['dpi' => 150,'defaultFont' => 'sans-serif']);
         return $pdf->stream('comprehensive_quarterly_reports.pdf');
    }
    public function quarterlyReportFilter(Request $request){     
        $formData = $request->all();       
        $year=$formData['year'];
        $quarter=$formData['quarter'];  
        $flagid=$formData['flagid'];  
         
        if($flagid=="" || $flagid >2){
        return redirect()->back()->with(['error' => 'Failed to insert data!']);      
        }
        if($flagid==2){
            $userId = Session::get('id'); 
             $state="";
        }else{
          $userId =""; 
             $state=$formData['state']; 
        } 
        $reportResult = ComprehensiveQuarterlyReport::from('comprehensive_quarterly_reports as cqr')
        ->select('cqr.report_id','cqr.year','cqr.quarter','qt.description as quarter_name','cqr.status','cqr.reports_status','cqr.final_date','s.state_name')
        ->leftJoin('patient_clinic_database.quarter_table as qt', 'qt.quarter', '=', 'cqr.quarter')
        ->leftJoin('state as s', 's.state_id', '=', 'cqr.state_id')
        ->when(!empty($userId), function ($query) use ($userId) {
        $query->where('cqr.state_auth_id', $userId);
        })
        ->when(!empty($quarter), function ($query) use ($quarter) {
        $query->where('cqr.quarter', $quarter);
        })
        ->when(!empty($year), function ($query) use ($year) {
        $query->where('cqr.year', $year);
        })
        ->when(!empty($state), function ($query) use ($state) {
        $query->where('cqr.state_id', $state);
        })
        ->where('cqr.reports_status', 1)
        ->orderBy('cqr.quarter', 'asc') 
        ->orderBy('cqr.year', 'asc')              
        ->get();

        $reportResult = $reportResult->map(function ($row) {
        $row->report_id = Crypt::encryptString($row->report_id);
        return $row;
        });
        return response()->json(['reportResult' => $reportResult]);
    } 
        public function quarterlyReportUploadSignpdf(Request $request,$reportID){    
       
          // echo  $reportID = Crypt::decryptString($reportID);die;
            if ($reportID==""){      
                return response()->view('errors.fancy', [], 404);
            }            
            return view('reports.quarterly_report_upload_sign_pdf',compact('reportID'));
        }
        

        public function getQuarterDateRange($year, $quarterId)
        {
            switch ($quarterId) {
                case 1: // Q1: Jan–Mar
                    $from = Carbon::create($year, 1, 1)->startOfDay();
                    $to   = Carbon::create($year, 3, 31)->endOfDay();
                    break;

                case 2: // Q2: Apr–Jun
                    $from = Carbon::create($year, 4, 1)->startOfDay();
                    $to   = Carbon::create($year, 6, 30)->endOfDay();
                    break;

                case 3: // Q3: Jul–Sep
                    $from = Carbon::create($year, 7, 1)->startOfDay();
                    $to   = Carbon::create($year, 9, 30)->endOfDay();
                    break;

                case 4: // Q4: Oct–Dec
                    $from = Carbon::create($year, 10, 1)->startOfDay();
                    $to   = Carbon::create($year, 12, 31)->endOfDay();
                    break;

                default:
                    throw new \InvalidArgumentException('Invalid Quarter ID');
            }

            return [$from, $to];
        }

     public function ConsolidatedQuarterlyReport(){
        $quarters = DB::table('patient_clinic_database.quarter_table')->get();
        $state = DB::table('state')->get();         
        return view('reports.consolidated_comprehensive_quarterly_reports', compact('quarters','state'));        
     } 
    public function ConsolidatedQuarterlyReportFilter(Request $request){
 
        $currentYear = Carbon::now()->year;
        $currentQuarter = Carbon::now()->quarter;
        $validated = $request->validate([
                        'year' => [
                        'required',
                        'digits:4',
                        'integer',
                        'min:2022',
                        'max:' . $currentYear,
                        function ($attribute, $value, $fail) use ($request, $currentYear, $currentQuarter) {
                        $quarter = $request->input('quarter');
                            if ($value == $currentYear && $quarter >= $currentQuarter) {
                                $fail('For the current year, you can select only quarters before the current quarter.');
                            }
                        }
                        ],
                        'quarter' => [
                        'required',
                        'integer',
                        'between:1,4'
                        ]
                    ]); 

        try{
 
            $formData = $request->all();       
            $yearPost=$formData['year'];
            $quarterPost=$formData['quarter']; 
            $statePost = $formData['state'];  
            $columns = ComprehensiveQuarterlyReport::sumColumns();
            $selects = [];
            foreach ($columns as $column) {
            // table alias added + SQL-safe
            $selects[] = DB::raw("SUM(cqr.$column) AS $column");
            }
            $selects[] = DB::raw("
            GROUP_CONCAT(
            CONCAT(s.state_name, ' :- ', cqr.meeting_date_q21)
            ORDER BY cqr.meeting_date_q21
            SEPARATOR ', <br /><hr>'
            ) AS meeting_state_date_list");

            $selects[] = DB::raw("
            GROUP_CONCAT(
            CONCAT(s.state_name, '')
            ORDER BY cqr.meeting_date_q21
            SEPARATOR ' <br /><hr>'
            ) AS meeting_state_list");

            $selects[] = DB::raw("
            GROUP_CONCAT(       
            CONCAT(s.state_name, ' :- ', cqr.meeting_date_qtr_end_q21)
            ORDER BY cqr.meeting_date_qtr_end_q21 
            SEPARATOR ', <br /><hr>'
            ) AS meeting_state_date_qtr_end_q21_list");

            $selects[] = DB::raw("
            GROUP_CONCAT(
            cqr.report_id 
            ORDER BY cqr.report_id
            SEPARATOR ','
            ) AS report_id_list");

             $selects[] = DB::raw("
            GROUP_CONCAT(
            cqr.state_id 
            ORDER BY cqr.state_id 
            SEPARATOR ','
            ) AS state_id_list");
            
            $selects[] = DB::raw("COUNT(cqr.report_id) as total_records");
            $selects[] = DB::raw("COUNT(s.state_name) as total_state");
            $reportResult = ComprehensiveQuarterlyReport::from('comprehensive_quarterly_reports as cqr')
                ->leftJoin('state as s', 's.state_id', '=', 'cqr.state_id')
                ->select($selects)
                
                ->when(!empty($quarterPost), function ($q) use ($quarterPost) {
                    $q->where('cqr.quarter', $quarterPost);
                })
                ->when(!empty( $yearPost), function ($q) use ( $yearPost) {
                    $q->where('cqr.year',  $yearPost);
                })
                ->when(!empty($statePost) && $statePost !== 'All', function ($q) use ($statePost) {
                    $q->where('cqr.state_id', $statePost);
                })
                ->where('cqr.status', 1)->first();                 
                if($quarterPost !== '' && $quarterPost !== null){
                    $quarter=DB::table('patient_clinic_database.quarter_table')->select('description')->where('quarter', $quarterPost)->first();
                    $quarterName= $quarter->description;
                }else{
                    $quarterName='All';
                }

                if($statePost !== 'All' && $statePost !== null){
                    $state=DB::table('state')->select('state_name')->where('state_id', $statePost)->first();
                    $stateName=$state->state_name;
                }else{
                    $stateName='All';
                }
                $annexure_i= $this->getAnxurReportData($reportResult->report_id_list,1);
                $annexure_ii= $this->getAnxurReportData($reportResult->report_id_list,2);
                $annexure_iii= $this->getAnxurReportData($reportResult->report_id_list,3);
                $reportInfo = ['reportData'  => ($reportResult->total_records>0)? '1' : '0',
                                'yearPost'    => $yearPost,
                                'quarterName' => $quarterName,
                                'stateName'   => $stateName,
                                'annexure_i'  =>$annexure_i,
                                'annexure_ii'  =>$annexure_ii,
                                'annexure_iii'  =>$annexure_iii,
                                'report'=>Crypt::encryptString($reportResult->report_id_list."|".$yearPost.'|'.$quarterName)];
 

                $stateID = !empty($reportResult->state_id_list) 
                    ? explode(',', $reportResult->state_id_list) 
                    : [];

                $query = DB::table('user as u')
                    ->join('state as s', 'u.stateid', '=', 's.state_id')
                    ->select('u.stateid','u.id', 'u.email', 's.state_name')
                    ->where('u.isAdmin', 1);

                if (!empty($stateID)) {
                    $query->whereNotIn('u.stateid', $stateID);
                }
                $statesInfo = $query    
                    ->orderBy('s.state_name', 'ASC')
                    ->get();
                    
                $nonSubitStateCount = $statesInfo->count();
                return view('reports.consolidated_comprehensive_quarterly_reports_view', compact('reportResult', 'reportInfo','statesInfo','nonSubitStateCount'));         
        } catch (\Exception $e) {          
        log::error("Error Consolidated Quarterly report filtering: " . $e->getMessage());                  
        return redirect()->back()->with(['error' => 'Failed to open report!']);          
        }        
    }
    public function ConsolidatedQuarterlyAnnexureReport($report,$type){    
        if (!in_array($type, [1, 2, 3])) {  
            log::error("The URL is tampered with while accessing the Consolidated Quarterly Annexure buttons: Type" );  
            throw new HttpException(403, 'Access denied');
        }
        $info=Crypt::decryptString($report);     
        $info=explode("|",  $info);
        $reportIds= $info[0];  // report id
        $year= $info[1]; // Year   
        $quarter= $info[2];// quarter 
        if($reportIds==""){
            log::error("The URL is being tampered with while accessing the Consolidated Quarterly Annexure buttons using report IDs. buttons: report Ids " );  
            throw new HttpException(403, 'Access denied');
        }         
        if($type==1){ 
                 $queryAnnexure =$this->getAnxurReportData($reportIds,1);                  
        }
        if($type==2){ 
                $queryAnnexure =$this->getAnxurReportData($reportIds,2); 
        } 
        if($type==3){            
                $queryAnnexure= $this->getAnxurReportData($reportIds,3); 
        }
        return view('reports.consolidated_comprehensive_quarterly_report_annexure', compact('queryAnnexure', 'type','year','quarter'));
    }
    public function getAnxurReportData($reportIds,$anxurtype){
        $reportIds = trim($reportIds);
        $reportIds = str_replace(' ', '', $reportIds);
        $reportIds = array_map('trim', explode(',', $reportIds));

          $queryAnnexure=""; 
        if($anxurtype==1){
             $queryAnnexure = ComprehensiveReportFirstAnnexure::from('comprehensive_reports_first_annexures as anx1')
            ->select(
                'cqr.state_id',
                'cqr.report_id',
                'anx1.clinic_name',
                'anx1.operating_since',
                'anx1.action_taken',        
                's.state_name')
            ->rightJoin('comprehensive_quarterly_reports as cqr', 'anx1.report_id', '=', 'cqr.report_id')
            ->leftJoin('state as s', 's.state_id', '=', 'cqr.state_id')
            ->whereIn('cqr.report_id', $reportIds)
            ->where('cqr.reports_status', 1)                      
            ->orderBy('cqr.state_id', 'ASC')
            ->get();             
        }
        if($anxurtype==2){
           $queryAnnexure = ComprehensiveReportsSecondAnnexure::from('comprehensive_reports_second_annexures as anx2')
            ->select(
                'cqr.state_id',
                'cqr.report_id',
                'anx2.complaint_source',
                'anx2.filed_by',
                'anx2.filed_against',
                'anx2.issue_details',
                'anx2.outcome',
                'anx2.action_taken',
                's.state_name')
           ->rightJoin('comprehensive_quarterly_reports as cqr', 'anx2.report_id', '=', 'cqr.report_id')
            ->leftJoin('state as s', 's.state_id', '=', 'cqr.state_id')
            ->whereIn('cqr.report_id', $reportIds)
            ->where('cqr.reports_status', 1)
            ->orderBy('cqr.state_id', 'ASC')   
            ->get();  
        }
        if($anxurtype==3){
           $queryAnnexure = ComprehensiveReportsThirdAnnexure::from('comprehensive_reports_third_annexures as anx3')
            ->select(
                'cqr.state_id',
                'cqr.report_id',
                'anx3.case_filed_by',
                'anx3.case_filed_against',
                'anx3.section_act_for_violation',
                'anx3.issue_details',
                'anx3.persons_arrested',
                'anx3.case_outcome',
                's.state_name')
           ->rightJoin('comprehensive_quarterly_reports as cqr', 'anx3.report_id', '=', 'cqr.report_id')
            ->leftJoin('state as s', 's.state_id', '=', 'cqr.state_id')
            ->whereIn('cqr.report_id', $reportIds)
            ->where('cqr.reports_status', 1)
            ->orderBy('cqr.state_id', 'ASC')      
            ->get();
        }
        return $queryAnnexure;  
    } 
}
