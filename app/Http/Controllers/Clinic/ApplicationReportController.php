<?php

namespace App\Http\Controllers\Reports;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\clinic\signup;
use App\Models\clinic\ClinicRegistrationModel;
use App\Models\patient\SummaryPatientArtLevelOneClinic;
use Barryvdh\DomPDF\Facade\Pdf;

class ApplicationReportController extends Controller
{
    //
     public function artClinicReport(Request $request)
    {    
      
            $userId = Session::get('id');
            $email = $request->session()->get('email');
            $check_user = signup::where('email', $email)->first();       

            if (empty(Session::has('id'))) {
                return redirect()->route('clinic.loginclinicform');
            } 
            $quarters = DB::table('patient_clinic_database.quarter_table')->get();
            $artClinicLeveloneList = DB::table('patient_clinic_database.summary_patient_artclinic_levelone as spaclvlone')
            ->join('artdumydata.clinic_registration as cr', 'spaclvlone.clinic_id', '=', 'cr.clinic_id')
            ->join('patient_clinic_database.quarter_table as qtr', 'spaclvlone.quarter', '=', 'qtr.quarter')
            ->where('cr.status', 1)
            ->select(
                'cr.state',
                'cr.registration_no',
                'cr.status',
                'spaclvlone.name_of_clinic',
                'spaclvlone.year',
                'spaclvlone.no_married_couples',
                'spaclvlone.no_ongoing_single_woman',
                'spaclvlone.no_married_couple',
                'spaclvlone.no_completed_single_woman',
                'spaclvlone.created_at',
                'qtr.description'
            )->get();

        return view('reports.clinic.art-clinic-report',compact('artClinicLeveloneList','quarters'));
    }

