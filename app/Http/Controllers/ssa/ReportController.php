<?php

namespace App\Http\Controllers\ssa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\patient\QuarterTable;
use App\Models\clinic\ClinicRegistrationModel;
use App\Models\patient\PatientPeriodReportingTable;



class ReportController extends Controller
{
    protected string $db1;
    protected string $db2;

    public function __construct()
    {
    // Always use config(), not env()
        $this->db1 = config('database.connections.artregistry.database');
        $this->db2 = config('database.connections.patient_clinic_database.database');
    }
    public function clinic_report_one_form(){
        return view('reports.clinic.report-form-level-one');
    }
    public function clinic_report_level_one(Request $request) 
    {
        $artDbName = DB::connection(config('database.default'))->getDatabaseName(); 
        $data = $request->all();
        $year = $data['year'];

        $quarter = QuarterTable::where('quarter',$data['quarter'])->first();
        $quarter_desc = !empty($quarter) ? $quarter->description : '';


          $patient = DB::table($this->db2.'.patient_artclinic as p')
            ->join(DB::raw($this->db2.'.patient_period_reporting_table as r'), function ($join) {
                $join->on('r.id', '=', 'p.reporting_id')
                    ->where('r.status', '=', 'Finished');
            })
            ->join(DB::raw('(SELECT DISTINCT clinic_id, name, registration_no, state, address,level
                                FROM '.$this->db1.'.clinic_registration
                                WHERE status = 1 ) as c'), function ($join) {
                $join->on(DB::raw('c.clinic_id COLLATE utf8mb4_unicode_ci'), '=', DB::raw('p.clinic_id COLLATE utf8mb4_unicode_ci'));
            })

            // ->join(DB::raw($this->db2.'quarter_table as q'), 'q.quarter', '=', 'p.quarter')

