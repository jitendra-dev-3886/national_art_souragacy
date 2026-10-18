<?php


namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\clinic\ClinicRegistrationModel;
use App\Models\Noc\countrytable;
use App\Models\patient\PatientArtbank;
use App\Models\patient\PatientArtclinic;
use App\Models\patient\PatientPeriodReportingTable;
use App\Models\patient\PatientSurrogacyClinic;
use App\Models\patient\QuarterTable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;


class PatientReportController extends Controller
{

    function clinic_patient_list(Request $request, $type)
    {
        return view('layouts/admin/patient-list/clinic_patient_list', compact('type'));
    }

    public function clinic_patient_report(Request $request)
    {
        $request->validate([
            'clinic_id' => 'required|integer',
        ]);

        $clinicId = $request->clinic_id;


        $clinic = ClinicRegistrationModel::where('clinic_id', $clinicId)->where('status',1)->first();
        $clinic_type = $clinic->clinic_type;
        if ($clinic_type == 'ARTCLINIC') {
            $model = PatientArtclinic::class;
        } elseif ($clinic_type == 'ARTBANK') {
            $model = PatientArtbank::class;
        } elseif ($clinic_type == 'ARTSURROGACY') {
            $model = PatientSurrogacyClinic::class;
        }

        // $patientPeriodReporting = PatientPeriodReportingTable::where('clinic_id',$clinicId)->get();

        $clinicData = $model::selectRaw('clinic_id, year, quarter')
            ->where('clinic_id', $clinicId)
            ->whereHas('reporting',function($query){
                $query->where('status','Finished');
            })
            ->groupBy('clinic_id', 'year', 'quarter')
            ->orderBy('year', 'DESC')
            ->orderBy('quarter', 'DESC')
            ->get();
        
        if ($clinicData->isEmpty()) {
            return "<div class='text-center text-danger'>No patient data found for this clinic</div>";
        }

        $html = '<div class="accordion" id="clinicAccordion">';
        foreach ($clinicData as $index => $row) {

            $qDesc = QuarterTable::where('quarter', $row->quarter)->value('description');
            $desc = $qDesc ? $qDesc : '';
            if ($clinic_type == 'ARTCLINIC') {
                $patients = PatientArtclinic::where([
                    ['clinic_id', '=', $clinicId],
                    ['year', '=', $row->year],
                    ['quarter', '=', $row->quarter],
                ])
                    ->get();
            } elseif ($clinic_type == 'ARTBANK') {
                $patients = PatientArtbank::where([
                    ['clinic_id', '=', $clinicId],
                    ['year', '=', $row->year],
                    ['quarter', '=', $row->quarter],
                ])
                    ->get();
            } elseif ($clinic_type == 'ARTSURROGACY') {
                $patients = PatientSurrogacyClinic::where([
                    ['clinic_id', '=', $clinicId],
                    ['year', '=', $row->year],
                    ['quarter', '=', $row->quarter],
                ])
                    ->get();
            }

            $collapseId = 'collapse_' . $index;
            $tableId = "table_" . $index;

                        $html .= '
                <div class="accordion-item accordion-itesms">  

                <h2 class="accordion-header" id="heading_' . $index . '">
                    <button class="accordion-button collapsed" type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#' . $collapseId . '" 
                        aria-expanded="false" 
                        aria-controls="' . $collapseId . '">

                        Year-wise and Quarter-wise Patient Treatment List: 
                        ' . $row->year . ' | ' . $row->quarter . ' (' . $desc . ')

                    </button>
                </h2>

                <div id="' . $collapseId . '" 
                    class="accordion-collapse collapse" 
                    aria-labelledby="heading_' . $index . '" 
                    data-bs-parent="#clinicAccordion">

                    <div class="accordion-body">

                        <table id="' . $tableId . '" class="table table-bordered table-striped">';

                        if ($clinic_type == 'ARTCLINIC') {

                            $html .= '
                            <thead>
                                <tr>
                                    <th>UHID</th>
                                    <th>Case</th>
                                    <th>Procedure</th>
                                    <th>Treatment</th>
                                    <th>Total Cycle</th>
                                    <th>Pregnancy</th>
                                    <th>Treatment Outcome</th>
                                    <th>Pregnancy Outcome</th>
                                    <th>Live Birth</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>';

                            if ($patients->isEmpty()) {

                                $html .= '
                                <tr>
                                    <td colspan="10" class="text-center text-danger">
                                        No patient records
                                    </td>
                                </tr>';
                            } else {

                                foreach ($patients as $p) {

                                    $html .= '
                                    <tr>

                                        <td>' . ($p->patient_uhid ?? '-') . '</td>

                                        <td>' . (
                                        $p->case_of == 'one'
                                        ? 'Couple'
                                        : ($p->case_of == 'two'
                                            ? 'Single Woman'
                                            : '-')
                                    ) . '</td>

                                        <td>' . ($p->art_proc_undertaken ?? '-') . '</td>

                                        <td>' . ($p->types_of_treat ?? '-') . '</td>

                                        <td>' . ($p->total_num_of_cyc ?? '-') . '</td>

                                        <td>' . ($p->reganancy ?? '-') . '</td>

                                        <td>' . ($p->treat_outcomes ?? '-') . '</td>

                                        <td>' . ($p->preganancy_outcome ?? '-') . '</td>

                                        <td>' . ($p->l_birth ?? '-') . '</td>

                                        <td width="200">
                                            <button type="button" 
                                                class="btn btn-primary btn-sm openPatientModal"
                                                data-id="' . $p->id . '"
                                                data-type="' . $clinic_type . '"
                                                data-bs-toggle="modal"
                                                data-bs-target="#patientModal">

                                                <i class="fa-solid fa-circle-info"></i>

                                            </button>
                                            <button type="button" 
                                                class="btn btn-primary btn-sm  bi-arrow-down-circle downloadBtn"  data-id="' . $p->id . '"
                                                data-type="' . $clinic_type . '"
                                            </button>
                                        </td>

                                    </tr>';
                                }
                            }

                            $html .= '</tbody>';
                        } elseif ($clinic_type == 'ARTBANK') {

                            $html .= '
                            <thead>
                                <tr>
                                    <th>Donor ID</th>
                                    <th>Bank Name</th>
                                    <th>Gender</th>
                                    <th>Donor Age</th>
                                    <th>Marital Status</th>
                                    <th>Nationality</th>
                                    <th>Gamete Details</th>
                                    <th>Complications</th>
                                    <th>Remark</th>
                                    <th>Details</th>
                                </tr>
                            </thead>

                            <tbody>';

                            if ($patients->isEmpty()) {

                                $html .= '
                                <tr>
                                    <td colspan="10" class="text-center text-danger">
                                        No donor records
                                    </td>
                                </tr>';
                            } else {

                                foreach ($patients as $p) {

                                    $html .= '
                                    <tr>

                                        <td>' . ($p->donor_id ?? '-') . '</td>

                                        <td>' . ($p->name_of_bank ?? '-') . '</td>

                                        <td>' . ($p->gender_donor ?? '-') . '</td>

                                        <td>' . ($p->donor_age ?? '-') . '</td>

                                        <td>' . ($p->marital_status ?? '-') . '</td>

                                        <td>' . ($p->nationality ?? '-') . '</td>

                                        <td>' . ($p->gamete_details ?? '-') . '</td>

                                        <td>' . ($p->complicatoins_if_any ?? '-') . '</td>

                                        <td>' . ($p->remark ?? '-') . '</td>

                                        <td width="200">
                                            <button type="button" 
                                                class="btn btn-primary btn-sm openPatientModal"
                                                data-id="' . $p->id . '"
                                                data-type="' . $clinic_type . '"
                                                data-bs-toggle="modal"
                                                data-bs-target="#patientModal">

                                                <i class="fa-solid fa-circle-info"></i>

                                            </button>
                                            <button type="button" 
                                                class="btn btn-primary btn-sm  bi-arrow-down-circle downloadBtn"  data-id="' . $p->id . '"
                                                data-type="' . $clinic_type . '"
                                            </button> 
                                        </td>

                                    </tr>';
                                }
                            }

                            $html .= '</tbody>';
                        } elseif ($clinic_type == 'ARTSURROGACY') {

                            $html .= '
                            <thead>
                                <tr>
                                    <th>UHID</th>
                                    <th>Case</th>
                                <th>Procedure</th>
                                    <th>Treatment</th>
                                    <th>Total Cycle</th>
                                    <th>Treatment Outcome</th>
                                <th>Details</th>
                                
                                </tr>
                            </thead>

                            <tbody>';

                            if ($patients->isEmpty()) {

                                $html .= '
                                <tr>
                                    <td colspan="8" class="text-center text-danger">
                                        No surrogacy records
                                    </td>
                                </tr>';
                            } else {

                                foreach ($patients as $p) {


                                    $html .= '
                                <tr>

                <td>' . ($p->pati_uhid ?? '-') . '</td>


                                        


                ' . (
                                        $p->treatment_type === 'surrogacy'
                                        ? '
                                        <td>' . (
                                            $p->case_of == 'one'
                                            ? 'Couple'
                                            : ($p->case_of == 'two'
                                                ? 'Single Woman'
                                                : '-')
                                        ) . '</td>
                        <td>' . ($p->art_undertaken ?? '-') . '</td>
                        <td>' . ($p->types_of_treat ?? '-') . '</td>
                        <td>' . ($p->total_nun_cycles ?? '-') . '</td>
                    
                        <td>' . ($p->tratment_Outcome ?? '-') . '</td>
                    '
                                        : ($p->treatment_type === 'art_treatment'
                                            ? '
                                            <td>' . (
                                                $p->art_case_of == 'one'
                                                ? 'Couple'
                                                : ($p->art_case_of == 'two'
                                                    ? 'Single Woman'
                                                    : '-')
                                            ) . '</td>
                            <td>' . ($p->art_proc_undertaken ?? '-') . '</td>
                            <td>' . ($p->art_types_of_treat ?? '-') . '</td>
                            <td>' . ($p->art_total_num_of_cyc ?? '-') . '</td>
                        
                            <td>' . ($p->art_treat_outcomes ?? '-') . '</td>
                        '
                                            : '
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        '
                                        )
                                    ) . '

                <td>
                    <button type="button"
                        class="btn btn-primary btn-sm openPatientModal"
                        data-id="' . $p->id . '"
                        data-type="' . $clinic_type . '"
                        data-bs-toggle="modal"
                        data-bs-target="#patientModal">

                        <i class="fa-solid fa-circle-info"></i>

                    </button>
                    <button type="button" 
                        class="btn btn-primary btn-sm  bi-arrow-down-circle downloadBtn"  data-id="' . $p->id . '"
                        data-type="' . $clinic_type . '"
                    </button>
                </td>

                </tr>';
                                }
                            }

                            $html .= '</tbody>';
                        }

                        $html .= '
                        </table>

                    </div>
                </div>
                </div>';
                    }

        $html .= '</div>';

        return $html;
    }


    function clinic_patient_details(Request $request)
    {
        $id = $request->id;
        $clinic_type = $request->clinic_type;
        if ($clinic_type == 'ARTCLINIC') {
            $patient = PatientArtclinic::find($id);
        } elseif ($clinic_type == 'ARTBANK') {
            $patient = PatientArtbank::find($id);
        } elseif ($clinic_type == 'ARTSURROGACY') {

            // pehle basic patient fetch karo
            $patient = PatientSurrogacyClinic::where('id', $id)->first();

            if (!$patient) {
                $patient = null;
            }


            if ($patient && $patient->treatment_type == 'surrogacy') {

                    $patient = PatientSurrogacyClinic::select(
                        'patient_surrogacyclinic.*',
                        'doc_file_patient_medical_uploads.doc_upload_ref'
                    )
                        ->leftJoin('doc_file_patient_medical_uploads', function ($join) {
                            $join->on('doc_file_patient_medical_uploads.app_id', '=', 'patient_surrogacyclinic.id')
                                ->on('doc_file_patient_medical_uploads.userid', '=', 'patient_surrogacyclinic.userid');
                        })
                        ->where('patient_surrogacyclinic.id', $id)
                        ->where('patient_surrogacyclinic.treatment_type', 'surrogacy')
                        ->first();
            } else {

                // art_treatment ya other case → simple query (no join)
                $patient = PatientSurrogacyClinic::where('id', $id)->first();
            }
            if($patient->art_nationality == 'Foreigner')
            {
                $patient['husband_country'] = countrytable::where('id', $patient->art_other_nationality)->value('country_name');
                
            }
            if($patient->art_nationality_wife == 'Foreigner')
            {
                $patient['wife_country'] = countrytable::where('id', $patient->art_other_nationality_wife)->value('country_name');
            }
       
        }
        if($patient->nationality == 'OCI Card Holders' || $patient->nationality == 'Foreigner')
        {
            $patient['husband_country'] = countrytable::where('id', $patient->other_nationality)->value('country_name');
            
        }
        if($patient->nationality_wife == 'OCI Card Holders' || $patient->nationality_wife == 'Foreigner')
        {
            $patient['wife_country'] = countrytable::where('id', $patient->other_nationality_wife)->value('country_name');
        }
        $qDesc = QuarterTable::where('quarter', $patient->quarter)->value('description');

        $quarter = $qDesc ? $qDesc : '';
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient not found.');
        }
        // dd($patient);
        return view('layouts/admin/patient-list/clinic_patient_full_details', compact('patient', 'quarter', 'clinic_type'));
    }
    public function downloadPatientDetailsReport(Request $request)
    {
       $id = $request->id;
        $clinic_type = $request->clinic_type;
        if ($clinic_type == 'ARTCLINIC') {
            $patient = PatientArtclinic::find($id);
        } elseif ($clinic_type == 'ARTBANK') {
            $patient = PatientArtbank::find($id);
        } elseif ($clinic_type == 'ARTSURROGACY') {
            // pehle basic patient fetch karo
            $patient = PatientSurrogacyClinic::where('id', $id)->first();

            if (!$patient) {
                $patient = null;
            }

            // if ($patient && $patient->treatment_type == 'surrogacy') {

            //     $patient = PatientSurrogacyClinic::select(
            //         'patient_surrogacyclinic.*',
            //         'doc_file_patient_medical_uploads.doc_upload_ref'
            //     )
            //         ->leftJoin('doc_file_patient_medical_uploads', function ($join) {
            //             $join->on('doc_file_patient_medical_uploads.app_id', '=', 'patient_surrogacyclinic.id')
            //                 ->on('doc_file_patient_medical_uploads.userid', '=', 'patient_surrogacyclinic.userid');
            //         })
            //         ->where('patient_surrogacyclinic.id', $id)
            //         ->where('patient_surrogacyclinic.treatment_type', 'surrogacy')
            //         ->first();
            // } else {
            //     // art_treatment ya other case → simple query (no join)
            //     $patient = PatientSurrogacyClinic::where('id', $id)->first();
            // }
            if($patient && $patient->treatment_type !=""){
                
                $patient = PatientSurrogacyClinic::where('id', $id)                
                ->first();
               // dd($patient);
            }
            if($patient->art_nationality == 'Foreigner')
            {
                $patient['husband_country'] = countrytable::where('id', $patient->art_other_nationality)->value('country_name');
                
            }
            if($patient->art_nationality_wife == 'Foreigner')
            {
                $patient['wife_country'] = countrytable::where('id', $patient->art_other_nationality_wife)->value('country_name');
            }

        }
        if($patient->nationality == 'OCI Card Holders'  || $patient->nationality == 'Foreigner')
        {
            $patient['husband_country'] = countrytable::where('id', $patient->other_nationality)->value('country_name');
            
        }
        if($patient->nationality_wife == 'OCI Card Holders' || $patient->nationality_wife == 'Foreigner')
        {
            $patient['wife_country'] = countrytable::where('id', $patient->other_nationality_wife)->value('country_name');
        }
          // Check patient exists
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient not found.');
        }
        $qDesc = QuarterTable::where('quarter', $patient->quarter)->value('description');
        $quarter = $qDesc ? $qDesc : '';
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient not found.');
        }  
        $pdf = Pdf::loadView(
            // 'layouts.admin.patient-list.clinic_patient_full_details',
        'reports.download_patient_details_reports',
        compact('patient', 'quarter', 'clinic_type')
        )->setPaper('A4', 'portrait');  // landscape portrait
        return $pdf->download('patient_report.pdf');
    }
}