    public function artClinicReportFilter(Request $request){
        // dd("sfsdgfvdb");
     $data=$request->all();  
     $artClinicLeveloneList = DB::table('patient_clinic_database.summary_patient_artclinic_levelone as sp')
    ->join('artdumydata.clinic_registration as cr', 'sp.clinic_id', '=', 'cr.clinic_id')
    ->join('patient_clinic_database.quarter_table as qtr', 'sp.quarter', '=', 'qtr.quarter')   
    ->where('sp.year',$data['year'])
    ->where('qtr.quarter', $data['quarter'])
    ->where('cr.status', '=', '1') 
    ->select(
        'cr.state',
        'cr.registration_no',        
        'sp.name_of_clinic',
        'sp.year',
        'sp.no_married_couples',
        'sp.no_ongoing_single_woman',
        'sp.no_married_couple',
        'sp.no_completed_single_woman',
        'sp.created_at',
        'qtr.description'
    )->get();
     $dataRet ='';
     $no_married_couples_gtotal=0;
     $no_ongoing_single_woman_gtotal=0;
     $no_married_couple_completed_gtotal=0;
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
                <td class="text-center">'.$rowACLOne->no_married_couples.'</td>
                <td class="text-center">'.$rowACLOne->no_ongoing_single_woman.'</td>
                <td class="text-center">'.$rowACLOne->no_married_couple.'</td>
                <td class="text-center">'.$rowACLOne->no_completed_single_woman.'</td>
                <td class="text-center">'. date("d-m-Y h:i:s", strtotime($rowACLOne->created_at)).'</td>
                </tr>';
                $no_married_couples_gtotal=$no_married_couples_gtotal+$rowACLOne->no_married_couples;
                $no_ongoing_single_woman_gtotal = $no_ongoing_single_woman_gtotal+$rowACLOne->no_ongoing_single_woman;
                $no_married_couple_completed_gtotal =  $no_married_couple_completed_gtotal+$rowACLOne->no_married_couple;
                $no_completed_single_woman_gtotal = $no_completed_single_woman_gtotal+$rowACLOne->no_completed_single_woman;
                $totalClinic=$totalClinic+1;
            } 
            $dataRet .='<tr class="fw-bold" >
                            <td class="text-left fw-bold">Grand Total: </td>
                            <td class="fw-bold">'.$totalClinic.'</td>
                            <td></td>
                            <td></td>    
                            <td class="text-center font-w600 fw-bold">'.$no_married_couples_gtotal.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$no_ongoing_single_woman_gtotal.'</td>
                            <td class="text-center font-w600 fw-bold">'.$no_married_couple_completed_gtotal.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$no_completed_single_woman_gtotal.'</td>
                            <td></td>
                         </tr>';
      }else{
            $dataRet .='';
      }
     return $dataRet;
    }
    public function artClinicReportLeveltwo(Request $request){
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        } 
        $quarters = DB::table('patient_clinic_database.quarter_table')->get();
         return view('reports.clinic.art-clinic-report-level-two',compact('quarters'));
    }
    public function artClinicReportLeveltwoFilter(Request $request){
     $data=$request->all();  
     $artClinicLeveltwoList = DB::table('patient_clinic_database.summary_patient_artclinic_leveltwo as sp')
    ->join('artdumydata.clinic_registration as cr', 'sp.clinic_id', '=', 'cr.clinic_id')
    ->join('patient_clinic_database.quarter_table as qtr', 'sp.quarter', '=', 'qtr.quarter')   
    ->where('sp.year',$data['year'])
    ->where('qtr.quarter', $data['quarter'])
    ->where('cr.status', '=', '1') 
    ->select(
            'cr.state',
            'cr.registration_no',        
            'sp.name_of_clinic',
            'sp.year',
            'sp.no_married_couples',
            'sp.no_ongoing_single_woman',
            'sp.no_married_couple',
            'sp.no_completed_single_woman',
            'sp.no_using_donor_sperms',
            'sp.no_surgical_semen_completed',   
            'sp.no_self_oocyte_patient',
            'sp.no_oocyte_donor',  
            'sp.no_donor_sperm',
            'sp.no_donor_oocyte',
            'sp.created_at', 
            'sp.no_patient_oocyte_cryo',
            'sp.no_created_self_gametes', 
            'sp.no_created_one_donor_gamete', 
            'sp.no_donor_sperm_cryo',
            'sp.no_donor_oocyte_cryo',           
            'qtr.description'   
    )->get();

        $dataRet ='';
        $no_married_couples_gtotal=0;
        $no_ongoing_single_woman_gtotal=0;
        $no_married_couple_completed_gtotal=0;
        $no_completed_single_woman_gtotal=0; 
        $no_using_donor_sperms =0;  
        $no_oocyte_donor=0;
        $no_donor_sperm=0;
        $no_donor_oocyte=0;
        $no_patient_oocyte_cryo=0;
        $no_donor_sperm_cryo=0;
        $no_donor_oocyte_cryo=0;
        $totalOocyteSperm_cryo=0;
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
                                
                                <td class="text-center">'.$rowACLTwo->no_married_couples.'</td>
                                <td class="text-center">'.$rowACLTwo->no_ongoing_single_woman.'</td>
                                <td class="text-center">'.$rowACLTwo->no_married_couple.'</td>
                                <td class="text-center">'.$rowACLTwo->no_completed_single_woman.'</td>
                                <td class="text-center">'.$rowACLTwo->no_using_donor_sperms.'</td>
                                <td class="text-center">(i)'.$rowACLTwo->no_self_oocyte_patient.'<br />(ii)'.$rowACLTwo->no_oocyte_donor.'</td>
                                <td class="text-center">'.$rowACLTwo->no_donor_sperm.'</td>
                                <td class="text-center">'.$rowACLTwo->no_donor_oocyte.'</td>
                                <td class="text-center">'.$rowACLTwo->no_patient_oocyte_cryo.'</td>
                                <td class="text-center">(i)'.$rowACLTwo->no_donor_sperm_cryo.'<br />(ii)'.$rowACLTwo->no_donor_oocyte_cryo.'</td>
                                <td class="text-center">'. date("d-m-Y h:i:s", strtotime($rowACLTwo->created_at)).'</td>
                            </tr>';                      

                            $no_married_couples_gtotal=$no_married_couples_gtotal+$rowACLTwo->no_married_couples;
                            $no_ongoing_single_woman_gtotal = $no_ongoing_single_woman_gtotal+$rowACLTwo->no_ongoing_single_woman;
                            $no_married_couple_completed_gtotal =  $no_married_couple_completed_gtotal+$rowACLTwo->no_married_couple;
                            $no_completed_single_woman_gtotal = $no_completed_single_woman_gtotal+$rowACLTwo->no_completed_single_woman;
                            $no_using_donor_sperms = $no_using_donor_sperms+$rowACLTwo->no_using_donor_sperms;
                            $no_self_oocyte_patient= $no_self_oocyte_patient + $rowACLTwo->no_self_oocyte_patient;
                            $no_oocyte_donor= $no_oocyte_donor + $rowACLTwo->no_oocyte_donor;
                            $total_no_oocyte_patient_donor=$no_self_oocyte_patient +$no_oocyte_donor;
                            $no_donor_sperm= $no_donor_sperm + $rowACLTwo->no_donor_sperm;
                            $no_donor_oocyte= $no_donor_oocyte + $rowACLTwo->no_donor_oocyte;
                            $no_patient_oocyte_cryo= $no_patient_oocyte_cryo + $rowACLTwo->no_patient_oocyte_cryo;
                            $no_donor_oocyte_cryo= $no_donor_oocyte_cryo + $rowACLTwo->no_donor_oocyte_cryo;
                            $no_donor_sperm_cryo =$no_donor_sperm_cryo + $rowACLTwo->no_donor_sperm_cryo;
                            $totalOocyteSperm_cryo=$no_donor_oocyte_cryo+$no_donor_sperm_cryo;
                            $totalClinic=$totalClinic+1;
            } 
            $dataRet .='<tr class="fw-bold">
                            <td class="text-left fw-bold">Grand Total: </td>
                            <td class="fw-bold">'.$totalClinic.'</td>
                            <td></td>
                            <td></td>
                            <td class="text-center font-w600 fw-bold">'.$no_married_couples_gtotal.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$no_ongoing_single_woman_gtotal.'</td>
                            <td class="text-center font-w600 fw-bold">'.$no_married_couple_completed_gtotal.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$no_completed_single_woman_gtotal.'</td> 
                            <td  class="text-center font-w600 fw-bold">'.$no_using_donor_sperms.'</td>                         
                            <td  class="text-center font-w600 fw-bold">'.$total_no_oocyte_patient_donor.'</td> 
                            <td  class="text-center font-w600 fw-bold">'.$no_donor_sperm.'</td>  
                            <td  class="text-center font-w600 fw-bold">'.$no_donor_oocyte.'</td>   
                            <td  class="text-center font-w600 fw-bold">'.$no_patient_oocyte_cryo.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$totalOocyteSperm_cryo.'</td>
                            <td></td>
                        </tr>';
      }else{
            $dataRet .='';
      }
     return $dataRet;
    }
    public function surrogacyClinicReport(Request $request){
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        } 
        $quarters = DB::table('patient_clinic_database.quarter_table')->get();
         return view('reports.clinic.patient-surrogacy-clinics-report',compact('quarters'));
    }
    public function surrogacyClinicReportFilter(Request $request){            
            $data=$request->all();  
            $surrogacyClinicList = DB::table('patient_clinic_database.summary_patient_surrogacyclinic as sp')
            ->join('artdumydata.clinic_registration as cr', 'sp.clinic_id', '=', 'cr.clinic_id')
            ->join('patient_clinic_database.quarter_table as qtr', 'sp.quarter', '=', 'qtr.quarter')   
            ->where('sp.year',$data['year'])
            ->where('qtr.quarter', $data['quarter'])
            ->where('cr.status', '=', '1') 
            ->select(
                    'cr.state',
                    'cr.registration_no',        
                    'sp.name_of_clinic',
                    'sp.year',
                    'sp.no_married_couples',
                    'sp.no_ongoing_single_woman',
                    'sp.no_married_couple',
                    'sp.no_completed_single_woman',
                    'sp.no_surrogate_mother_ongoing',
                    'sp.no_surrogate_mother_completed',
                    'sp.no_surgical_retrival_done',
                    'sp.no_self_oocyte_patient',
                    'sp.no_oocyte_donor',
                    'sp.no_donor_oocyte',
                    'sp.no_created_using_one_donor_gamete',
                    'sp.no_patient_semen_cryopreserved',
                    'sp.no_donor_sperm',                     
                    'sp.no_patient_oocyte_cryopreserved',
                    'sp.no_donor_sperm_cryopreserved',
                    'sp.no_created_using_self_gametes',
                    'sp.no_embryos_cryopreserved',
                    'sp.no_donor_oocyte_cryopreserved',                    
                    'sp.created_at',
                    'qtr.description'    
            )->get();   // ->toSql(); ->get();die;
 
        $dataRet ='';
        $ongoing_married_couples_gtotal=0;
        $no_ongoing_single_woman_gtotal=0;
        $no_married_couple_completed_gtotal=0;
        $no_completed_single_woman_gtotal=0;      
        $no_surrogate_mother_ongoing=0;  
        $no_surrogate_mother_completed=0;
        $no_surgical_retrival_done=0;
        $no_oocyte_donor=0;
       // $no_donor_sperm=0;
       // $no_donor_oocyte=0;       
        $no_patient_oocyte_cryopreserved=0;
        $no_self_oocyte_patient=0;
        $no_created_using_one_donor_gamete=0;
        $no_donor_sperm_cryopreserved=0;
        $total_no_patient_oocyte_cryopreserved =0;
        $total_donor_sperm_cryopreserved=0;
        $no_created_using_self_gametes=0; 
         $no_patient_semen_cryopreserved =0;
          $no_embryos_cryopreserved=0;
      
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
                                <td class="text-center">'.$row->no_married_couples.'</td>
                                <td class="text-center">'.$row->no_ongoing_single_woman.'</td>

                                <td class="text-center">'.$row->no_married_couple.'</td>
                                <td class="text-center">'.$row->no_completed_single_woman.'</td>

                                <td class="text-center">'.$row->no_surrogate_mother_ongoing.'</td>
                                <td class="text-center">'.$row->no_surrogate_mother_completed.'</td>

                                <td class="text-center">'.$row->no_surgical_retrival_done.'</td>
                                <td class="text-center">(i)'.$row->no_self_oocyte_patient.' <br> (ii)'.$row->no_oocyte_donor.'</td>

                            
                                <td class="text-center">(i)'.$row->no_created_using_one_donor_gamete.'<br>(ii)'.$row->no_donor_sperm_cryopreserved.'</td>
                                <td class="text-center">(i)'.$row->no_patient_semen_cryopreserved.'<br />(ii)'.$row->no_patient_oocyte_cryopreserved.'</td>
                                
                                <td class="text-center">'.$row->no_created_using_self_gametes.'<br /></td>
                                <td class="text-center">'.$row->no_embryos_cryopreserved.'</td>
                                                           
                                <td class="text-center">'. date("d-m-Y h:i:s", strtotime($row->created_at)).'</td>
                            </tr>';

                          
                            $ongoing_married_couples_gtotal=$ongoing_married_couples_gtotal+$row->no_married_couples;

                            $no_ongoing_single_woman_gtotal = $no_ongoing_single_woman_gtotal+$row->no_ongoing_single_woman;

                            $no_married_couple_completed_gtotal =  $no_married_couple_completed_gtotal+$row->no_married_couple;

                            $no_completed_single_woman_gtotal = $no_completed_single_woman_gtotal+$row->no_completed_single_woman;
                            
                            $no_surrogate_mother_ongoing = $no_surrogate_mother_ongoing + $row->no_surrogate_mother_ongoing;
                            $no_surrogate_mother_completed=$no_surrogate_mother_completed +$row->no_surrogate_mother_completed;
                            $no_surgical_retrival_done=$no_surgical_retrival_done + $row->no_surgical_retrival_done;
                            $no_self_oocyte_patient= $no_self_oocyte_patient + $row->no_self_oocyte_patient; 

                            $no_oocyte_donor= $no_oocyte_donor + $row->no_oocyte_donor;                            
                            $total_no_oocyte_patient_donor=$no_self_oocyte_patient + $no_oocyte_donor;

                            $no_created_using_one_donor_gamete = $no_created_using_one_donor_gamete+ $row->no_created_using_one_donor_gamete ;
                            $no_donor_sperm_cryopreserved = $no_donor_sperm_cryopreserved+ $row->no_donor_sperm_cryopreserved;
                            $total_donor_sperm_cryopreserved = $no_created_using_one_donor_gamete + $no_donor_sperm_cryopreserved ; 

                            $no_patient_semen_cryopreserved = $no_patient_semen_cryopreserved+ $row->no_patient_semen_cryopreserved;
                            $no_patient_oocyte_cryopreserved = $no_patient_oocyte_cryopreserved + $row->no_patient_oocyte_cryopreserved;
                            $total_no_patient_oocyte_cryopreserved= $no_patient_oocyte_cryopreserved + $no_patient_semen_cryopreserved;

                           // $no_donor_sperm= $no_donor_sperm + $row->no_donor_sperm;
                            //$no_donor_oocyte= $no_donor_oocyte + $row->no_donor_oocyte; 

                            $no_created_using_self_gametes=$row->no_created_using_self_gametes;
                            $no_embryos_cryopreserved=$no_embryos_cryopreserved+$row->no_embryos_cryopreserved;
                            $totalClinic=$totalClinic+1;
            } 
            $dataRet .='<tr>
                            <td  class="text-left font-w600 fw-bold">Grand Total: </td>
                            <td class="fw-bold">'.$totalClinic.'</td>
                            <td></td>
                            <td></td>
                            <td class="text-center font-w600 fw-bold">'.$ongoing_married_couples_gtotal.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$no_ongoing_single_woman_gtotal.'</td>
                            <td class="text-center font-w600 fw-bold">'.$no_married_couple_completed_gtotal.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$no_completed_single_woman_gtotal.'</td> 
                            <td  class="text-center font-w600 fw-bold">'.$no_surrogate_mother_ongoing.'</td> 
                            <td  class="text-center font-w600 fw-bold">'.$no_surrogate_mother_completed.'</td> 
                            <td  class="text-center font-w600 fw-bold">'.$no_surgical_retrival_done.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$total_no_oocyte_patient_donor. '</td>                         
                            <td  class="text-center font-w600 fw-bold">'.$total_donor_sperm_cryopreserved.'</td> 
                            <td  class="text-center font-w600 fw-bold">'.$total_no_patient_oocyte_cryopreserved.'</td>  
                            <td  class="text-center font-w600 fw-bold">'.$no_created_using_self_gametes.'</td> 
                            <td  class="text-center font-w600 fw-bold">'.$no_embryos_cryopreserved.'</td> 
                            <td></td>                           
                        </tr>';
      }else{
            $dataRet .='';
      }
     return $dataRet;
    }
    // artbankClinicReportFilter
        public function artbankClinicReport(Request $request){
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        } 
        $quarters = DB::table('patient_clinic_database.quarter_table')->get();
         return view('reports.clinic.patient-art-bank-report',compact('quarters'));
    }
    public function artbankClinicReportFilter(Request $request){   
        // dd($request->all());
         $data=$request->all();  
      $artBankClinicReportList = DB::table('patient_clinic_database.summary_patient_bank as sp')
    ->join('artdumydata.clinic_registration as cr', 'sp.clinic_id', '=', 'cr.clinic_id')
    ->join('patient_clinic_database.quarter_table as qtr', 'sp.quarter', '=', 'qtr.quarter')   
    ->where('sp.year',$data['year'])
    ->where('qtr.quarter', $data['quarter'])
    ->where('cr.status', '=', '1') 
    ->select(
            'cr.state',
            'cr.registration_no',        
            'sp.name_of_bank',
            'sp.year',
            'sp.no_oocyte_donors_screened',
            'sp.no_semen_donors_screened',
            'sp.no_oocyte_cryo',
            'sp.no_donor_oocyte',
            'sp.no_donor_surro',
            'sp.no_patient_semen_cryo',
            'sp.no_donor_semen_cryo',
            'sp.no_donor_semen_surrogacy',
            'sp.no_patient_semen_artclinic',
            'sp.no_patient_own_semen_sclinic',
            'sp.no_donor_semen_art',
            'sp.created_at',               
            'qtr.description'   
    )->get();    //toSql(); //get();

        $dataRet ='';
        $no_oocyte_donors_screened_gtotal=0;
        $no_semen_donors_screened_gtotal=0;      
        $no_oocyte_cryo_patient_gtotal=0;         
        $no_oocyte_cryo_gtotal=0;        
        $no_donor_oocyte_gtotal =0;
        $no_donor_surro_gtotal=0;
        $no_patient_semen_cryo_gtotal=0;
        $no_donor_semen_cry_gtotal=0;
        $no_patient_semen_artclinic_gtotal=0; 
        $no_donor_semen_art_gtotal=0;
        $no_donor_semen_surrogacy_gtotal=0;
        $no_patient_own_semen_sclinic_gtotal=0;   
      
      if(count($artBankClinicReportList)>0){
         // echo count($artBankClinicReportList);die;
            $sn=1;
            $totalClinic=0;
           
            foreach($artBankClinicReportList AS $row){           
                $dataRet .='<tr>
                                <td>'. $sn++.'</td>
                                <td>'.$row->name_of_bank.'</td>
                                <td>'.$row->registration_no.'</td>
                                <td>'.$row->state.'</td>  
                                <td class="text-center">'.$row->no_oocyte_donors_screened.'</td>
                                <td class="text-center">'.$row->no_semen_donors_screened.'</td>
                                <td class="text-center"></td>
                                <td class="text-center">'.$row->no_oocyte_cryo.'</td>

                                <td class="text-center">'.$row->no_donor_oocyte.'</td>
                                <td class="text-center">'.$row->no_donor_surro.'</td>

                                <td class="text-center">'.$row->no_patient_semen_cryo.'</td>

                                <td class="text-center">'.$row->no_donor_semen_cryo.'</td>

                                 <td class="text-center">(i) '.$row->no_patient_semen_artclinic .' (ii) '.$row->no_patient_own_semen_sclinic.'</td>
                                 <td class="text-center">(i) '.$row->no_donor_semen_art .' (ii) '.$row->no_donor_semen_surrogacy.'</td>
   	                             <td class="text-center">'. date("d-m-Y h:i:s", strtotime($row->created_at)).'</td>
                           
                                 </tr>';
                            /* <td class="text-left font-w600">Grand Total: </td>
                            <td>'.$totalClinic.'</td>
                            <td></td>
                            <td></td>
                            <td class="text-center font-w600">'.$no_oocyte_donors_screened_gtotal.'</td>
                            <td  class="text-center font-w600">'.$no_semen_donors_screened_gtotal.'</td>

                            <td class="text-center font-w600">'.$no_oocyte_cryo_patient_gtotal.'</td>
                            <td  class="text-center font-w600">'. $no_oocyte_cryo_gtotal.'</td> 

                            <td  class="text-center font-w600">'.$no_donor_oocyte_gtotal.'</td>
                            <td  class="text-center font-w600">'.$no_donor_surro_gtotal.'</td>

                            <td  class="text-center font-w600">'.$no_patient_semen_cryo_gtotal.'</td> 
                            <td  class="text-center font-w600">'.$no_donor_semen_cry_gtotal.'</td>   

                            <td  class="text-center font-w600">(i)'. $no_patient_semen_artclinic_gtotal.'(ii)'.$no_patient_own_semen_sclinic_gtotal.'</td>
                            <td  class="text-center font-w600">(i)'.$no_donor_semen_art_gtotal.'(ii)'.$no_donor_semen_surrogacy_gtotal.'</td>
                              <td></td>
   	                */
 
                            $no_oocyte_donors_screened_gtotal=$no_oocyte_donors_screened_gtotal+$row->no_oocyte_donors_screened;
                            $no_semen_donors_screened_gtotal = $no_semen_donors_screened_gtotal+$row->no_semen_donors_screened;
                            $no_oocyte_cryo_patient_gtotal = $no_oocyte_cryo_patient_gtotal;
                            $no_oocyte_cryo_gtotal= $no_oocyte_cryo_gtotal+$row->no_oocyte_cryo;
                            $no_donor_oocyte_gtotal=$no_donor_oocyte_gtotal+$row->no_donor_oocyte;
                            $no_donor_surro_gtotal= $no_donor_surro_gtotal + $row->no_donor_surro;
                            $no_patient_semen_cryo_gtotal=$no_patient_semen_cryo_gtotal +$row->no_patient_semen_cryo;
                            $no_donor_semen_cry_gtotal = $no_donor_semen_cry_gtotal+$row->no_donor_semen_cryo;
                            $no_patient_semen_artclinic_gtotal=$no_patient_semen_artclinic_gtotal+$row->no_patient_semen_artclinic ;
                            $no_patient_own_semen_sclinic_gtotal = $no_patient_own_semen_sclinic_gtotal+$row->no_patient_own_semen_sclinic;  
                            $no_donor_semen_art_gtotal=$no_donor_semen_art_gtotal+$row->no_donor_semen_art;
                            $no_donor_semen_surrogacy_gtotal=$no_donor_semen_surrogacy_gtotal+$row->no_donor_semen_surrogacy;             
                         
                            $totalClinic=$totalClinic+1;
            } 
            $dataRet .='<tr>
                            <td class="text-left font-w600 fw-bold">Grand Total: </td>
                            <td class="fw-bold">'.$totalClinic.'</td>
                            <td></td>
                            <td></td>
                            <td class="text-center font-w600 fw-bold">'.$no_oocyte_donors_screened_gtotal.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$no_semen_donors_screened_gtotal.'</td>

                            <td class="text-center font-w600 fw-bold">'.$no_oocyte_cryo_patient_gtotal.'</td>
                            <td  class="text-center font-w600 fw-bold">'. $no_oocyte_cryo_gtotal.'</td> 

                            <td  class="text-center font-w600 fw-bold">'.$no_donor_oocyte_gtotal.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$no_donor_surro_gtotal.'</td>

                            <td  class="text-center font-w600 fw-bold">'.$no_patient_semen_cryo_gtotal.'</td> 
                            <td  class="text-center font-w600 fw-bold">'.$no_donor_semen_cry_gtotal.'</td>   

                            <td  class="text-center font-w600 fw-bold">'. $no_patient_semen_artclinic_gtotal+$no_patient_own_semen_sclinic_gtotal.'</td>
                            <td  class="text-center font-w600 fw-bold">'.$no_donor_semen_art_gtotal+$no_donor_semen_surrogacy_gtotal.'</td>
                            <td></td>
                        </tr>';
      }else{
            $dataRet .='';
      }
     return $dataRet;
    }
    public function levelOneartclinicPdf(Request $request){  

    // print_r($request->all());die;
     $data=$request->all();
              $artClinicLeveloneList = DB::table('patient_clinic_database.summary_patient_artclinic_levelone as sp')
    ->join('artdumydata.clinic_registration as cr', 'sp.clinic_id', '=', 'cr.clinic_id')
    ->join('patient_clinic_database.quarter_table as qtr', 'sp.quarter', '=', 'qtr.quarter')   
    ->where('sp.year',$data['year'])
    ->where('qtr.quarter', $data['quarter'])
    ->where('cr.status', '=', '1') 
    ->select(
        'cr.state',
        'cr.registration_no',        
        'sp.name_of_clinic',
        'sp.year',
        'sp.no_married_couples',
        'sp.no_ongoing_single_woman',
        'sp.no_married_couple',
        'sp.no_completed_single_woman',
        'sp.created_at',
        'qtr.description'
    )->get();       

        $pdf = Pdf::loadView('reports.clinic.patient-art-clinic-pdf',compact('artClinicLeveloneList'))->setOptions([
                'isRemoteEnabled' => true, 
            ]);
             
     
        return $pdf->download('patient_art_clinic_pdf.pdf');
    } 
    

 
 
    
}