            ->join($this->db2.'.quarter_table as q', function($join) use ($data) {
            $join->on('p.quarter', '=', 'q.quarter');
            // Apply only if NOT "All"
            if (!empty($data['quarter']) && $data['quarter'] != 'All') {
                $join->where('q.quarter', '=', $data['quarter']);
            }
        })
        ->where('p.year', $data['year']);
           $patient_list = $patient->select(
                'c.name as clinic_name',
                'c.registration_no',
                'c.state',
                'c.address as clinic_address',
                DB::raw("
                    SUM(CASE WHEN p.case_of = 'one' THEN 1 ELSE 0 END) AS married_couple_count,
                    SUM(CASE WHEN p.case_of = 'two' THEN 1 ELSE 0 END) AS single_women_count,
                    SUM(CASE WHEN p.male_factor = 'Y' THEN 1 ELSE 0 END) AS male_factor,
                    SUM(CASE WHEN p.female_factor = 'Y' THEN 1 ELSE 0 END) AS female_factor,
                    SUM(CASE WHEN p.unexplained = 'Y' THEN 1 ELSE 0 END) AS unexplained,
                    SUM(CASE WHEN p.treat_outcomes = 'Pregnant' THEN 1 ELSE 0 END) AS success_pregnant,
                    SUM(CASE WHEN p.treat_outcomes = 'Not Pregnant' THEN 1 ELSE 0 END) AS failed_pregnant,
                    SUM(CASE WHEN p.preganancy_outcome = 'live birth' THEN 1 ELSE 0 END) AS live_birth,
                    SUM(CASE WHEN p.preganancy_outcome = 'Stillbirth' THEN 1 ELSE 0 END) AS still_birth,
                    SUM(CASE WHEN p.preganancy_outcome = 'Spontaneous abortion' THEN 1 ELSE 0 END) AS spontaneous_aboration,
                    SUM(CASE WHEN p.preganancy_outcome = 'Therapeutic abortion' THEN 1 ELSE 0 END) AS therapeutic_aboration,
                    SUM(CASE WHEN p.preganancy_outcome = 'Elective termination' THEN 1 ELSE 0 END) AS elective_termination,
                    SUM(CASE WHEN p.l_birth = 'Singleton' THEN 1 ELSE 0 END) AS singleton,
                    SUM(CASE WHEN p.l_birth = 'Twin' THEN 1 ELSE 0 END) AS twin,
                    SUM(CASE WHEN p.l_birth = 'Higher Order' THEN 1 ELSE 0 END) AS higher_order,
                    SUM(CASE WHEN p.gender_child = 'Male' THEN 1 ELSE 0 END) AS male,
                    SUM(CASE WHEN p.gender_child = 'Female' THEN 1 ELSE 0 END) AS female,
                    SUM(CASE 
                        WHEN p.art_proc_undertaken = 'intra-uterine insemination(IUI)' 
                        AND p.types_of_treat = 'ART Treatment using own gametes(Self Egg and Self Sperm)'
                        THEN 1 ELSE 0 
                    END) AS iui_h_count,
                    SUM(CASE 
                        WHEN p.art_proc_undertaken = 'intra-uterine insemination(IUI)' 
                        AND p.types_of_treat = 'ART Treatment using donor gametes'
                        THEN 1 ELSE 0 
                    END) AS iui_d_count,
                    SUM(p.total_num_of_cyc) AS total_num_of_cyc_undertaking,
                    SUM(p.cyc_canc_failure_reason) AS cyc_canc_failure_reason"
                    )
            )
            ->where('c.level', '=', 'Level-1')
            ->when(Session::get('user_type') == 5 && Session::get('state_name'),function ($query) {
                $query->where('c.state', Session::get('state_name'));
            })
            // ->where('p.year', '=', $year)
            // ->where('p.quarter', '=', $quarter)
            ->groupBy('c.clinic_id', 'c.name', 'c.registration_no', 'c.state', 'c.address')
            ->orderBy('c.name')
            ->get();    
        return view('reports.clinic.clinic-report-gd-level-one',compact('patient_list','year','quarter_desc')); 
        // $html = view('reports.clinic.clinic-report-gd-level-one', compact('patient_list','year','quarter_desc'))->render();
        // return response()->json([
        //     'html' => $html
        // ]);
    }


    public function clinic_report_level_two_form(){
        return view('reports.clinic.report-form-level-two');
    }
    public function clinic_report_level_two(Request $request) 
    {
        $data = $request->all();
        $year = $data['year'];
        // $quarter = $data['quarter'];
        // $quarter_desc = QuarterTable::where('quarter',$quarter)->first()->description;

        // $patient = DB::connection('patient_clinic_database')
        //     ->table('patient_clinic_database.patient_artclinic as p')
        //     ->join(DB::raw('patient_clinic_database.patient_period_reporting_table as r'), function ($join) {
        //         $join->on('r.id', '=', 'p.reporting_id')
        //             ->where('r.status', '=', 'Finished');
        //     })
        //     ->join(DB::raw('(SELECT DISTINCT clinic_id, name, registration_no, state, address,level
        //                         FROM art_dbnew_testing.clinic_registration
        //                         WHERE status = 1) as c'), function ($join) {
        //         $join->on(DB::raw('c.clinic_id COLLATE utf8mb4_unicode_ci'), '=', DB::raw('p.clinic_id COLLATE utf8mb4_unicode_ci'));
        //     })
        //     ->join(DB::raw('patient_clinic_database.quarter_table as q'), 'q.quarter', '=', 'p.quarter');
        $quarter = QuarterTable::where('quarter',$data['quarter'])->first();
        $quarter_desc = !empty($quarter) ? $quarter->description : '';


          $patient = DB::table($this->db2.'.patient_artclinic as p')
            ->join(DB::raw($this->db2.'.patient_period_reporting_table as r'), function ($join) {
                $join->on('r.id', '=', 'p.reporting_id')
                    ->where('r.status', '=', 'Finished');
            })
            ->join(DB::raw('(SELECT DISTINCT clinic_id, name, registration_no, state, address,level
                                FROM '.$this->db1.'.clinic_registration
                                WHERE status = 1) as c'), function ($join) {
                $join->on(DB::raw('c.clinic_id COLLATE utf8mb4_unicode_ci'), '=', DB::raw('p.clinic_id COLLATE utf8mb4_unicode_ci'));
            })
            // ->join(DB::raw($this->db2.'quarter_table as q'), 'q.quarter', '=', 'p.quarter')

            ->join($this->db2.'.quarter_table as q', function($join) use ($data) {
            $join->on('p.quarter', '=', 'q.quarter');
            // Apply only if NOT "All"
            if (!empty($data['quarter']) && $data['quarter'] != 'All') {
                $join->where('q.quarter', '=', $data['quarter']);
            }
        })
        ->where('p.year', $data['year']);
            $patient_list = $patient->select(
                'c.name as clinic_name',
                'c.registration_no',
                'c.state',
                'c.address as clinic_address',
                DB::raw("
                    SUM(CASE WHEN p.case_of = 'one' THEN 1 ELSE 0 END) AS married_couple_count,
                    SUM(CASE WHEN p.case_of = 'two' THEN 1 ELSE 0 END) AS single_women_count,
                    SUM(CASE WHEN p.male_factor = 'Y' THEN 1 ELSE 0 END) AS male_factor,
                    SUM(CASE WHEN p.female_factor = 'Y' THEN 1 ELSE 0 END) AS female_factor,
                    SUM(CASE WHEN p.unexplained = 'Y' THEN 1 ELSE 0 END) AS unexplained,
                    SUM(CASE WHEN p.treat_outcomes = 'Pregnant' THEN 1 ELSE 0 END) AS success_pregnant,
                    SUM(CASE WHEN p.treat_outcomes = 'Not Pregnant' THEN 1 ELSE 0 END) AS failed_pregnant,
                    SUM(CASE WHEN p.preganancy_outcome = 'live birth' THEN 1 ELSE 0 END) AS live_birth,
                    SUM(CASE WHEN p.preganancy_outcome = 'Stillbirth' THEN 1 ELSE 0 END) AS still_birth,
                    SUM(CASE WHEN p.preganancy_outcome = 'Spontaneous abortion' THEN 1 ELSE 0 END) AS spontaneous_aboration,
                    SUM(CASE WHEN p.preganancy_outcome = 'Elective termination' THEN 1 ELSE 0 END) AS elective_termination,
                    SUM(CASE WHEN p.preganancy_outcome = 'Therapeutic abortion' THEN 1 ELSE 0 END) AS therapeutic_aboration,
                    SUM(CASE WHEN p.l_birth = 'Singleton' THEN 1 ELSE 0 END) AS singleton,
                    SUM(CASE WHEN p.l_birth = 'Twin' THEN 1 ELSE 0 END) AS twin,
                    SUM(CASE WHEN p.l_birth = 'Higher Order' THEN 1 ELSE 0 END) AS higher_order,
                    SUM(CASE WHEN p.gender_child = 'Male' THEN 1 ELSE 0 END) AS male,
                    SUM(CASE WHEN p.gender_child = 'Female' THEN 1 ELSE 0 END) AS female,
                    SUM(CASE WHEN p.types_of_treat = 'ART Treatment using own gametes(Self Egg and Self Sperm)' THEN 1 ELSE 0 END) AS self_gametes,

                    SUM(CASE 
                        WHEN p.types_of_treat = 'ART Treatment using donor gametes'
                        AND p.types_of_treat1 = 'Oocyte Donation'
                        THEN 1 ELSE 0 
                    END) AS oocyte_donor,
                    SUM(CASE 
                        WHEN p.types_of_treat = 'ART Treatment using donor gametes'
                        AND p.types_of_treat1 = 'Sperm Donation'
                        THEN 1 ELSE 0 
                    END) AS sperm_donor,
                    SUM(CASE 
                        WHEN p.types_of_treat = 'ART Treatment using donor gametes'
                        AND p.types_of_treat1 = 'Both Oocyte Donation & Sperm Donation'
                        THEN 1 ELSE 0 
                    END) AS both_donor,
                    
                    
                    
                    SUM(CASE WHEN p.art_proc_undertaken = 'artificial insemination' THEN 1 ELSE 0 END) AS artificial_insemination,
                    SUM(CASE WHEN p.art_proc_undertaken = 'intra-uterine insemination(IUI)' THEN 1 ELSE 0 END) AS iui,
                    SUM(CASE WHEN p.art_proc_undertaken = 'in vitro fertilization-embryo transfer' THEN 1 ELSE 0 END) AS ivfet,
                    SUM(CASE WHEN p.art_proc_undertaken = 'gamete intrafallopian tube transfer' THEN 1 ELSE 0 END) AS gitt,
                    SUM(CASE WHEN p.art_proc_undertaken = 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)' THEN 1 ELSE 0 END) AS icsi,
                    SUM(CASE WHEN p.art_proc_undertaken = 'physiological Intra-cytoplasmic sperm injection' THEN 1 ELSE 0 END) AS picsi,
                    SUM(CASE WHEN p.art_proc_undertaken = 'intra-cytoplasmic morphologically selected sperm injection' THEN 1 ELSE 0 END) AS icmssi,
                    SUM(CASE WHEN p.art_proc_undertaken = 'round spermatid nucleus injection' THEN 1 ELSE 0 END) AS rsni,
                    SUM(CASE WHEN p.art_proc_undertaken = 'Elongated spermatid injection' THEN 1 ELSE 0 END) AS esi,
                    SUM(CASE WHEN p.art_proc_undertaken = 'other' THEN 1 ELSE 0 END) AS other,

                    SUM(p.total_num_of_cyc) AS total_num_of_cyc_undertaking,
                    SUM(p.cyc_canc_failure_reason) AS cyc_canc_failure_reason"
                    )
            )
            ->where('c.level', '=', 'Level-2')
            ->when(Session::get('user_type') == 5 && Session::get('state_name'),function ($query) {
                $query->where('c.state', Session::get('state_name'));
            })
            // ->where('p.year', '=', $year)
            // ->where('p.quarter', '=', $quarter)
            ->groupBy('c.clinic_id', 'c.name', 'c.registration_no', 'c.state', 'c.address')
            ->orderBy('c.name')
            ->get();
        // dd($patient_list);
                            
        return view('reports.clinic.clinic-report-level-two',compact('patient_list','year','quarter_desc')); 
    }

    public function surrogacy_clinic_report() {
        $quarters = DB::table($this->db2. '.quarter_table')->get();
        return view('reports.clinic.surrogacy-clinic-report-form',compact('quarters'));
    }


    public function surrogacy_clinic_report_gd(Request $request) 
    {
        $data = $request->all();
        $year = $data['year'];
        $quarter = QuarterTable::where('quarter',$data['quarter'])->first();
        $quarter_desc = $quarter ? $quarter->description : null; 

        $patient = DB::table($this->db2.'.patient_surrogacyclinic as p')
            ->join(DB::raw($this->db2.'.patient_period_reporting_table as r'), function ($join) {
                $join->on('r.id', '=', 'p.reporting_id')
                    ->where('r.status', '=', 'Finished')
                    ->where('p.treatment_type', '=', 'surrogacy');
            })
            ->join(DB::raw('(SELECT DISTINCT clinic_id, name, registration_no, state, address,level
                                FROM '.$this->db1.'.clinic_registration
                                WHERE status = 1) as c'), function ($join) {
                $join->on(DB::raw('c.clinic_id COLLATE utf8mb4_unicode_ci'), '=', DB::raw('p.clinic_id COLLATE utf8mb4_unicode_ci'));
            })
            // ->join(DB::raw($this->db2.'quarter_table as q'), 'q.quarter', '=', 'p.quarter')

            ->join($this->db2.'.quarter_table as q', function($join) use ($data) {
            $join->on('p.quarter', '=', 'q.quarter');
            // Apply only if NOT "All"
            if (!empty($data['quarter']) && $data['quarter'] != 'All') {
            $join->where('q.quarter', '=', $data['quarter']);
            }
        })
        ->where('p.year', $data['year']);
        //check quarter empty or all selected
            
            $patient_list = $patient->select(
                'c.name as clinic_name',
                'c.registration_no',
                'c.state',
                // 'c.address as clinic_address',
                DB::raw("
                    SUM(CASE WHEN p.case_of = 'one' THEN 1 ELSE 0 END) AS married_couple_count,
                    SUM(CASE WHEN p.case_of = 'two' THEN 1 ELSE 0 END) AS single_women_count,
                    SUM(CASE WHEN p.nationality = 'Indian' THEN 1 ELSE 0 END) AS indian,
                    SUM(CASE WHEN p.nationality = 'OCI Card Holders' THEN 1 ELSE 0 END) AS oci_card,
                    SUM(CASE WHEN p.male_factor = 'Y' THEN 1 ELSE 0 END) AS male_factor,
                    SUM(CASE WHEN p.uterus_ab = 'Y' THEN 1 ELSE 0 END) AS uterus_ab,
                    SUM(CASE WHEN p.ivf_failure = 'Y' THEN 1 ELSE 0 END) AS ivf_failure,
                    SUM(CASE WHEN p.preg_loss = 'Y' THEN 1 ELSE 0 END) AS preg_loss,
                    SUM(CASE WHEN p.life_threat = 'Y' THEN 1 ELSE 0 END) AS life_threat,

                    SUM(CASE WHEN p.num_pre_child = 'Y' THEN 1 ELSE 0 END) AS sur_yes,
                    SUM(CASE WHEN p.num_pre_child = 'N' THEN 1 ELSE 0 END) AS sur_no,
                    SUM(CASE WHEN p.types_of_treat = 'Surrogacy using own gametes(Self Egg and Self Sperm)' THEN 1 ELSE 0 END) AS self_gametes,
                    SUM(CASE WHEN p.types_of_treat = 'Surrogacy using donor gametes' AND p.types_of_treat1 = 'Self Oocyte & Donor Sperm' THEN 1 ELSE 0 END) AS self_oocyte,
                    SUM(CASE WHEN p.types_of_treat = 'Surrogacy using donor gametes' AND p.types_of_treat1 = 'Donor Oocyte & Self Sperm' THEN 1 ELSE 0 END) AS donor_oocyte,
                    SUM(CASE WHEN p.art_undertaken = 'in vitro fertilization-embryo transfer' THEN 1 ELSE 0 END) AS ivfet,
                    SUM(CASE WHEN p.art_undertaken = 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)' THEN 1 ELSE 0 END) AS icsi,
                    SUM(CASE WHEN p.art_undertaken = 'other' THEN 1 ELSE 0 END) AS other,

                    SUM(CASE WHEN p.tratment_Outcome = 'Pregnant' THEN 1 ELSE 0 END) AS success_pregnant,
                    SUM(CASE WHEN p.tratment_Outcome = 'Not Pregnant' THEN 1 ELSE 0 END) AS failed_pregnant, 
                    SUM(CASE WHEN p.preganancy_outcome = 'live birth' THEN 1 ELSE 0 END) AS live_birth,
                    SUM(CASE WHEN p.preganancy_outcome = 'Stillbirth' THEN 1 ELSE 0 END) AS still_birth,
                    SUM(CASE WHEN p.preganancy_outcome = 'Therapeutic abortion' THEN 1 ELSE 0 END) AS therapeutic_aboration,
                    SUM(CASE WHEN p.preganancy_outcome = 'Spontaneous abortion' THEN 1 ELSE 0 END) AS spontaneous_aboration,
                    SUM(CASE WHEN p.preganancy_outcome = 'Elective Termination' THEN 1 ELSE 0 END) AS elective_termination,
                    SUM(CASE WHEN p.l_birth = 'Singleton' THEN 1 ELSE 0 END) AS singleton,
                    SUM(CASE WHEN p.l_birth = 'Twin' THEN 1 ELSE 0 END) AS twin,
                    SUM(CASE WHEN p.l_birth = 'Higher Order' THEN 1 ELSE 0 END) AS higher_order,
                    SUM(CASE WHEN p.gender_child = 'Male' THEN 1 ELSE 0 END) AS male,
                    SUM(CASE WHEN p.l_birth = 'Female' THEN 1 ELSE 0 END) AS female,

                    
                    

                    
                    
                       
                    SUM(p.total_nun_cycles) AS total_nun_cycles,
                    SUM(p.no_cycles) AS cyc_canc_failure_reason"
                    )
            )
            ->when(Session::get('user_type') == 5 && Session::get('state_name'),function ($query) {
                $query->where('c.state', Session::get('state_name'));
            })
            // ->where('p.year', '=', $year)
            // ->where('p.quarter', '=', $quarter)
            ->groupBy('c.clinic_id', 'c.name', 'c.registration_no', 'c.state', 'c.address')
            ->orderBy('c.name')
            ->get();
        // dd($patient_list);
            // return response()->json(['patient_list' => $patient_list , 'quarteryear'=>$quarter_desc." ".$data['year']]);           
        return view('reports.clinic.surrogacy-clinic-report',compact('patient_list','year','quarter_desc')); 
    }

    public function bank_clinic_report() {
        return view('reports.clinic.bank-report-form');
    }

    public function bank_clinic_report_ajax(Request $request) 
    {
        $data = $request->all();
        $year = $data['year'];
        $quarter  = QuarterTable::where('quarter',$data['quarter'])->first();
        $quarter_desc = $quarter ? $quarter->description : '';

        $patient = DB::table($this->db2.'.patient_artbank as p')
            ->join(DB::raw($this->db2.'.patient_period_reporting_table as r'), function ($join) {
                $join->on('r.id', '=', 'p.reporting_id')
                    ->where('r.status', '=', 'Finished');
            })
            ->join(DB::raw('(SELECT DISTINCT clinic_id, name, registration_no, state, address,level
                                FROM '.$this->db1.'.clinic_registration
                                WHERE status = 1) as c'), function ($join) {
                $join->on(DB::raw('c.clinic_id COLLATE utf8mb4_unicode_ci'), '=', DB::raw('p.clinic_id COLLATE utf8mb4_unicode_ci'));
            })
             ->join($this->db2.'.quarter_table as q', function($join) use ($data) {
            $join->on('p.quarter', '=', 'q.quarter');
            // Apply only if NOT "All"
            if (!empty($data['quarter']) && $data['quarter'] != 'All') {
            $join->where('q.quarter', '=', $data['quarter']);
            }
        })
        ->where('p.year', $data['year']);

           $patient_list  = $patient->select(
                'c.name as clinic_name',
                'c.registration_no',
                'c.state',
                'c.address as clinic_address',
                DB::raw("
                    SUM(CASE WHEN p.gender_donor = 'Male' AND p.marital_status = 'Married' THEN 1 ELSE 0 END) AS semen_married,
                    SUM(CASE WHEN p.gender_donor = 'Male' AND p.marital_status = 'Single' THEN 1 ELSE 0 END) AS semen_single,

                    SUM(CASE WHEN p.gender_donor = 'Female' AND p.marital_status = 'Married' THEN 1 ELSE 0 END) AS oocyte_married,
                    SUM(CASE WHEN p.gender_donor = 'Female' AND p.marital_status = 'Single' THEN 1 ELSE 0 END) AS oocyte_single,

                    SUM(CASE WHEN p.gender_donor = 'Male' THEN 1 ELSE 0 END) AS male,
                    SUM(CASE WHEN p.gender_donor = 'Female' THEN 1 ELSE 0 END) AS female,

                    SUM(CASE WHEN p.gender_donor = 'Male' AND p.nationality = 'Indian' THEN COALESCE(p.gamete_details, 0) ELSE 0 END) AS indian_semen,
                    SUM(CASE WHEN p.gender_donor = 'Female' AND p.nationality = 'Indian' THEN COALESCE(p.gamete_details, 0) ELSE 0 END) AS indian_oocyte,
                    SUM(CASE WHEN p.gender_donor = 'Male' AND p.nationality = 'Foreigner' THEN COALESCE(p.gamete_details, 0) ELSE 0 END) AS foreign_semen,
                    SUM(CASE WHEN p.gender_donor = 'Female'  AND p.nationality = 'Foreigner' THEN COALESCE(p.gamete_details, 0) ELSE 0 END) AS foreign_oocyte,
                    SUM(CASE WHEN p.gender_donor = 'Male' THEN COALESCE(p.gamete_details, 0) ELSE 0 END) AS semen_samples,
                    SUM(CASE WHEN p.gender_donor = 'Female' THEN COALESCE(p.gamete_details, 0) ELSE 0 END) AS oocyte_samples
                    ")
            )
            ->when(Session::get('user_type') == 5 && Session::get('state_name'),function ($query) {
                $query->where('c.state', Session::get('state_name'));
            })
            // ->where('p.year', '=', $year)
            // ->where('p.quarter', '=', $quarter)
            ->groupBy('c.clinic_id', 'c.name', 'c.registration_no', 'c.state', 'c.address')
            ->orderBy('c.name')
            ->get();
        // dd($patient_list);
                            
        return view('reports.clinic.bank-report-ajax',compact('patient_list','year','quarter_desc')); 
    }

    // public function patient_detail_consolidated(Request $request)
    // {
    //     $typeClinics = ['ARTCLINIC', 'ARTBANK', 'ARTSURROGACY'];

    //     $year = $request->get('year', now()->year);

    //     $clinicCounts = ClinicRegistrationModel::query()
    //         ->where('status', 1)
    //         ->whereIn('clinic_type', $typeClinics)
    //         ->selectRaw('clinic_type, COUNT(*) as total')
    //         ->groupBy('clinic_type')
    //         ->pluck('total', 'clinic_type');

    //     $finalizedCounts = PatientPeriodReportingTable::query()
    //         ->whereIn('type_clinic', $typeClinics)
    //         ->selectRaw('type_clinic, COUNT(DISTINCT clinic_id) as total')
    //         ->groupBy('type_clinic')
    //         ->pluck('total', 'type_clinic');

    //     $rowsQuery = PatientPeriodReportingTable::query()
    //         ->join('quarter_table', 'patient_period_reporting_table.quarter', '=', 'quarter_table.quarter')
    //         ->whereIn('type_clinic', $typeClinics);

    //     if ($year != 'All') {
    //         $rowsQuery->where('year', $year);
    //     }

    //     $rows = $rowsQuery
    //         ->selectRaw("
    //             patient_period_reporting_table.year,
    //             quarter_table.description as quarter,

    //             SUM(CASE WHEN type_clinic = 'ARTCLINIC' THEN 1 ELSE 0 END) as art_total,
    //             SUM(CASE WHEN type_clinic = 'ARTCLINIC' AND LOWER(status) = 'finished' THEN 1 ELSE 0 END) as art_submitted,
    //             SUM(CASE WHEN type_clinic = 'ARTCLINIC' AND LOWER(status) = 'live' THEN 1 ELSE 0 END) as art_inprogress,

    //             SUM(CASE WHEN type_clinic = 'ARTBANK' THEN 1 ELSE 0 END) as ban_total,
    //             SUM(CASE WHEN type_clinic = 'ARTBANK' AND LOWER(status) = 'finished' THEN 1 ELSE 0 END) as ban_submitted,
    //             SUM(CASE WHEN type_clinic = 'ARTBANK' AND LOWER(status) = 'live' THEN 1 ELSE 0 END) as ban_inprogress,

    //             SUM(CASE WHEN type_clinic = 'ARTSURROGACY' THEN 1 ELSE 0 END) as sur_total,
    //             SUM(CASE WHEN type_clinic = 'ARTSURROGACY' AND LOWER(status) = 'finished' THEN 1 ELSE 0 END) as sur_submitted,
    //             SUM(CASE WHEN type_clinic = 'ARTSURROGACY' AND LOWER(status) = 'live' THEN 1 ELSE 0 END) as sur_inprogress
    //         ")
    //         ->groupBy('patient_period_reporting_table.year', 'quarter_table.description')
    //         ->orderBy('patient_period_reporting_table.year')
    //         ->orderBy('quarter_table.quarter') 
    //         ->get();

    //         $rows = $rows->map(function ($row, $index) {
    //             $row->index = $index + 1;
    //             return $row;
    //         });

    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'data' => $rows,
    //             ]);
    //         }

    //     $allYears = PatientPeriodReportingTable::query()
    //         ->select('year')
    //         ->distinct()
    //         ->orderBy('year', 'desc')
    //         ->pluck('year');

    //     return view('reports.clinic.patient_detail_consolidated', [
    //         'clinicCounts'    => $clinicCounts,
    //         'reports'         => $rows,
    //         'finalizedCounts' => $finalizedCounts,
    //         'allYears'        => $allYears,
    //         'selectedYear'    => $year
    //     ]);
    // }

    public function patient_detail_consolidated(Request $request)
    {
        $typeClinics = ['ARTCLINIC', 'ARTBANK', 'ARTSURROGACY'];

        $user_type = session()->get('user_type');          // e.g., 5,6,7
        $state_name = session()->get('state_name');        // e.g., 'Karnataka'
        $year = $request->get('year', now()->year);

        // Clinic counts
        $clinicCounts = ClinicRegistrationModel::query()
            ->where('status', 1)
            ->whereIn('clinic_type', $typeClinics)
            ->when($user_type == 5 && !empty($state_name), function ($query) use ($state_name) {
                $query->whereRaw('LOWER(TRIM(state)) = ?', [strtolower(trim($state_name))]);
            })
            ->selectRaw('clinic_type, COUNT(*) as total')
            ->groupBy('clinic_type')
            ->pluck('total', 'clinic_type');

        $artDbName = DB::connection(config('database.default'))->getDatabaseName(); 
        $patientDbConnection = env('DB_SECOND_CONNECTION'); 
        $patientDb = DB::connection($patientDbConnection);
        // dd($artDbName,$patientDb);
        // Finalized counts
        $baseQuery = $patientDb
            ->table('patient_period_reporting_table as p')
            ->join(DB::raw("{$artDbName}.clinic_registration as c"), function ($join) {
                $join->on(
                    DB::raw('c.clinic_id COLLATE utf8mb4_unicode_ci'),
                    '=',
                    DB::raw('p.clinic_id COLLATE utf8mb4_unicode_ci')
                )->where('c.status', 1);
            })
            ->whereIn('p.type_clinic', $typeClinics)
            ->when($user_type == 5 && !empty($state_name), function ($q) use ($state_name) {
                $q->whereRaw(
                    'LOWER(TRIM(c.state)) = ?',
                    [strtolower(trim($state_name))]
                );
            });

        // Finished reports
        $finalizedCounts = (clone $baseQuery)
            ->where('p.status', 'Finished')
            ->selectRaw('p.type_clinic, COUNT(DISTINCT p.clinic_id) as total')
            ->groupBy('p.type_clinic')
            ->pluck('total', 'p.type_clinic');

        // Live reports
        $liveCounts = (clone $baseQuery)
            ->where('p.status', 'Live')
            ->selectRaw('p.type_clinic, COUNT(DISTINCT p.clinic_id) as total')
            ->groupBy('p.type_clinic')
            ->pluck('total', 'p.type_clinic');    

        // Rows query
        $rowsQuery = $patientDb->table('patient_period_reporting_table')
            ->join('quarter_table', 'patient_period_reporting_table.quarter', '=', 'quarter_table.quarter')
            // ->join(DB::raw("{$artDbName}.clinic_registration as cr"), 'patient_period_reporting_table.clinic_id', '=', 'cr.clinic_id')
            ->join("{$artDbName}.clinic_registration as cr", function($join) {
                            $join->on(DB::raw('patient_period_reporting_table.clinic_id COLLATE utf8mb4_general_ci'), '=', DB::raw('cr.clinic_id COLLATE utf8mb4_general_ci'));
                        })
            ->whereIn('type_clinic', $typeClinics)
            ->when($user_type == 5 && !empty($state_name), fn($q) =>
                $q->whereRaw('LOWER(TRIM(cr.state)) = ?', [strtolower(trim($state_name))])
            );

        $patientDbName = DB::connection($patientDbConnection)->getDatabaseName();
        $clinicsnotstarted = DB::table(DB::raw("{$artDbName}.clinic_registration as c"))
                    ->where('c.status', 1)
                    ->whereNotIn(
                        DB::raw('c.clinic_id COLLATE utf8mb4_unicode_ci'),
                        function ($query) use ($patientDbName) {
                            $query->select(DB::raw('p.clinic_id COLLATE utf8mb4_unicode_ci'))
                                ->from(DB::raw("{$patientDbName}.patient_period_reporting_table as p"));
                        }
                    )
                    ->when($user_type == 5 && !empty($state_name), function ($query) use ($state_name) {
                        $query->whereRaw('LOWER(TRIM(state)) = ?', [strtolower(trim($state_name))]);
                    })
                    ->select(
                        'c.clinic_type',
                        DB::raw('COUNT(*) as total')
                    )
                    ->groupBy('c.clinic_type')
                    ->pluck('total', 'clinic_type');
        // dd($clinicsnotstarted);
        if ($year != 'All') {
            $rowsQuery->where('year', $year);
        }

        $rows = $rowsQuery
            ->selectRaw("
                patient_period_reporting_table.year,
                quarter_table.description as quarter,

                SUM(CASE WHEN type_clinic = 'ARTCLINIC' THEN 1 ELSE 0 END) as art_total,
                SUM(CASE WHEN type_clinic = 'ARTCLINIC' AND LOWER(patient_period_reporting_table.status) = 'finished' THEN 1 ELSE 0 END) as art_submitted,
                SUM(CASE WHEN type_clinic = 'ARTCLINIC' AND LOWER(patient_period_reporting_table.status) = 'live' THEN 1 ELSE 0 END) as art_inprogress,

                SUM(CASE WHEN type_clinic = 'ARTBANK' THEN 1 ELSE 0 END) as ban_total,
                SUM(CASE WHEN type_clinic = 'ARTBANK' AND LOWER(patient_period_reporting_table.status) = 'finished' THEN 1 ELSE 0 END) as ban_submitted,
                SUM(CASE WHEN type_clinic = 'ARTBANK' AND LOWER(patient_period_reporting_table.status) = 'live' THEN 1 ELSE 0 END) as ban_inprogress,

                SUM(CASE WHEN type_clinic = 'ARTSURROGACY' THEN 1 ELSE 0 END) as sur_total,
                SUM(CASE WHEN type_clinic = 'ARTSURROGACY' AND LOWER(patient_period_reporting_table.status) = 'finished' THEN 1 ELSE 0 END) as sur_submitted,
                SUM(CASE WHEN type_clinic = 'ARTSURROGACY' AND LOWER(patient_period_reporting_table.status) = 'live' THEN 1 ELSE 0 END) as sur_inprogress
            ")
            ->groupBy(
                'patient_period_reporting_table.year',
                'quarter_table.description',
                'quarter_table.quarter'
            )
            ->orderBy('patient_period_reporting_table.year')
            ->orderBy('quarter_table.quarter')
            ->get();

        $rows = $rows->map(function ($row, $index) {
            $row->index = $index + 1;
            return $row;
        });

        if ($request->ajax()) {
            return response()->json([
                'data' => $rows,
            ]);
        }

        $allYears = PatientPeriodReportingTable::query()
            ->select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('reports.clinic.patient_detail_consolidated', [
            'clinicCounts'    => $clinicCounts,
            'reports'         => $rows,
            'finalizedCounts' => $finalizedCounts,
            'liveCounts'      => $liveCounts,
            'allYears'        => $allYears,
            'selectedYear'    => $year,
            'user_type'       => $user_type,
            'clinicsnotstarted' => $clinicsnotstarted
        ]);
    }
    public function liveClinics($status, $type)
    {
        $status = $status == 'live' ? 'Live' : 'Not Started';
        $clinicType = decrypt($type);
        $artDbName = DB::connection(config('database.default'))->getDatabaseName(); 
        $patientDbConnection = env('DB_SECOND_CONNECTION'); 
        $patientDb = DB::connection($patientDbConnection);   // your patient DB connection
        if ($status == 'Live') {
            // Live query
            $clinics = $patientDb
                    ->table('patient_period_reporting_table as p')
                    ->join(DB::raw("{$artDbName}.clinic_registration as c"), function ($join) {
                        $join->on(
                            DB::raw('c.clinic_id COLLATE utf8mb4_unicode_ci'),
                            '=',
                            DB::raw('p.clinic_id COLLATE utf8mb4_unicode_ci')
                        )->where('c.status', 1);
                    })
                    ->join('quarter_table as q', function ($join) {
                        $join->on('q.quarter', '=', 'p.quarter');
                    })
                    ->where('p.status', 'Live')
                    ->where('p.type_clinic', $clinicType)
                    ->select(
                        'c.name',
                        'c.state',
                        'q.description',
                        'p.year',
                        'c.email'
                    )
                    ->orderBy('c.state')
                    ->orderBy('p.year')
                    ->orderBy('q.id')      // or q.display_order if available
                    ->get();
        } else {
            // Not Started query
            $patientDbName = DB::connection($patientDbConnection)->getDatabaseName();

            $clinics = DB::table(DB::raw("{$artDbName}.clinic_registration as c"))
                ->where('c.status', 1)
                ->where('c.clinic_type', $clinicType)
                ->whereNotIn(
                    DB::raw('c.clinic_id COLLATE utf8mb4_unicode_ci'),
                    function ($query) use ($patientDbName, $clinicType) {
                        $query->select(DB::raw('p.clinic_id COLLATE utf8mb4_unicode_ci'))
                            ->from(DB::raw("{$patientDbName}.patient_period_reporting_table as p"))
                            ->where('p.type_clinic', $clinicType);
                    }
                )
                ->select(
                    'c.name',
                    'c.state',
                    'c.email'
                )
                ->orderBy('c.state')
                ->orderBy('c.name')
                ->get();
        }

        return response()->json([
            'livedata' => $clinics
        ]);
    }
}
