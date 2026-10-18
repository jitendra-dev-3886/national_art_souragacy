<?php

namespace App\Http\Controllers\Reports;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\patient\QuarterTable;
use App\Models\clinic\ClinicRegistrationModel;
use App\Models\patient\SummaryPatientArtLevelOneClinic; 
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log as log;

class ApplicationReportController extends Controller
{
        protected string $db1;
        protected string $db2;

    public function __construct()
    {
    // Always use config(), not env()
        $this->db1 = config('database.connections.artregistry.database');
        $this->db2 = config('database.connections.patient_clinic_database.database');
    }
    
     public function artClinicReport(Request $request)
    {  
      
        $quarters = DB::table($this->db2. '.quarter_table')->get();
        return view('reports.clinic.art-clinic-report',compact('quarters'));
    }

    public function artClinicReportFilter(Request $request){
         
       $data=$request->all();    
       $artClinicLeveloneList = DB::table($this->db2 .'.summary_patient_artclinic_levelone as sp')
    ->join($this->db1 .'.clinic_registration as cr', 'sp.clinic_id', '=', 'cr.clinic_id')
    ->join($this->db2 .'.quarter_table as qtr', 'sp.quarter', '=', 'qtr.quarter')   
    ->where('sp.year',$data['year'])
    ->where('qtr.quarter', $data['quarter'])
    ->where('cr.status', '=', '1') 
    ->where('sp.status', '=', 'Finished') 
    ->select(
        'cr.state',
        'cr.registration_no',        
        'sp.name_of_clinic',
        'sp.year',
        'sp.no_married_couples',
        'sp.no_ongoing_self_gametes',
        'sp.no_ongoing_donor_semen',
        'sp.no_ongoing_single_woman',        
        'sp.no_married_couple',
        'sp.no_completed_self_gametes',
        'sp.no_completed_donor_semen',
        'sp.no_completed_single_woman',
        'sp.created_at',
        'qtr.description'
    )->get(); 
 
     $dataRet ='';    
     $no_ongoing_self_gametes_gtotal=0;
     $no_ongoing_donor_semen_gtotal=0;
     $no_ongoing_single_woman_gtotal=0;
     $no_completed_self_gametes_gtotal=0;
      $no_completed_donor_semen_gtotal=0;
     $no_completed_single_woman_gtotal=0; 
     $dataRet='';  
      if(count($artClinicLeveloneList )>0){
            $sn=1;
            $totalClinic=0;
            foreach($artClinicLeveloneList AS $rowACLOne ){           
                $dataRet .='<tr>
                <td>'. $sn++.'</td>
                <td>'.$rowACLOne->name_of_clinic.'</td>
                <td class="text-center">'.$rowACLOne->registration_no.'</td>
                <td>'.$rowACLOne->state.'</td>
                <td class="text-center">'.$rowACLOne->no_ongoing_self_gametes.'</td>
                  <td class="text-center">'.$rowACLOne->no_ongoing_donor_semen.'</td>
                <td class="text-center">'.$rowACLOne->no_ongoing_single_woman.'</td>
                <td class="text-center">'.$rowACLOne->no_completed_self_gametes.'</td>
                  <td class="text-center">'.$rowACLOne->no_completed_donor_semen.'</td>
                <td class="text-center">'.$rowACLOne->no_completed_single_woman.'</td>
                <td class="text-center">'. date("d-m-Y h:i:s", strtotime($rowACLOne->created_at)).'</td>
                </tr>';
                $no_ongoing_self_gametes_gtotal=$no_ongoing_self_gametes_gtotal+$rowACLOne->no_ongoing_self_gametes;
                $no_ongoing_donor_semen_gtotal=$no_ongoing_donor_semen_gtotal+$rowACLOne->no_ongoing_donor_semen;
                $no_ongoing_single_woman_gtotal = $no_ongoing_single_woman_gtotal+$rowACLOne->no_ongoing_single_woman;

                $no_completed_self_gametes_gtotal =  $no_completed_self_gametes_gtotal+$rowACLOne->no_completed_self_gametes;
                $no_completed_donor_semen_gtotal= $no_completed_donor_semen_gtotal+$rowACLOne->no_completed_donor_semen;
                $no_completed_single_woman_gtotal = $no_completed_single_woman_gtotal+$rowACLOne->no_completed_single_woman;
                $totalClinic=$totalClinic+1;
            } 
            $dataRet .='<tr class="fw-bold" >
                            <td class="text-left fw-bold">Grand Total: </td>
                            <td class="fw-bold">'.$totalClinic.'</td>
                            <td></td>
                            <td></td>    
                            <td class="text-center font-w600 fw-bold">'.$no_ongoing_self_gametes_gtotal.'</td>
                               <td class="text-center font-w600 fw-bold">'.$no_ongoing_donor_semen_gtotal.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$no_ongoing_single_woman_gtotal.'</td>
                            <td class="text-center font-w600 fw-bold">'.$no_completed_self_gametes_gtotal.'</td>
                                  <td class="text-center font-w600 fw-bold">'.$no_completed_donor_semen_gtotal.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$no_completed_single_woman_gtotal.'</td>
                            <td></td>
                         </tr>';
      }else{
            $dataRet .='';
      }
     return $dataRet;
    }
    public function artClinicReportLeveltwo(Request $request){         
        $quarters = DB::table('patient_clinic_database.quarter_table')->get();
         return view('reports.clinic.art-clinic-report-level-two',compact('quarters'));
    }
    public function artClinicReportLeveltwoFilter(Request $request){
     $data=$request->all(); 
    try { 
      $artClinicLeveltwoList = DB::table($this->db2 .'.summary_patient_artclinic_leveltwo as sp')
    ->join($this->db1 .'.clinic_registration as cr', 'sp.clinic_id', '=', 'cr.clinic_id')
    ->join($this->db2 .'.quarter_table as qtr', 'sp.quarter', '=', 'qtr.quarter')   
    ->where('sp.year',$data['year'])
    ->where('qtr.quarter', $data['quarter'])
    ->where('cr.status', '=', '1') 
     ->where('sp.status', '=', 'Finished') 
    ->select(
              'cr.state',
              'cr.registration_no',        
              'sp.name_of_clinic',
              'sp.year',
              'sp.no_ongoing_self_gametes',
              'sp.no_ongoing_donor_gamete',
              'sp.no_one_donor_gamete',
              'sp.no_using_donor_sperm',
              'sp.no_using_donor_gamete',
              'sp.no_completed_self_gametes', 
              'sp.no_one_donor_sperms',  
              'sp.no_one_donor_gametes',
              'sp.no_completed_donor_gamete',
              'sp.no_using_donor_sperms', 
              'sp.no_using_donor_gametes',             
              'sp.no_donor_gamete',
              'sp.no_created_one_donor_gamete',
              'sp.no_created_one_donor_gamete',
              'sp.no_surgical_semen_completed',   
              'sp.no_oocyte_donor',
              'sp.no_self_oocyte_patient',
              'sp.no_created_self_gametes',     
              'sp.no_donor_sperm',   
              'sp.no_donor_oocyte', 
              'sp.no_created_both_donor_gamete',
              'sp.no_patient_sperm_cryo',
              'sp.no_donor_sperm_cryo',
              'sp.no_patient_oocyte_cryo',                       
              'sp.no_donor_oocyte_cryo',
              'sp.created_at', 
              'qtr.description'   
    )->get();  
      $dataRet ='';
      $no_ongoing_self_gametes=0;
      $no_ongoing_donor_gamete=0;     
      $no_using_donor_gamete=0;
      $no_completed_self_gametes=0; 
      $no_using_donor_sperm=0;
      $no_donor_gamete=0;  
      $no_created_one_donor_gamete=0;   
      $no_surgical_semen_completed=0;
      $no_self_oocyte_patient_total=0;
      $no_patient_sperm_cryo=0;
      $no_using_donor_gametes=0;
      $no_created_self_gametes=0;
      $no_created_both_donor_gamete=0;
      $no_using_donor_sperms =0;   
      $no_oocyte_donor=0; 
      $no_patient_oocyte_cryo=0;
      $no_donor_sperm_cryo=0;
      $no_donor_oocyte_cryo=0;   
      $no_self_oocyte_patient=0;
      if(count($artClinicLeveltwoList )>0){ 
            $sn=1;
            $totalClinic=0;
             $dataRet ='';
            foreach($artClinicLeveltwoList AS $rowACLTwo ){           
                $dataRet .='<tr>
                                <td>'. $sn++.'</td>
                                <td>'.$rowACLTwo->name_of_clinic.'</td>
                                <td class="text-center">'.$rowACLTwo->registration_no.'</td>
                                <td>'.$rowACLTwo->state.'</td>
                                <td class="text-center">'.$rowACLTwo->no_ongoing_self_gametes.'</td>
                                <td class="text-center">'.$rowACLTwo->no_ongoing_donor_gamete.'</td>                                
                                <td class="text-center">'.$rowACLTwo->no_using_donor_sperm.'</td>
                                <td class="text-center">'.$rowACLTwo->no_using_donor_gamete.'</td>                                
                                <td class="text-center">'.$rowACLTwo->no_completed_self_gametes.'</td>
                                <td class="text-center">'.$rowACLTwo->no_donor_gamete.'</td>
                                <td class="text-center">'.$rowACLTwo->no_using_donor_sperms.'</td>
                                <td class="text-center">'.$rowACLTwo->no_using_donor_gametes.'</td>  
                                <td class="text-center">'.$rowACLTwo->no_surgical_semen_completed.'</td>
                                <td class="text-center">'.$rowACLTwo->no_oocyte_donor + $rowACLTwo->no_self_oocyte_patient.'</td>                                
                                <td class="text-center">'.$rowACLTwo->no_patient_sperm_cryo .'</td>
                                <td class="text-center">'.$rowACLTwo->no_donor_sperm_cryo.'</td>
                                <td class="text-center">'. $rowACLTwo->no_patient_oocyte_cryo.'</td>
                                <td class="text-center">'.$rowACLTwo->no_donor_oocyte_cryo.'</td>   
                                <td class="text-center">'. $rowACLTwo->no_created_self_gametes.'</td>                                 
                                <td class="text-center">'.$rowACLTwo->no_created_one_donor_gamete +$rowACLTwo->no_created_both_donor_gamete .'</td>
                                <td class="text-center">'. date("d-m-Y h:i:s", strtotime($rowACLTwo->created_at)).'</td>
                            </tr>';                      

                            $no_ongoing_self_gametes=$no_ongoing_self_gametes+$rowACLTwo->no_ongoing_self_gametes;
                            $no_ongoing_donor_gamete=$no_ongoing_donor_gamete+$rowACLTwo->no_ongoing_donor_gamete; 
                            $no_using_donor_sperm=$no_using_donor_sperm+$rowACLTwo->no_using_donor_sperm;
                            $no_using_donor_gamete =  $no_using_donor_gamete+$rowACLTwo->no_using_donor_gamete;  
                            $no_completed_self_gametes = $no_completed_self_gametes+$rowACLTwo->no_completed_self_gametes;
                            $no_donor_gamete=$no_donor_gamete+$rowACLTwo->no_donor_gamete ;     
                            $no_using_donor_sperms = $no_using_donor_sperms+$rowACLTwo->no_using_donor_sperms;
                            $no_using_donor_gametes=$no_using_donor_gametes+ $rowACLTwo->no_using_donor_gametes;
                            $no_surgical_semen_completed=$no_surgical_semen_completed+$rowACLTwo->no_surgical_semen_completed;
                            $no_oocyte_donor= $no_oocyte_donor + $rowACLTwo->no_oocyte_donor;
                            $no_self_oocyte_patient= $no_self_oocyte_patient + $rowACLTwo->no_self_oocyte_patient;
                            $no_self_oocyte_patient_total=  $no_oocyte_donor +  $no_self_oocyte_patient; 
                            $no_patient_sperm_cryo= $no_patient_sperm_cryo + $rowACLTwo->no_patient_sperm_cryo;
                            $no_donor_sperm_cryo =$no_donor_sperm_cryo + $rowACLTwo->no_donor_sperm_cryo;
                            $no_patient_oocyte_cryo= $no_patient_oocyte_cryo + $rowACLTwo->no_patient_oocyte_cryo;
                            $no_donor_oocyte_cryo= $no_donor_oocyte_cryo + $rowACLTwo->no_donor_oocyte_cryo;
                            $no_created_self_gametes=$no_created_self_gametes+ $rowACLTwo->no_created_self_gametes;
                            $no_created_one_donor_gamete = $no_created_one_donor_gamete+$rowACLTwo->no_created_one_donor_gamete;
                            $no_created_both_donor_gamete= $no_created_both_donor_gamete+$rowACLTwo->no_created_both_donor_gamete;   
                            $no_created_both_donor_gamete_total= $no_created_both_donor_gamete + $no_created_one_donor_gamete;                           
                            $totalClinic=$totalClinic+1;
            } 
            $dataRet .='<tr class="fw-bold">
                            <td class="text-left fw-bold">Grand Total: </td>
                            <td class="fw-bold">'.$totalClinic.'</td>
                            <td></td>
                            <td></td>                            
                            <td class="text-center font-w600 fw-bold">'.$no_ongoing_self_gametes.'</td>                                                        
                            <td  class="text-center font-w600 fw-bold">'.$no_ongoing_donor_gamete.'</td>                             
                             <td  class="text-center font-w600 fw-bold">'. $no_using_donor_sperm.'</td>                              
                            <td  class="text-center font-w600 fw-bold">'. $no_using_donor_gamete.'</td> 
                            <td  class="text-center font-w600 fw-bold">'.$no_completed_self_gametes.'</td>                             
                            <td  class="text-center font-w600 fw-bold">'. $no_donor_gamete.'</td>                        
                            <td  class="text-center font-w600 fw-bold">'.$no_using_donor_sperms.'</td> 
                              <td  class="text-center font-w600 fw-bold">'.$no_using_donor_gametes.'</td>
                             <td  class="text-center font-w600 fw-bold">'.$no_surgical_semen_completed.'</td> 
                            <td  class="text-center font-w600 fw-bold">'.$no_self_oocyte_patient_total.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$no_patient_sperm_cryo.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$no_donor_sperm_cryo.'</td>                            
                            <td  class="text-center font-w600 fw-bold">'.$no_patient_oocyte_cryo.'</td>                            
                            <td  class="text-center font-w600 fw-bold">'. $no_donor_oocyte_cryo.'</td>
                            <td  class="text-center font-w600 fw-bold">'. $no_created_self_gametes.'</td>
                            <td  class="text-center font-w600 fw-bold">'. $no_created_both_donor_gamete_total.'</td>                            
                            <td></td>
                        </tr>';
      }else{
            $dataRet .='';
      }
     
        return $dataRet;
    } catch (\Exception $e) {            
            log::error("Error Quarterly report inserting data: " . $e->getMessage());                     
             return redirect()->back()->with(['error' => 'Failed to open report!']);          
        }


    }
    public function surrogacyClinicReport(Request $request){        
        $quarters = DB::table($this->db2 .'.quarter_table')->get();
         return view('reports.clinic.patient-surrogacy-clinics-report',compact('quarters'));
    }
    public function surrogacyClinicReportFilter(Request $request){            
            $data=$request->all();
            try{
            $surrogacyClinicList = DB::table($this->db2 .'.summary_patient_surrogacyclinic as sp')
            ->join($this->db1 .'.clinic_registration as cr', 'sp.clinic_id', '=', 'cr.clinic_id')
            ->join($this->db2 .'.quarter_table as qtr', 'sp.quarter', '=', 'qtr.quarter')   
            ->where('sp.year',$data['year'])
            ->where('qtr.quarter', $data['quarter'])
            ->where('cr.status', '=', '1') 
            ->where('sp.status', '=', 'Finished') 
            ->select(
                    'cr.state',
                    'cr.registration_no',        
                    'sp.name_of_clinic',
                    'sp.year',
                    'sp.no_indian_nationals',
                    'sp.no_foreign_nationals',
                    'sp.no_ongoing_self_gametes',
                    'sp.no_ongoing_oocytes_donor_semen',
                     'sp.no_ongoing_single_woman',
                     'sp.no_completed_self_gametes',
                     'sp.no_completed_oocytes_donor_semen',
                     'sp.no_completed_single_woman',
                     'sp.no_surrogate_mother_ongoing',  
                    'sp.no_surrogate_mother_completed',
                    'sp.no_surgical_retrival_done',
                    'sp.no_self_oocyte_patient',
                    'sp.no_oocyte_donor',
                    'sp.no_patient_semen_cryopreserved',
                    'sp.no_donor_sperm_cryopreserved',
                    'sp.no_patient_oocyte_cryopreserved',
                    'sp.no_donor_oocyte_cryopreserved',
                    'sp.no_donor_sperm', 
                     'sp.no_donor_oocyte',
                     'sp.no_created_using_self_gametes',
                      'sp.no_created_using_one_donor_gamete',  
                      'sp.no_embryos_cryopreserved',                                                
                    'sp.created_at',
                    'qtr.description'    
            )->get(); 
        $dataRet ='';
        $no_indian_nationals=0;
        $no_foreign_nationals=0;
        $no_ongoing_self_gametes=0;
        $no_ongoing_oocytes_donor_semen=0;
        $no_ongoing_single_woman=0;
        $no_completed_self_gametes=0;
        $no_completed_oocytes_donor_semen=0;  
        $no_completed_single_woman=0; 
        $no_surrogate_mother_ongoing=0; 
        $no_surrogate_mother_completed=0;
        $no_surgical_retrival_done=0;
        $no_self_oocyte_patient=0;
        $no_oocyte_donor=0;
        $no_patient_semen_cryopreserved=0;
        $no_donor_sperm=0;      
        $no_donor_oocyte=0;
        $no_self_oocyte_patient=0;      
        $no_donor_sperm_cryopreserved=0;       
        $no_created_using_self_gametes=0; 
        $no_donor_oocyte_cryopreserved=0;
        $no_patient_oocyte_cryopreserved=0;
     
      if(count($surrogacyClinicList )>0){
            $sn=1;
            $totalClinic=0;
             $dataRet ='';
            foreach($surrogacyClinicList AS $row ){           
                $dataRet .='<tr>
                                <td>'. $sn++.'</td>
                                <td>'.$row->name_of_clinic.'</td>
                                <td class="text-center">'.$row->registration_no.'</td>
                                <td>'.$row->state.'</td>    
                                <td class="text-center">'.$row->no_indian_nationals.'</td>
                                <td class="text-center">'.$row->no_foreign_nationals.'</td>
                                <td class="text-center">'.$row->no_ongoing_self_gametes.'</td>     
                                <td class="text-center">'.$row->no_ongoing_oocytes_donor_semen.'</td> 
                                <td class="text-center">'.$row->no_ongoing_single_woman.'</td>
                                <td class="text-center">'.$row->no_completed_self_gametes.'</td>
                                <td class="text-center">'.$row->no_completed_oocytes_donor_semen.'</td>
                                <td class="text-center">'.$row->no_completed_single_woman.'</td>no_completed_single_woman
                                <td class="text-center">'.$row->no_surrogate_mother_ongoing.'</td>
                                <td class="text-center">'.$row->no_surrogate_mother_completed.'</td>                            
                                <td class="text-center">'.$row->no_surgical_retrival_done.'</td> 
                                <td class="text-center">'.$row->no_self_oocyte_patient.'</td>
                                <td class="text-center">' .$row->no_oocyte_donor.'</td>
                                <td class="text-center">'.$row->no_patient_semen_cryopreserved.'</td>
                                <td class="text-center">'.$row->no_donor_sperm_cryopreserved.'</td>
                                <td class="text-center">'.$row->no_patient_oocyte_cryopreserved.'</td>
                                <td class="text-center">'.$row->no_donor_oocyte_cryopreserved.'</td>
                                <td class="text-center">'.$row->no_created_using_self_gametes.'</td>
                                <td class="text-center">'.$row->no_donor_oocyte.'</td>
                                <td class="text-center">'.$row->no_donor_sperm.'</td>
                                <td class="text-center">'. date("d-m-Y h:i:s", strtotime($row->created_at)).'</td>
                            </tr>';                     
                            $no_indian_nationals=$no_indian_nationals+$row->no_indian_nationals;
                            $no_foreign_nationals = $no_foreign_nationals+$row->no_foreign_nationals;
                            $no_ongoing_self_gametes =  $no_ongoing_self_gametes+$row->no_ongoing_self_gametes;
                            $no_ongoing_oocytes_donor_semen=$no_ongoing_oocytes_donor_semen +$row->no_ongoing_oocytes_donor_semen;
                            $no_ongoing_single_woman = $no_ongoing_single_woman+$row->no_ongoing_single_woman;                            
                            $no_completed_self_gametes = $no_completed_self_gametes + $row->no_completed_self_gametes;
                            $no_completed_oocytes_donor_semen= $no_completed_oocytes_donor_semen+ $row->no_completed_oocytes_donor_semen;
                            $no_completed_single_woman=$no_completed_single_woman +$row->no_completed_single_woman;
                            $no_surrogate_mother_ongoing=$no_surrogate_mother_ongoing + $row->no_surrogate_mother_ongoing;
                            $no_surrogate_mother_completed= $no_surrogate_mother_completed + $row->no_surrogate_mother_completed; 
                            $no_surgical_retrival_done= $no_surgical_retrival_done + $row->no_surgical_retrival_done;  
                            $no_self_oocyte_patient=$no_self_oocyte_patient+ $row->no_self_oocyte_patient;
                            $no_oocyte_donor=$no_oocyte_donor+ $row->no_oocyte_donor;
                            $no_patient_semen_cryopreserved= $no_patient_semen_cryopreserved+ $row->no_patient_semen_cryopreserved;
                            $no_donor_sperm_cryopreserved = $no_donor_sperm_cryopreserved+ $row->no_donor_sperm_cryopreserved;
                            $no_patient_oocyte_cryopreserved = $no_patient_oocyte_cryopreserved+$row->no_patient_oocyte_cryopreserved;
                            $no_donor_oocyte_cryopreserved=$no_donor_oocyte_cryopreserved+$row->no_donor_oocyte_cryopreserved;
                             $no_created_using_self_gametes=$no_created_using_self_gametes+$row->no_created_using_self_gametes;
                            $no_donor_sperm= $no_donor_sperm + $row->no_donor_sperm;  
                            $no_donor_oocyte = $no_donor_oocyte+ $row->no_donor_oocyte ;                            
                            $totalClinic=$totalClinic+1;
            } 
            $dataRet .='<tr>
                            <td  class="text-left font-w600 fw-bold">Grand Total: </td>
                            <td class="fw-bold">'.$totalClinic.'</td>
                            <td></td>
                            <td></td>
                            <td class="text-center font-w600 fw-bold">'.$no_indian_nationals.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$no_foreign_nationals.'</td>
                            <td class="text-center font-w600 fw-bold">'.$no_ongoing_self_gametes.'</td>
                            <td class="text-center font-w600 fw-bold">'.$no_ongoing_oocytes_donor_semen.'</td> 
                            <td  class="text-center font-w600 fw-bold">'.$no_ongoing_single_woman.'</td> 
                            <td  class="text-center font-w600 fw-bold">'.$no_completed_self_gametes.'</td> 
                            <td  class="text-center font-w600 fw-bold">'.$no_completed_oocytes_donor_semen.'</td> 
                            <td  class="text-center font-w600 fw-bold">'.$no_completed_single_woman.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$no_surrogate_mother_ongoing. '</td>  
                            <td  class="text-center font-w600 fw-bold">'.$no_surrogate_mother_completed.'</td> 
                            <td  class="text-center font-w600 fw-bold">'.$no_surgical_retrival_done.'</td>  
                            <td  class="text-center font-w600 fw-bold">'.$no_self_oocyte_patient.'</td>  
                            <td  class="text-center font-w600 fw-bold">'. $no_oocyte_donor.'</td>  
                            <td  class="text-center font-w600 fw-bold">'.$no_patient_semen_cryopreserved.'</td> 
                             <td  class="text-center font-w600 fw-bold">'. $no_donor_sperm_cryopreserved.'</td> 
                            <td  class="text-center font-w600 fw-bold">'. $no_patient_oocyte_cryopreserved.'</td> 
                            <td  class="text-center font-w600 fw-bold">'. $no_donor_oocyte_cryopreserved.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$no_created_using_self_gametes.'</td> 
                             <td class="text-center font-w600 fw-bold">'.$no_donor_oocyte.'</td>      
                              <td  class="text-center font-w600 fw-bold">'. $no_donor_sperm.'</td>
                            <td></td>                           
                        </tr>';
      }else{
            $dataRet .='';
      }
     return $dataRet;
      } catch (\Exception $e) {          
            log::error("Error Quarterly report inserting data: " . $e->getMessage());                    
             return redirect()->back()->with(['error' => 'Failed to open report!']);          
        }
    }
   
    public function artbankClinicReport(Request $request){      
        $quarters = DB::table($this->db2 .'.quarter_table')->get();
         return view('reports.clinic.patient-art-bank-report',compact('quarters'));
    }
    public function artbankClinicReportFilter(Request $request){   
         
         $data=$request->all(); 
         try{  
          $artBankClinicReportList = DB::table($this->db2 .'.summary_patient_bank as sp')
          ->join($this->db1 .'.clinic_registration as cr', 'sp.clinic_id', '=', 'cr.clinic_id')
          ->join($this->db2 .'.quarter_table as qtr', 'sp.quarter', '=', 'qtr.quarter')      
          ->where('sp.year',$data['year'])
          ->where('qtr.quarter', $data['quarter'])
          ->where('cr.status', '=', '1') 
          ->where('sp.status', '=', 'Finished')             
          ->select(
                  'cr.state',
                  'cr.registration_no',        
                  'sp.name_of_bank',
                  'sp.year',
                  'sp.no_oocyte_donors_screened',
                  'sp.total_semen_donor',  
                  'sp.no_semen_donors_screened',   
                  'sp.no_donor_oocyte',
                  'sp.no_oocyte_cryo', 
                  'sp.no_patient_semen_cryo',
                  'sp.no_donor_semen_cryo' ,
                  'sp.no_patient_oocytes_supplied_surrogacy',
                  'sp.no_donor_surro',
                  'sp.patient_semen_sample_store',   
                  'sp.donor_semen_sample_store',
                  'sp.no_patient_semen_artclinic',   
                  'sp.no_donor_semen_art',               
                  'sp.no_patient_semen_supplied_surrogacy', 
                  'sp.no_donor_semen_surrogacy',
                  'sp.created_at',               
                  'qtr.description'   
          )->get(); 
          $dataRet ='';
          $no_oocyte_donors_screened_gtotal=0;
          $total_semen_donor_gtota =0;
          $no_donor_oocyte_gtotal=0;
          $no_oocyte_cryo_gtotal=0;
          $no_patient_semen_cryo_gtotal=0;
          $no_donor_semen_cryo_gtotal=0;
          $no_patient_oocytes_supplied_surrogacy_gtotal=0;
          $no_donor_surro_gtotal=0;
          $patient_semen_sample_store_gtotal=0;
          $donor_semen_sample_store_gtotal=0;
          $no_patient_semen_artclinic_gtotal=0;
          $no_donor_semen_art_gtotal=0;
          $no_patient_semen_supplied_surrogacy_gtotal=0;
          $no_donor_semen_surrogacy_gtotal=0;
        
      if(count($artBankClinicReportList)>0){         
              $sn=1;
              $totalClinic=0;           
              foreach($artBankClinicReportList AS $row){           
                  $dataRet .='<tr>
                                <td>'. $sn++.'</td>
                                <td>'.$row->name_of_bank.'</td>
                                <td>'.$row->registration_no.'</td>
                                <td>'.$row->state.'</td>  
                                <td class="text-center">'.$row->no_oocyte_donors_screened.'</td>
                                <td class="text-center">'.$row->total_semen_donor.'</td>
                                <td class="text-center">'.$row->no_donor_oocyte.'</td>
                                <td class="text-center">'.$row->no_oocyte_cryo.'</td>
                                <td class="text-center">'.$row->no_patient_semen_cryo.'</td>
                                <td class="text-center">'.$row->no_donor_semen_cryo.'</td>
                                <td class="text-center">'.$row->no_patient_oocytes_supplied_surrogacy.'</td>
                                <td class="text-center">'.$row->no_donor_surro.'</td>
                                <td class="text-center">'.$row->patient_semen_sample_store.'</td>
                                <td class="text-center">'.$row->donor_semen_sample_store.'</td>   
                                <td class="text-center">'.$row->no_patient_semen_artclinic.'</td>
                                <td class="text-center">'.$row->no_donor_semen_art.'</td>
                                <td class="text-center">'.$row->no_patient_semen_supplied_surrogacy.'</td>
                                <td class="text-center"> '.$row->no_donor_semen_surrogacy .'</td>
                                <td class="text-center">'. date("d-m-Y h:i:s", strtotime($row->created_at)).'</td>
                              </tr>';
                              $no_oocyte_donors_screened_gtotal=$no_oocyte_donors_screened_gtotal+$row->no_oocyte_donors_screened;
                              $total_semen_donor_gtota = $total_semen_donor_gtota+$row->total_semen_donor;   
                              $no_donor_oocyte_gtotal=$no_donor_oocyte_gtotal+$row->no_donor_oocyte; 
                              $no_oocyte_cryo_gtotal= $no_oocyte_cryo_gtotal+$row->no_oocyte_cryo;  
                              $no_patient_semen_cryo_gtotal= $no_patient_semen_cryo_gtotal + $row->no_patient_semen_cryo;
                              $no_donor_semen_cryo_gtotal=$no_donor_semen_cryo_gtotal +$row->no_donor_semen_cryo;
                              $no_patient_oocytes_supplied_surrogacy_gtotal = $no_patient_oocytes_supplied_surrogacy_gtotal+$row->no_patient_oocytes_supplied_surrogacy;
                              $no_donor_surro_gtotal= $no_donor_surro_gtotal +$row->no_donor_surro; 
                              $patient_semen_sample_store_gtotal=$patient_semen_sample_store_gtotal+$row->patient_semen_sample_store ; 
                              $donor_semen_sample_store_gtotal=$donor_semen_sample_store_gtotal+$row->donor_semen_sample_store;                             
                              $no_patient_semen_artclinic_gtotal=$no_patient_semen_artclinic_gtotal+$row->no_patient_semen_artclinic;
                              $no_donor_semen_art_gtotal=$no_donor_semen_art_gtotal+$row->no_donor_semen_art;
                              $no_patient_semen_supplied_surrogacy_gtotal=$no_patient_semen_supplied_surrogacy_gtotal+$row->no_patient_semen_supplied_surrogacy ;
                              $no_donor_semen_surrogacy_gtotal= $no_donor_semen_surrogacy_gtotal+ $row->no_donor_semen_surrogacy;                         
                            $totalClinic=$totalClinic+1;
              } 
              $dataRet .='<tr>
                            <td class="text-left font-w600 fw-bold">Grand Total: </td>
                            <td class="fw-bold">'.$totalClinic.'</td>
                            <td></td>
                            <td></td>
                            <td class="text-center font-w600 fw-bold">'.$no_oocyte_donors_screened_gtotal.'</td>
                            <td  class="text-center font-w600 fw-bold">'. $total_semen_donor_gtota.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$no_donor_oocyte_gtotal.'</td>
                            <td  class="text-center font-w600 fw-bold">'. $no_oocyte_cryo_gtotal.'</td> 
                            <td class="text-center font-w600 fw-bold">'.$no_patient_semen_cryo_gtotal.'</td>
                            <td  class="text-center font-w600 fw-bold">'. $no_donor_semen_cryo_gtotal.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$no_patient_oocytes_supplied_surrogacy_gtotal.'</td>
                            <td  class="text-center font-w600 fw-bold">'. $no_donor_surro_gtotal.'</td>                           
                            <td  class="text-center font-w600 fw-bold">'.$patient_semen_sample_store_gtotal.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$donor_semen_sample_store_gtotal.'</td> 
                            <td  class="text-center font-w600 fw-bold">'. $no_patient_semen_artclinic_gtotal.'</td> 
                            <td  class="text-center font-w600 fw-bold">'.  $no_donor_semen_art_gtotal.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$no_patient_semen_supplied_surrogacy_gtotal.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$no_donor_semen_surrogacy_gtotal.'</td>
                            <td></td>
                          </tr>';
      }else{
            $dataRet .='';
      }
     return $dataRet;
      } catch (\Exception $e) {             
            log::error("Error Quarterly report inserting data: " . $e->getMessage());                
             return redirect()->back()->with(['error' => 'Failed to open report!']);          
        }

    }
    public function surrogacyArtClinic(Request $request){          
         $quarters = DB::table($this->db2. '.quarter_table')->get();
          return view('reports.surrogacy_artclinic', compact('quarters')); 
    }
    public function surrogacyArtClinicFilter(Request $request) 
    { 
           
        $data = $request->all();   
        $userInfo=session()->all();              
        $quarter = QuarterTable::where('quarter', $data['quarter'])->first();
        $quarter_desc = $quarter ? $quarter->description : null;   
        $query = DB::table($this->db2.'.patient_surrogacyclinic as ps') 
        ->join($this->db1.'.clinic_registration as cr', function($join) {
            $join->on(DB::raw('ps.clinic_id COLLATE utf8mb4_general_ci'),'=',DB::raw('cr.clinic_id COLLATE utf8mb4_general_ci'))
            ->where('ps.treatment_type', '=', 'art_treatment');
        })
        // Apply JOIN condition dynamically
        ->join($this->db2.'.quarter_table as qtr', function($join) use ($data) {
            $join->on('ps.quarter', '=', 'qtr.quarter');
            // Apply only if NOT "All"
            if (!empty($data['quarter']) && $data['quarter'] != 'All') {
            $join->where('qtr.quarter', '=', $data['quarter']);
            }
        })
        ->where('ps.year', $data['year'])
        ->where('cr.status', 1);
        //check quarter empty or all selected
        if (!empty($data['quarter']) && $data['quarter'] != 'All') {
        $query->where('qtr.quarter', $data['quarter']);
        }
        
        if ($userInfo['user_type'] == 5 && !empty($userInfo['state_name'])) {
        $query->whereRaw('LOWER(TRIM(cr.state)) = ?', [strtolower(trim($userInfo['state_name']))]);
        }

         $artClinicLeveltwoList = $query->select([
        'cr.state',
        'cr.registration_no',
        'cr.name as clinic_name',
        DB::raw("SUM(CASE WHEN ps.art_case_of = 'one' THEN 1 ELSE 0 END) AS married_couple_count,
        SUM(CASE WHEN ps.art_case_of = 'two' THEN 1 ELSE 0 END) AS single_women_count,
        SUM(CASE WHEN ps.art_male_factor = 'Y' THEN 1 ELSE 0 END) AS male_factor,
        SUM(CASE WHEN ps.art_female_factor = 'Y' THEN 1 ELSE 0 END) AS female_factor,
        SUM(CASE WHEN ps.art_unexplained = 'Y' THEN 1 ELSE 0 END) AS unexplained,
        SUM(CASE WHEN ps.art_treat_outcomes = 'Pregnant' THEN 1 ELSE 0 END) AS success_pregnant,
        SUM(CASE WHEN ps.art_treat_outcomes = 'Not Pregnant' THEN 1 ELSE 0 END) AS failed_pregnant,
        SUM(CASE WHEN ps.preganancy_outcome = 'live birth' THEN 1 ELSE 0 END) AS live_birth,
        SUM(CASE WHEN ps.preganancy_outcome = 'Stillbirth' THEN 1 ELSE 0 END) AS still_birth,
        SUM(CASE WHEN ps.preganancy_outcome = 'Spontaneous abortion' THEN 1 ELSE 0 END) AS spontaneous_aboration,
        SUM(CASE WHEN ps.preganancy_outcome = 'Elective termination' THEN 1 ELSE 0 END) AS elective_termination,
        SUM(CASE WHEN ps.preganancy_outcome = 'Therapeutic abortion' THEN 1 ELSE 0 END) AS therapeutic_aboration,
        SUM(CASE WHEN ps.l_birth = 'Singleton' THEN 1 ELSE 0 END) AS singleton,
        SUM(CASE WHEN ps.l_birth = 'Twin' THEN 1 ELSE 0 END) AS twin,
        SUM(CASE WHEN ps.l_birth = 'Higher Order' THEN 1 ELSE 0 END) AS higher_order,
        SUM(CASE WHEN ps.male_number = '1' THEN 1 ELSE 0 END) AS male,
        SUM(CASE WHEN ps.female_number = '1' THEN 1 ELSE 0 END) AS female,     
        SUM(CASE WHEN ps.art_types_of_treat = 'ART Treatment using self gametes' THEN 1 ELSE 0 END) AS self_gametes,
        SUM(CASE 
        WHEN ps.art_types_of_treat = 'ART Treatment using donor gametes'
        AND ps.art_types_of_treat1 = 'Oocyte Donation'
        THEN 1 ELSE 0
        END) AS oocyte_donor,
        SUM(CASE 
        WHEN ps.art_types_of_treat = 'ART Treatment using donor gametes'
        AND ps.art_types_of_treat1 = 'Sperm Donation'
        THEN 1 ELSE 0
        END) AS sperm_donor,
        SUM(CASE 
        WHEN ps.art_types_of_treat = 'ART Treatment using donor gametes'
        AND ps.art_types_of_treat1 = 'Both Oocyte Donation & Sperm Donation'
        THEN 1 ELSE 0
        END) AS both_donor,
        SUM(CASE WHEN ps.art_proc_undertaken = 'artificial insemination' THEN 1 ELSE 0 END) AS artificial_insemination,
        SUM(CASE WHEN ps.art_proc_undertaken = 'intra-uterine insemination(IUI)' THEN 1 ELSE 0 END) AS iui,
        SUM(CASE WHEN ps.art_proc_undertaken = 'in vitro fertilization-embryo transfer' THEN 1 ELSE 0 END) AS ivfet,
        SUM(CASE WHEN ps.art_proc_undertaken = 'gamete intrafallopian tube transfer' THEN 1 ELSE 0 END) AS gitt,
        SUM(CASE WHEN ps.art_proc_undertaken = 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)' THEN 1 ELSE 0 END) AS icsi,
        SUM(CASE WHEN ps.art_proc_undertaken = 'physiological Intra-cytoplasmic sperm injection' THEN 1 ELSE 0 END) AS picsi,
        SUM(CASE WHEN ps.art_proc_undertaken = 'intra-cytoplasmic morphologically selected sperm injection' THEN 1 ELSE 0 END) AS icmssi,
        SUM(CASE WHEN ps.art_proc_undertaken = 'round spermatid nucleus injection' THEN 1 ELSE 0 END) AS rsni,
        SUM(CASE WHEN ps.art_proc_undertaken = 'Elongated spermatid injection' THEN 1 ELSE 0 END) AS esi,
        SUM(CASE WHEN ps.art_proc_undertaken = 'Others' THEN 1 ELSE 0 END) AS other,
        SUM(ps.art_total_num_of_cyc) AS total_num_of_cyc_undertaking,
        SUM(ps.art_no_cycles) AS art_no_cycles
        ")
        ])->groupBy('cr.state', 'cr.registration_no', 'cr.name')
        ->orderBy('cr.name')
        ->get();  
       // echo $query;die;
     //   dd($artClinicLeveltwoList);
        return response()->json(['reportResult' => $artClinicLeveltwoList , 'quarteryear'=>$quarter_desc." ".$data['year']]);
    }
     // public function levelOneartclinicPdf(Request $request){  

    // // print_r($request->all());die;
    //  $data=$request->all();
    //           $artClinicLeveloneList = DB::table('patient_clinic_database.summary_patient_artclinic_levelone as sp')
    // ->join('art_dbnew_testing.clinic_registration as cr', 'sp.clinic_id', '=', 'cr.clinic_id')
    // ->join('patient_clinic_database.quarter_table as qtr', 'sp.quarter', '=', 'qtr.quarter')   
    // ->where('sp.year',$data['year'])
    // ->where('qtr.quarter', $data['quarter'])
    // ->where('cr.status', '=', '1') 
    // ->select(
    //     'cr.state',
    //     'cr.registration_no',        
    //     'sp.name_of_clinic',
    //     'sp.year',
    //     'sp.no_married_couples',
    //     'sp.no_ongoing_single_woman',
    //     'sp.no_married_couple',
    //     'sp.no_completed_single_woman',
    //     'sp.created_at',
    //     'qtr.description'
    // )->get();       

    //     $pdf = Pdf::loadView('reports.clinic.patient-art-clinic-pdf',compact('artClinicLeveloneList'))->setOptions([
    //             'isRemoteEnabled' => true, 
    //         ]);
             
     
    //     return $pdf->download('patient_art_clinic_pdf.pdf');
    // }    

}
