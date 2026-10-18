<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\clinic\signup;
use Illuminate\Support\Carbon;
use App\Models\patient\QuarterTable;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Noc\countrytable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use App\Models\clinic\ClinicRegistrationModel;
use App\Models\patient\PatientSurrogacyClinic;
use App\Models\patient\PatientPeriodReportingTable;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\Noc\docmastertable;
use App\Models\DocFilePatientUpload;
use App\Models\patient\SummaryPatientSurrogacyClinic;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class PatientSurrogacyClinicController extends Controller
{
    private function getNextQuarter($currentQuarter)
    {
        $quarters = [1, 2, 3, 4];
        $index = array_search($currentQuarter, $quarters);

        if ($index === false) {
            return ['quarter' => $currentQuarter, 'year_add' => 0];
        }

        if ($index === count($quarters) - 1) {
            return ['quarter' => $quarters[0], 'year_add' => 1];
        } else {
            return ['quarter' => $quarters[$index + 1], 'year_add' => 0];
        }
    }

    public function list_surrogacyclinic_patient()
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        $quarter = QuarterTable::all();
        $currentYear = date('Y');
        $startingYear = 2022;
        $currentQuarter = ceil(date('n') / 3);
        $defaultQuarter = 1;
        $defaultYear = $startingYear;

        $add = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTSURROGACY')->first();
        $patient_list = PatientSurrogacyClinic::where('userid', $userId)->get();

        $reportData = PatientPeriodReportingTable::with('quarter')
            ->where(function ($query) {
                $query->where('status', '=', 'Live')
                    ->orWhereNull('status');
            })
            ->latest()
            ->get();


        $latestRecord = PatientPeriodReportingTable::where('userid', $userId)
            ->where('clinic_id', $add->clinic_id)
            ->orderByDesc('year')
            ->orderByDesc('quarter')
            ->first();
        if (!$latestRecord) {
            $estDate = $add->date_of_establishment ?? null;
            try {
                $date = Carbon::createFromFormat('Y-m-d', $estDate);
            } catch (\Exception $e) {
                Log::warning("Invalid establishment date format of the surrogacy clinic", [
                    'invalidDate' => $estDate,
                    'Clinic ID' => $add->clinic_id,
                    'singup ID' => $userId,
                ]);
                return view('layouts/clinic/invalid_establishment_date', [
                    'invalidDate' => $estDate,
                    'clinictype'  => "Surrogacy Clinic",
                    'errorMessage' => 'Invalid establishment date format'
                ]);
            }
            $estDate = $add->date_of_establishment;
            $estYear = date('Y', strtotime($estDate));
            $estMonth = date('n', strtotime($estDate));

            if ($estYear < $startingYear) {
                $defaultYear = $startingYear;
                $defaultQuarter = 1;
            } else {
                $defaultYear = $estYear;
                if ($estMonth >= 1 && $estMonth <= 3) {
                    $defaultQuarter = 1;
                } elseif ($estMonth >= 4 && $estMonth <= 6) {
                    $defaultQuarter = 2;
                } elseif ($estMonth >= 7 && $estMonth <= 9) {
                    $defaultQuarter = 3;
                } else {
                    $defaultQuarter = 4;
                }
            }
        } else {
            if ($latestRecord->status === 'Live') {
                $defaultQuarter = $latestRecord->quarter;
                $defaultYear = $latestRecord->year;
            } elseif ($latestRecord->status === 'Finished') {

                $nextQuarter = $this->getNextQuarter($latestRecord->quarter);
                $defaultQuarter = $nextQuarter['quarter'];
                $defaultYear = $latestRecord->year + $nextQuarter['year_add'];
            }
        }

        if ($defaultYear > $currentYear) {
            $defaultYear = $currentYear;
            $defaultQuarter = $currentQuarter - 1;
        } elseif ($defaultYear == $currentYear && $defaultQuarter >= $currentQuarter) {
            $defaultQuarter = $currentQuarter - 1;
        }
        if ($defaultQuarter == 0) {
            $defaultQuarter = 4;
            $defaultYear--;
        }

        $exists = PatientPeriodReportingTable::where('userid', $userId)
            ->where('clinic_id', $add->clinic_id)
            ->where('status', 'Live')
            ->exists();

        if ($exists) {
            $reporting_data = PatientPeriodReportingTable::where('status', 'Live')
                ->where('userid', $userId)
                ->where('clinic_id', $add->clinic_id)
                ->first();
            $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();
            $available_quarters = PatientPeriodReportingTable::where('status', 'Live')
                ->where('userid', $userId)
                ->where('clinic_id', $add->clinic_id)
                ->select('quarter')
                ->distinct()
                ->orderBy('quarter')
                ->get()
                ->map(function ($q) use ($quarterDescriptions) {
                    return [
                        'id' => $q->quarter,
                        'description' => $quarterDescriptions[$q->quarter] ?? $q->quarter,
                    ];
                });

            $available_years = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $add->clinic_id)
                ->select('year')
                ->distinct()
                ->orderByDesc('year')
                ->get();
            $patients_count = PatientSurrogacyClinic::where('clinic_id', $add->clinic_id)
                        ->where('year', $available_years->first()->year)
                        ->where('quarter', $available_quarters->first()['id'])
                        ->where('treatment_type', 'surrogacy')
                        ->withCount('documents')
                        ->get();
            $doc_uploaded = True;
            $fileExists = True;
            foreach ($patients_count as $patient) {
                $required = ($patient->num_pre_child === 'Yes') ? 2 : 1;
                if ($patient->documents_count < $required) {
                    // return back()->withErrors([
                    //     'error' => "Patient ID {$patient->id} has pending document uploads."
                    // ]);
                    $foldername   = 'surrogacy_patient_medical_docs';
                    $baseDir = folderpath($foldername);
                    $application_no_folder = str_replace('/', '_', $patient->clinic_id);
                    $destinationfolder = $baseDir . $application_no_folder;
                    $file_path = DocFilePatientUpload::where([
                        'userid' => $patient->userid,
                        'app_id' => $patient->id,
                        'doc_id' => 36,
                        'doc_type' => "target_file_surrogacypatient_medicalcertificate_docs"
                    ])->value('doc_upload_ref');
                    $fileExists = false;
                    if (!empty($file_path)) {
                        $fullPath = $destinationfolder . DIRECTORY_SEPARATOR . $file_path;
                        $fileExists = File::exists($fullPath);
                    }
                    $doc_uploaded = False;
                    return view('layouts/clinic/add_patient_reporting_already_live_period_surrogacy_application_form', compact(
                    'quarter',
                    'exists',
                    'reporting_data',
                    'available_quarters',
                    'available_years',
                    'defaultQuarter',
                    'defaultYear',
                    'startingYear',
                    'currentYear',
                    'doc_uploaded',
                    'fileExists',
                ));
                }
            }
            return view('layouts/clinic/add_patient_reporting_already_live_period_surrogacy_application_form', compact(
                'quarter',
                'exists',
                'reporting_data',
                'available_quarters',
                'available_years',
                'defaultQuarter',
                'defaultYear',
                'startingYear',
                'currentYear',
                'doc_uploaded',
                'fileExists',
            ));
        }
        if (!$exists) {
            return view('layouts/clinic/add_patient_reporting_period_surrogacy_application_form', compact(
                'quarter',
                'exists',
                'defaultQuarter',
                'defaultYear',
                'startingYear',
                'currentYear'
            ));
        }
    }

    public function patientalreadylivereportingreportingsurrogacyapplicationformSubmit(Request $request)
    {
        if (!Session::has('id')) {
            return redirect()->back()->withErrors(['error' => 'Session expired. Please login again.']);
        }

        $userId = Session::get('id');
        $status = $request->input('status');
        $quarter_id = $request->input('quarter_id');
        $quarter = $request->input('quarter');

        $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTSURROGACY')->first();

        if (!$add_data) {
            return response()->json(['message' => 'User data not found.'], 404);
        }

        // Check if there's already a record for this user, clinic, quarter and year
        $existingRecord = PatientPeriodReportingTable::where('userid', $add_data->userid_applicant)
            ->where('clinic_id', $add_data->clinic_id)
            ->where('quarter', $request->input('quarter'))
            ->where('year', $request->input('year'))
            ->where('id', $request->input('quarter_id'))
            ->first();


        //dd($existingRecord);
        if ($existingRecord) {
            $existingRecord->fill($request->except(['_token']));
            $existingRecord->status = $status;

            $existingRecord->final_submit_date = now();
            $existingRecord->save();
        } else {

            // Insert new record
            $patient_add_data = PatientPeriodReportingTable::where('userid', $add_data->userid_applicant)
                ->where('clinic_id', $add_data->clinic_id)
                ->where('quarter', $request->input('quarter'))
                ->where('year', $request->input('year'))
                ->where('id', $request->input('quarter_id'))
                ->get();

            $patient_add_data->userid = $add_data->userid_applicant;
            $patient_add_data->clinic_id = $add_data->clinic_id;
            $patient_add_data->status = $status;


            $patient_add_data->final_submit_date = now();
            $patient_add_data->fill($request->except(['_token']));
            $patient_add_data->save();
        }

        return response()->json([
            'message' => 'Reporting information for this quarter has been successfully ' . ($existingRecord ? 'updated' : 'saved') . '.',
            'status' => $status
        ]);
    }

    public function patientsurrogacyapplicationform(Request $request)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        $countries = countrytable::all();
        $patient_list = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTSURROGACY')->first();
        $quarter = QuarterTable::all();


        $status = 'Live';
        $reporting_data = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $patient_list->clinic_id)->latest()->first();
        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();

        $available_quarters = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $patient_list->clinic_id)
            ->select('quarter')
            ->distinct()
            ->orderBy('quarter')
            ->get()
            ->map(function ($q) use ($quarterDescriptions) {
                return [
                    'id' => $q->quarter,
                    'description' => $quarterDescriptions[$q->quarter] ??  $q->quarter,
                ];
            });

        $available_years = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $patient_list->clinic_id)
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->get();

        return view('layouts/clinic/add_patient_surrogacy_application_form', compact(
            'patient_list',
            'countries',
            'quarter',
            'reporting_data',
            'available_quarters',
            'available_years'
        ));
    }

    public function surrogacycheckuhid(Request $request)
    {

        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        $uhid = $request->input('pati_uhid');
        $yy_ = $request->input('year_');
        $qq_ = $request->input('quarter_');
        if (!$uhid) {
            return response()->json(['status' => 'error', 'message' => 'Email is required'], 400);
        }
        if (!$yy_ || !$qq_) {
            return response()->json(['status' => 'error', 'message' => 'year or quarter is not selected'], 400);
        }
        $record = PatientSurrogacyclinic::where('userid', $userId)
            ->where('pati_uhid', $uhid)
            ->first();
        if (!$record) {
            return response()->json([
                'status' => 'available',
                'matched' => 'available'
            ]);
        }
        if ($record->year == $yy_ && $record->quarter == $qq_) {
            return response()->json([
                'status' => 'exists',
                'matched' => 'q_matched'
            ]);
        }
        return response()->json([
            'status' => 'exists',
            'matched' => 'q_not_matched'
        ]);
    }

    public function patientsurrogacyapplicationformSubmit(Request $request)
    {
        try{
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $action = $request->input('submit');
        $rule1 = [];
        $messages1 = [];
        if ($request->treatment_type == 'surrogacy') {
            $art_proc_undertaken = ['In Vitro Fertilization-Embryo Transfer(IVF-ET)', 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)', 'Others'];
            $rule1 = [
                'case_of' => 'required|in:one,two',
                'nationality' => 'nullable|required_if:case_of,one|in:Indian,OCI Card Holders',
                'other_nationality' => 'nullable|required_if:nationality,OCI Card Holders|exists:apps_countries,id',
                'nationality_wife' => 'required|in:Indian,OCI Card Holders',
                'other_nationality_wife' => 'nullable|required_if:nationality_wife,OCI Card Holders|exists:apps_countries,id',
                'age' => 'nullable|required_if:case_of,one|numeric',
                'wife_age' => 'nullable|required_if:case_of,one|numeric',
                'age_of_women' => 'nullable|required_if:case_of,two|numeric',
                'num_pre_child' => 'required|string',
                'child_give_details' => 'nullable|required_if:num_pre_child,Yes|string',
                'uterus_ab' => 'in:Y,N',
                'ivf_failure' => 'in:Y,N',
                'preg_loss' => 'in:Y,N',
                'life_threat' => 'in:Y,N',
                'male_factor' => 'in:Y,N',
                'types_of_treat' => 'required|in:Surrogacy using self gametes,Surrogacy using donor gametes',
                'types_of_treat1' => 'nullable|required_if:types_of_treat,Surrogacy using donor gametes|in:Self Oocyte & Donor Sperm,Donor Oocyte & Self Sperm',
                'surrogate_mother_age' => 'required|integer|min:25|max:35',
                'total_nun_cycles' => 'required|numeric',
                'no_cycles' => 'required|numeric',
                'Cycle_fail_reason' => 'nullable|required_if:no_cycles,>,1|string',
                'art_undertaken' => 'required|in:' . implode(',', $art_proc_undertaken),
                'art_undertaken_other' => 'nullable|required_if:art_undertaken,Others|string|nullable',

                'cyc_canc_failure_reason' => 'nullable|string',
                'tratment_Outcome' => 'required|in:Pregnant,Not Pregnant',
                'complicatoins_if_any' => 'nullable|string',
                'medical_surrogacy' => 'required|string',
                'remark' => 'nullable|string',
                'declaration' => 'required',
                'declaration1' => 'nullable|required_if:num_pre_child,No',
                // 'declaration3' => 'nullable|required_if:types_of_treat1,Donor Oocyte & Self Sperm',
                'declaration3' => [
                    Rule::requiredIf(function () use ($request) {
                        return (
                            $request->types_of_treat === "Surrogacy using donor gametes"
                            && in_array($request->types_of_treat1, [
                                // "Self Oocyte & Donor Sperm",
                                "Donor Oocyte & Self Sperm"
                            ])
                        ) && $request->case_of === 'one'; // 👈 yaha change
                    }),
                ],
                'declaration4' => [
                    Rule::requiredIf(function () use ($request) {
                        return in_array($request->types_of_treat == "Surrogacy using donor gametes" && $request->types_of_treat1, [
                            "Self Oocyte & Donor Sperm",
                            "Donor Oocyte & Self Sperm"
                        ]);
                    })
                ],
            ];
            $messages1 = [
                'previous_treatment.required' => 'Please select whether previous treatment was taken.',
                'previous_treatment.in' => 'Invalid value selected for previous treatment.',

                'case_of.required' => 'Please select the case type.',
                'case_of.in' => 'Invalid case type selected.',
                'nationality.required_if' => 'Please select nationality of the Husband.',
                'nationality.in' => 'Nationality must be either Indian or OCI Card Holders.',
                'other_nationality.required_if' => 'Please select the country when nationality is OCI Card Holders.',
                'other_nationality.exists' => 'Selected nationality is invalid.',
                'nationality_wife.required' => 'Please select nationality of the Wife.',
                'nationality_wife.in' => 'Wife nationality must be either Indian or OCI Card Holders.',
                'other_nationality_wife.required_if' => 'Please select wife country when nationality is OCI Card Holders.',
                'other_nationality_wife.exists' => 'Selected wife nationality country is invalid.',
                'wife_age.required_if' => 'Please enter the age of wife.',
                'wife_age.numeric' => 'Age of wife must be a number.',
                'age.required_if' => 'Please enter the age of husband.',
                'age.numeric' => 'Age of husband must be a number.',
                'age_of_women.required_if' => 'Please enter the age of woman.',
                'age_of_women.numeric' => 'Age of woman must be a number.',
                'uterus_ab.in' => 'Invalid selection for Uterus Abnormalities.',
                'ivf_failure.in' => 'Invalid selection for Repeated IVF failure or Recurrent implantation failure.',
                'preg_loss.in' => 'Invalid selection for Multiple Pregnancy Loss.',
                'life_threat.in' => 'Invalid selection for Life threatening illness',
                'num_pre_child.required' => 'Having Surviving Child cannot be blank.',
                'num_pre_child.string' => 'Having Surviving Child must be valid text.',
                'male_factor.in' => 'Invalid selection for male factor.',
                'medical_surrogacy.required' => 'Please provide medical reason for opting surrogacy.',
                'types_of_treat.required' => 'Please select the type of treatment.',
                'types_of_treat.in' => 'Invalid treatment type selected.',
                'types_of_treat1.required_if' => 'Please select donor type when donor gametes are used.',
                'types_of_treat1.in' => 'Invalid donor type selected.',
                'surrogate_mother_age.required' => 'Surrogate Mother Age cannot be blank.',
                'art_undertaken.required' => 'ART Procedure Undertaken cannot be blank.',
                'art_undertaken_other.required_if' => 'Please specify other ART Procedures',
                'no_cycles.required' => 'Please enter number of cycles undertaken.',
                'no_cycles.numeric' => 'Number of cycles must be numeric.',
                'Cycle_fail_reason.required_if' => 'Please specify reason for Cycle Cancellation',
                'cyc_canc_failure_reason.required' => 'Please provide reason for cancellation.',
                'cyc_canc_failure_reason.string' => 'Reason must be valid text.',
                'tratment_Outcome.required' => 'Please select treatment outcome.',
                'tratment_Outcome.in' => 'Invalid treatment outcome selected.',
                'complicatoins_if_any.string' => 'Complications must be valid text.',
                'remark.string' => 'Remark must be valid text.',
                'declaration.required' => 'From Surrogate Mother that she has not acted as a surrogate mother more than once in her lifetime.',
                'declaration1.required_if' => 'From intending couple or single woman (widow or divorcee) that they/she do/does not have any surviving child biologically or through adoption or through surrogacy earlier.',
                'declaration1.accepted' => 'Please accept the declaration to continue.',
                'declaration3.required' => 'Please click that Affidavit/undertaking** has been taken on record From Oocyte Donor that she has not donated oocytes more than once in her life time.',
                'declaration4.required' => 'Please Click on Undertaking that Affidavit/undertking** has been taken on record From the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman.',
            ];
        } elseif ($request->treatment_type == 'art_treatment') {
            $art_proc_undertaken = ['artificial insemination', 'intra-uterine insemination(IUI)', 'in vitro fertilization-embryo transfer', 'gamete intrafallopian tube transfer', 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)', 'physiological Intra-cytoplasmic sperm injection', 'intra-cytoplasmic morphologically selected sperm injection', 'round spermatid nucleus injection', 'Elongated spermatid injection', 'Others'];
            // dd($request->all());
            $rule1 = [
                'art_case_of' => 'required|in:one,two',
                'art_nationality' => 'nullable|required_if:art_case_of,one|in:Indian,Foreigner',
                'art_other_nationality' => 'nullable|required_if:art_nationality,Foreigner|exists:apps_countries,id',
                'art_nationality_wife' => 'required|in:Indian,Foreigner',
                'art_other_nationality_wife' => 'nullable|required_if:art_nationality_wife,Foreigner|exists:apps_countries,id',
                'art_age_hus_wife' => 'nullable|required_if:art_case_of,one|numeric',
                'art_wife_age' => 'nullable|required_if:art_case_of,one|numeric',
                'art_age_of_women' => 'nullable|required_if:art_case_of,two|numeric',
                'art_male_factor' => 'in:Y,N',
                'art_female_factor' => 'in:Y,N',
                'art_unexplained' => 'in:Y,N',
                'art_cause_of_infretily' => 'required|string',
                'art_proc_undertaken' => 'required|in:' . implode(',', $art_proc_undertaken),
                'art_undertaken_other_2' => 'nullable|required_if:art_proc_undertaken,Others|string',
                'art_types_of_treat' => 'required|in:ART Treatment using self gametes,ART Treatment using donor gametes',
                'art_types_of_treat1' => 'nullable|required_if:art_types_of_treat,ART Treatment using donor gametes|in:Oocyte Donation,Sperm Donation,Both Oocyte Donation & Sperm Donation',
                'art_total_num_of_cyc' => 'required|numeric',
                'art_no_cycles' => 'required|numeric',
                'art_cyc_canc_failure_reason' => 'nullable|string',
                'art_treat_outcomes' => 'required|in:Pregnant,Not Pregnant',
                'art_complicatoins_if_any' => 'nullable|string',
                'art_remark' => 'nullable|string',
                'art_declaration' => [
                    Rule::requiredIf(function () use ($request) {
                        return $request->types_of_treat == "ART Treatment using donor gametes" &&
                            in_array($request->types_of_treat1, [
                                "Oocyte Donation",
                                "Both Oocyte Donation & Sperm Donation"
                            ]);
                    })
                ],
                'art_declaration1' => [
                    Rule::requiredIf(function () use ($request) {
                        return $request->types_of_treat == "ART Treatment using donor gametes" && in_array($request->types_of_treat1, [
                            "Oocyte Donation",
                            "Sperm Donation",
                            "Both Oocyte Donation & Sperm Donation"
                        ]);
                    })
                ],
                // 'preganancy_outcome' => 'nullable|required_if:treat_outcomes,Pregnant|string',
                //'l_birth' => 'nullable|required_if:preganancy_outcome,live birth|string',
                // 'gender_child' => 'nullable|required_if:l_birth,Singleton,Twin,Stillbirth',
                //'other_gender' => 'nullable|required_if:l_birth,Higher Order|string',
            ];
            $messages1 = [
                'previous_treatment.required' => 'Please select whether previous treatment was taken.',
                'previous_treatment.in' => 'Invalid value selected for previous treatment.',
                'art_case_of.required' => 'Please select the case type.',
                'art_case_of.in' => 'Invalid case type selected.',
                'art_nationality.required_if' => 'Please select nationality of the Husband.',
                'art_nationality.in' => 'Nationality must be either Indian or Foreigner.',
                'art_other_nationality.required_if' => 'Please select the country when nationality is Foreigner.',
                'art_other_nationality.exists' => 'Selected nationality is invalid.',
                'art_nationality_wife.required' => 'Please select nationality of the Wife.',
                'art_nationality_wife.in' => 'Wife nationality must be either Indian or Foreigner.',
                'art_other_nationality_wife.required_if' => 'Please select wife country when nationality is Foreigner.',
                'art_other_nationality_wife.exists' => 'Selected wife nationality country is invalid.',
                'art_age_hus_wife.required_if' => 'Please enter age of husband.',
                'art_age_hus_wife.numeric' => 'Age of husband must be a number.',
                'art_wife_age.required_if' => 'Please enter age of wife.',
                'art_wife_age.numeric' => 'Age of wife must be a number.',
                'art_age_of_women.required_if' => 'Please enter age of woman.',
                'art_age_of_women.numeric' => 'Age of woman must be a number.',
                'art_male_factor.in' => 'Invalid selection for male factor.',
                'art_female_factor.in' => 'Invalid selection for female factor.',
                'art_unexplained.in' => 'Invalid selection for unexplained infertility.',
                'art_cause_of_infretily.required' => 'Please enter the cause of infertility.',
                'art_proc_undertaken.required' => 'Please select the ART procedure undertaken.',
                'art_proc_undertaken.in' => 'Invalid ART procedure selected.',
                'art_undertaken_other_2.required_if' => 'Please specify the ART procedure when "Others" is selected.',
                'art_types_of_treat.required' => 'Please select the type of treatment.',
                'art_types_of_treat.in' => 'Invalid treatment type selected.',
                'art_types_of_treat1.required_if' => 'Please select donor type when donor gametes are used.',
                'art_types_of_treat1.in' => 'Invalid donor type selected.',
                'art_total_num_of_cyc.required' => 'Please enter total number of cycles.',
                'art_total_num_of_cyc.numeric' => 'Total number of cycles must be numeric.',
                'art_no_cycles.required' => 'Please enter number of cycles undertaken.',
                'art_no_cycles.numeric' => 'Number of cycles must be numeric.',
                'art_cyc_canc_failure_reason.required' => 'Please provide reason for cancellation.',
                'art_cyc_canc_failure_reason.string' => 'Reason must be valid text.',
                'art_treat_outcomes.required' => 'Please select treatment outcome.',
                'art_treat_outcomes.in' => 'Invalid treatment outcome selected.',
                'art_complicatoins_if_any.string' => 'Complications must be valid text.',
                'art_remark.string' => 'Remark must be valid text.',
                'art_declaration.required' => 'Please click that affidavit/undertaking** has been taken on record from Oocyte Donor that she has not donated oocytes more than once in her life time.',
                'art_declaration.accepted' => 'You must confirm the Oocyte Donor declaration.',
                'art_declaration1.required' => 'Please click on undertaking that affidavit/undertaking** has been taken on record from the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman or clinic and clinic has not used the sperm/oocyte of the same donor for more than one commissioning couple.',
                'art_declaration1.accepted' => 'You must confirm the ART Clinic declaration.',
            ];
        }
        $rule2 = [
                'name_of_clinic' => 'required|string',
                'pati_uhid' => 'required|string|max:15',
                'treatment_type' => 'required|in:art_treatment,surrogacy'
            ];
        $messages2 = [
                'pati_uhid.required' => 'Patient UHID is required.',
                'pati_uhid.max' => 'Patient UHID must not exceed 15 characters.',
                'name_of_clinic.required' => 'Please enter the name of the clinic.',
                'name_of_clinic.string' => 'Clinic name must be valid text.',
                'treatment_type.required' => 'Please select the Treatment type.',
            ];
        $rule = array_merge($rule1, $rule2);
        $messages = array_merge($messages1, $messages2);
        $request->validate($rule, $messages);

        $userId = Session::get('id');
        $checkrecord = PatientSurrogacyClinic::where('userid', $userId)
            ->where('pati_uhid', $request->pati_uhid)
            ->exists();

        if ((!$checkrecord && $request->previous_treatment !== 'No') || ($checkrecord && $request->previous_treatment !== 'Yes')) {
            return redirect()->route('clinic.add_patient_surrogacy_application_form')->withInput()->with('upd_error', 'Patient UHID already exists for Surrogacy Clinic. Please check the UHID and try again.');
        }
        $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTSURROGACY')->first();

        if (!$add_data) {
            return back()->with('error', 'Surrogacy Registration data not found.');
        }
        // Check if the fetched value (hidden input) matches the actual database value
        if ($request->cli_reg_name !== $add_data->registration_no) {
            return back()->withInput()->with('error', 'Invalid request: Data has been modified illegally!');
        }
        if ($request->name_of_clinic !== $add_data->name) {
            return back()->withInput()->with('error', 'Invalid request: Data has been modified illegally!');
        }
        $gender_child = is_array($request->gender_child) ? implode(',', $request->gender_child) : null;
        if ($action === 'continue') {
            // DB::beginTransaction();
            $patient_add_data = new PatientSurrogacyClinic();
            $patientConn = $patient_add_data->getConnectionName();
            DB::connection($patientConn)->beginTransaction();
            $data['gender_child'] = is_array($request->gender_child) ? implode(',', $request->gender_child) : null;
            $patient_add_data->userid = $add_data->userid_applicant;
            $patient_add_data->clinic_id = $add_data->clinic_id;

            $formData = $request->except(['_token', 'gender_child']);
            $formData['gender_child'] = $gender_child; // Ensure gender_child is a string 

            $patient_add_data->fill($formData);

            $reportId = Crypt::decrypt($request->input('report_id'));
            // dd($reportId);
            $report = PatientPeriodReportingTable::find($reportId);
            // $reportConn = $report->getConnectionName();
            // DB::connection($reportConn)->beginTransaction();
            $patient_add_data->reporting_id = $reportId;
            // if ($report) {
            //     $report->status = 'Live';
            //     $report->save();
            // }

            $patient_add_data->save();
            
            // DB::connection($reportConn)->commit();

            $this->handleFileUploads_surrogacypatient($request, $patient_add_data);
            DB::connection($patientConn)->commit();
            return redirect()->route('clinic.add_patient_surrogacy_application_form')->with('message_update', 'Patient details Submitted successfully.');
        }
        }
        catch (\Illuminate\Validation\ValidationException $e) {
                // dd('test1');
                // DB::rollBack(); // Rollback transaction on validation failure
                DB::connection($patientConn)->rollBack();
                Log::error('Surrogacy patient details form validation failed: ', [
                    'errors' => $e->errors(),
                    'Clinic_id'  => $add_data->clinic_id
                ]);
                // throw $e; // IMPORTANT: sends errors back to Blade
                return redirect()->route('clinic.add_patient_surrogacy_application_form')
                    ->withErrors($e->errors())
                    ->withInput();
            } catch (\Exception $e) {
                // dd('test2');
                // DB::rollBack(); // Rollback on any other error
                DB::connection($patientConn)->rollBack();
                Log::error('Error updating clinic record: ', [
                    'errors' => $e->getMessage(),
                    'Clinic_id'  => $add_data->clinic_id
                ]);

                return redirect()->route('clinic.add_patient_surrogacy_application_form')
                    ->with('upd_error', 'An error occurred while updating. Please Contact support.')
                    ->withInput();
            }
    }

    public function patientsurrogacyForm_view($id)
    {
        if (empty(Session::has('id'))) {

            return redirect()->route('clinic.loginclinicform');
        }
        try {
            $userId = Session::get('id');
            $decryptedId = Crypt::decrypt($id);
            $application = PatientSurrogacyClinic::findOrFail($decryptedId);
            $countryIds = [$application->other_nationality]; // IDs to fetch            
            $countryNames = DB::table('apps_countries')
                ->where('id', $countryIds)
                ->pluck('country_name', 'id'); // Retrieve clinic names with IDs as keys
            $CountryName = $countryNames[$application->other_nationality] ?? null;
            $countryIds = [$application->other_nationality_wife]; // IDs to fetch            
            $countryNames_wife = DB::table('apps_countries')
                ->where('id', $countryIds)
                ->pluck('country_name', 'id'); // Retrieve clinic names with IDs as keys             
            $CountryName_wife = $countryNames_wife[$application->other_nationality_wife] ?? null;
            $app_id = $application->id;
            $dataDocMaster = DB::table('doc_masters')
                ->select('doc_masters.*')
                ->whereIn('doc_type', [
                    'target_file_surrogacypatient_medicalcertificate_docs',
                    'target_file_surrogacypatient_child_medicalcertificate_docs'
                ])
                ->where('status', 1)
                ->get();
            if ($dataDocMaster->isNotEmpty()) {
                foreach ($dataDocMaster as $doc) {
                    $doc_type = $doc->doc_type;
                    $doc_id = $doc->id;
                }
            }
            $get_docfileData = DB::table('doc_file_patient_medical_uploads')
                ->where('doc_file_patient_medical_uploads.app_id', $app_id)
                ->get();
            return view('layouts.clinic.patient_surrogacy_form_view', compact('application', 'get_docfileData', 'CountryName', 'CountryName_wife'));
        } catch (DecryptException $e) {
            // Handle invalid or tampered encrypted ID
            abort(404, 'Invalid ID');
        }
    }

    public function list_surrogacy_patientsearchApplication(Request $request)
    {
        if (!Session::has('id')) {
            return response()->json(['errorMessage' => 'Unauthorized access'], 403);
        }
        $pati_uhid = $request->input('pati_uhid');
        $stateName = Session::get('state');
        if (empty($pati_uhid)) {
            return response()->json(['errorMessage' => 'Please enter a Patient UHID No.']);
        }
        $signupUserIds = signup::where('state', $stateName)->pluck('id')->toArray();
        $patient_list = PatientSurrogacyClinic::with('signupid')
            ->where('pati_uhid', $pati_uhid)
            ->whereIn('userid', $signupUserIds) // Use fetched user IDs
            ->get();
        // $patient_list = PatientSurrogacyClinic::where('pati_uhid', $pati_uhid) // Filter by UHID in patient_artclinic table
        // ->whereHas('signupid', function ($query) use ($stateName) {
        //     $query->where('state', $stateName); // Filter by state in signup table
        // })
        // ->get();
        if ($patient_list->isEmpty()) {
            return response()->json(['errorMessage' => 'No record found.']);
        }
        // Encrypt the IDs before sending to frontend
        $patient_list->transform(function ($patient) {
            $patient->encrypted_id = encrypt($patient->id);
            return $patient;
        });
        return response()->json(['patient_list' => $patient_list]);
    }

    public function patientreportingsurrogacyapplicationform(Request $request)
    {

        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');
        $quarter = QuarterTable::all();
        $countries = countrytable::all();

        $previous_data = PatientSurrogacyClinic::where('userid', $userId)->latest()->first();

        $reportData = PatientPeriodReportingTable::with('quarter')
            ->where(function ($query) {
                $query->where('status', '=', 'Live')
                    ->orWhereNull('status');
            })
            ->latest()
            ->get();

        $patient_list = signup::with('surrogacy_reg_no')
            ->whereHas('surrogacy_reg_no')
            ->where('id', $userId)
            ->first();


        $quarterId = $request->input('quarter');
        $year = $request->input('year');

        // ✅ Default value for view
        $exists = false;

        if ($quarterId && $year) {
            $exists = PatientPeriodReportingTable::where('userid', $userId)
                ->where('clinic_reg_id', $patient_list->surrogacy_reg_no->id)
                ->where('quarter', $quarterId)
                ->where('year', $year)
                ->where('status', 'Live')
                ->exists();

            // Show "already live" view if needed
            if ($exists) {
                return view('layouts/clinic/add_patient_reporting_already_live_period_surrogacy_application_form', compact('quarter', 'reportData', 'exists'));
            }
        }
        return view('layouts/clinic/add_patient_reporting_period_surrogacy_application_form', compact('quarter', 'reportData', 'exists'));
    }

    public function patientreportingsurrogacyapplicationformSubmit(Request $request)
    {
        // dd('sdhshsjsjsj');
        if (!Session::has('id')) {
            return redirect()->back()->withErrors(['error' => 'Session expired. Please login again.']);
        }

        $userId = Session::get('id');
        // $quarter = $request->input('quarter');
        //  $year = $request->input('year');
        // $add_data = signup::with('surrogacy_reg_no')
        //     ->whereHas('surrogacy_reg_no')
        //     ->where('id', $userId)
        //     ->first();  
        // $clinicRegId = $add_data->surrogacy_reg_no->id;

        $status = 'Live';
        $type_clinic = 'ARTSURROGACY';
        $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTSURROGACY')->first();

        $clinicId = $add_data->clinic_id;

        // Check for existing record
        $exists_live = PatientPeriodReportingTable::where('clinic_id', $clinicId)
            ->where('userid', $userId)
            ->where('quarter', $request->quarter)
            ->where('year', $request->year)
            ->where('status', "Live")
            ->exists();
        $alreadyset_quarter = QuarterTable::select('description')->where('quarter', $request->quarter)->first();
        $exists = PatientPeriodReportingTable::where('clinic_id', $clinicId)
            ->where('userid', $userId)
            ->where('quarter', $request->quarter)
            ->where('year', $request->year)
            ->exists();
        if ($exists_live) {
            return view('layouts/clinic/already_existing_period', [
                    'alreadysetYear' => $request->year,
                    'alreadysetquarter'  => $alreadyset_quarter,
                    'exists_live' => $exists_live,
                    'exists' => $exists
                ]);
            // redirect()->route('clinic.add_reporting_already_live_period_patient_clinic_application_form')->with('message', ' Quarter and Year added Successfully');
        }
        if ($exists) {
            return view('layouts/clinic/already_existing_period', [
                    'alreadysetYear' => $request->year,
                    'alreadysetquarter'  => $alreadyset_quarter,
                    'exists_live' => $exists_live,
                    'exists' => $exists
                ]);
            // return redirect()->route('clinic.reporting_period_patient_save_clinic_application_form')->withErrors(['error' => 'This quarter and year already exist2.']);
            // return redirect()->back()->withErrors(['error' => 'This quarter and year already exist.']);
        }

        $patient_add_data = new PatientPeriodReportingTable();

        $patient_add_data->userid = $add_data->userid_applicant;
        $patient_add_data->clinic_id = $add_data->clinic_id;
        $patient_add_data->status = $status;
        $patient_add_data->type_clinic = $type_clinic;
        $patient_add_data->fill($request->except(['_token', 'status']));
        $patient_add_data->ip_address = $request->ip();

        $patient_add_data->save();

        return redirect()->route('clinic.add_reporting_already_live_period_patient_surrogacy_application_form')->with('message', ' Quarter and Year added Successfully');
    }

    private function handleFileUploads_surrogacypatient(Request $request, $appid)
    {

        $allowedExtensions = ['pdf'];
        $docMasters = docmastertable::whereIn('doc_type', [
            'target_file_surrogacypatient_medicalcertificate_docs',
            'target_file_surrogacypatient_child_medicalcertificate_docs',
        ])->where('status', 1)->get();
        foreach ($docMasters as $docMaster) {
            $fileKey = str_replace('target_file_', '', $docMaster->doc_type);
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                //  dd($file);
                $extension = $file->getClientOriginalExtension();
                if (in_array(strtolower($extension), $allowedExtensions)) {
                    $filename = $appid->id . '-' . $docMaster->doc_type . '-' . Carbon::now()->timestamp . '.' . $extension;
                    // $destinationPath = 'D:/xampp/htdocs/artprojfiles/surrogacy_patient_medical_docs';                  
                    $foldername   = 'surrogacy_patient_medical_docs';
                    $baseDir = folderpath($foldername);
                    $application_no_folder = str_replace('/', '_', $appid->clinic_id);
                    $destinationPath = $baseDir . $application_no_folder;
                    if (!File::exists($destinationPath)) {
                        File::makeDirectory($destinationPath, 0755, true);
                    }
                    $filePath = $file->move($destinationPath, $filename);
                    $dbpath = $filename;
                    $userId = Session::get('id');
                    $patient_list = signup::with('surrogacy_reg_no')->whereHas('surrogacy_reg_no')->where('id', $userId)->first();
                    //   $p_clinicid=$patient_list->surrogacy_reg_no->id;                    
                    DocFilePatientUpload::create([
                        'userid' => $patient_list->surrogacy_reg_no->userid,
                        'app_id' => $appid->id,
                        'doc_id' => $docMaster->id,
                        'doc_type' => $docMaster->doc_type,
                        'doc_upload_ref' => $dbpath,
                    ]);
                    // Optionally, log or display the uploaded file details
                    Log::debug('File uploaded:', ['filename' => $filename, 'filePath' => $filePath]);
                } else {
                    // Log or display an error if the extension is not allowed
                    Log::warning('Invalid file extension for doc type:', ['docType' => $docMaster->doc_type, 'extension' => $extension]);
                }
            } else {
                // Log or display if no file was uploaded for the doc type
                Log::warning('No file uploaded for doc type:', ['docType' => $docMaster->doc_type]);
            }
        }
    }

    public function summarypatientsurrogacyapplicationform()
    {

        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        $countries = countrytable::all();
        $quarter = QuarterTable::all();
        // $patient_list = signup::with('surrogacy_reg_no')->whereHas('surrogacy_reg_no')->where('id', $userId)->first();
        $patient_list = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTSURROGACY')->first();
        //         $currentYear = Carbon::now()->year;
        //         $currentMonth = Carbon::now()->month;

        //         // Find which quarter we are currently in
        //         $currentQuarter = '';
        //         if ($currentMonth >= 4 && $currentMonth <= 6) {
        //             $currentQuarter = 'Q1';
        //         } elseif ($currentMonth >= 7 && $currentMonth <= 9) {
        //             $currentQuarter = 'Q2';
        //         } elseif ($currentMonth >= 10 && $currentMonth <= 12) {
        //             $currentQuarter = 'Q3';
        //         } else {
        //             $currentQuarter = 'Q4';
        //         }

        //         // Fetch already submitted quarter-year pairs for this user
        //         $existingSubmissions = SummaryPatientSurrogacyClinic::where('userid', $userId)
        //             ->select('quarter', 'year')
        //             ->get();

        // dd($existingSubmissions);

        //         return view('layouts/clinic/add_summary_patient_surrogacy_application_form', compact(
        //             'patient_list',
        //             'countries',
        //             'currentYear',
        //             'currentQuarter',
        //             'existingSubmissions'
        //         ));


        return view('layouts/clinic/add_summary_patient_surrogacy_application_form', compact('patient_list', 'countries', 'quarter'));
    }

    public function summarypatientsurrogacyapplicationformSubmit(Request $request)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        // $data = $request->all();  
        // dd($data) ;    
        $validator = Validator::make($request->all(), [
            'cli_reg_name' => 'required',
            'name_of_clinic' => 'required',
            'quarter' => 'string|required',
            'year' => 'string|required',
            'no_indian_nationals' => 'integer|required|min:0',
            'no_foreign_nationals' => 'integer|required|min:0',
            'no_ongoing_self_gametes' => 'integer|required|min:0',
            'no_ongoing_oocytes_donor_semen' => 'integer|required|min:0',
            'no_ongoing_semen_donor_oocytes' => 'integer|required|min:0',
            'no_married_couples' => 'integer|required|min:0',
            'no_ongoing_single_woman' => 'integer|required|min:0',
            'no_patient_surrogacy_ongoing' => 'integer|required|min:0',
            'no_completed_self_gametes' => 'integer|required|min:0',
            'no_completed_oocytes_donor_semen' => 'integer|required|min:0',
            'no_completed_semen_donor_oocytes' => 'integer|required|min:0',
            'no_married_couple' => 'integer|required|min:0',
            'no_completed_single_woman' => 'integer|required|min:0',
            'no_patient_surrogacy_completed' => 'integer|required|min:0',
            'no_surrogate_mother_ongoing' => 'integer|required|min:0',
            'no_surrogate_mother_completed' => 'integer|required|min:0',
            'no_surrogate_mothers' => 'integer|required|min:0',
            'no_surgical_retrival_done' => 'integer|required|min:0',
            'no_oocyte_donor' => 'integer|required|min:0',
            'no_self_oocyte_patient' => 'integer|required|min:0',
            'no_oocyte_retrievals' => 'integer|required|min:0',
            'no_patient_semen_cryopreserved' => 'integer|required|min:0',
            'no_patient_oocyte_cryopreserved' => 'integer|required|min:0',
            'no_donor_sperm_cryopreserved' => 'integer|required|min:0',
            'no_donor_oocyte_cryopreserved' => 'integer|required|min:0',
            'no_created_using_self_gametes' => 'integer|required|min:0',
            'no_donor_sperm' => 'integer|required|min:0',
            'no_donor_oocyte' => 'integer|required|min:0',
            // 'no_created_using_both_donor_gamete' => 'integer|required|min:0',
            'no_embryos_cryopreserved' => 'integer|required|min:0',
        ], [
            'cli_reg_name.required' => 'Clinic registration name is required.',
            'name_of_clinic.required' => 'Clinic name is required.',
            'quarter.required' => 'Quarter is required.',
            'year.required' => 'Year is required.',

            'no_indian_nationals.required' => 'Enter number of Indian Nationals.',
            'no_foreign_nationals.required' => 'Enter number ofNumber of Foreign Nationals (OCI cardholders).',

            'no_ongoing_self_gametes.required' => 'Enter number of ongoing treatments using self gametes.',
            'no_ongoing_oocytes_donor_semen.required' => 'Enter number of ongoing treatments with oocyte and donor semen.',
            'no_ongoing_semen_donor_oocytes.required' => 'Enter number of ongoing treatments with semen and donor oocytes.',
            'no_married_couples.required' => 'Enter number of ongoing married couple treatments.',
            'no_ongoing_single_woman.required' => 'Enter number of ongoing single woman treatments.',
            'no_patient_surrogacy_ongoing.required' => 'Enter number of ongoing patient surrogacy treatments.',

            'no_completed_self_gametes.required' => 'Enter number of completed treatments using self gametes.',
            'no_completed_oocytes_donor_semen.required' => 'Enter number of completed treatments with oocyte and donor semen.',
            'no_completed_semen_donor_oocytes.required' => 'Enter number of completed treatments with semen and donor oocytes.',
            'no_married_couple.required' => 'Enter number of completed married couple treatments.',
            'no_completed_single_woman.required' => 'Enter number of completed single woman treatments.',
            'no_patient_surrogacy_completed.required' => 'Enter number of completed patient surrogacy treatments.',

            'no_surrogate_mother_ongoing.required' => 'Enter number of ongoing surrogate mothers.',
            'no_surrogate_mother_completed.required' => 'Enter number of completed surrogate mothers.',
            'no_surrogate_mothers.required' => 'Enter total number of surrogate mothers.',

            'no_surgical_retrival_done.required' => 'Enter number of surgical retrievals done.',
            'no_oocyte_donor.required' => 'Enter number of oocyte donors.',
            'no_self_oocyte_patient.required' => 'Enter number of self-oocyte patients.',
            'no_oocyte_retrievals.required' => 'Enter number of oocyte retrievals.',

            'no_patient_semen_cryopreserved.required' => 'Enter number of patients with semen cryopreserved.',
            'no_patient_oocyte_cryopreserved.required' => 'Enter number of patients with oocytes cryopreserved.',
            'no_donor_sperm_cryopreserved.required' => 'Enter number of donor sperms cryopreserved.',
            'no_donor_oocyte_cryopreserved.required' => 'Enter number of donor oocytes cryopreserved.',

            'no_created_using_self_gametes.required' => 'Enter number of embryos created using self gametes.',
            'no_donor_sperm.required' => 'Enter number of donor sperm used.',
            'no_donor_oocyte.required' => 'Enter number of donor oocytes used.',
            // 'no_created_using_both_donor_gamete.required' => 'Enter number of embryos created using both donor gametes.',
            'no_embryos_cryopreserved.required' => 'Enter number of embryos cryopreserved.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $userId = Session::get('id');
        $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTSURROGACY')
            ->first();
        $clinicId = $add_data->clinic_id;
        // dd($add_data);
        if (!$add_data) {
            return back()->with('error', 'Surrogacy Registration data not found.');
        }
        // Check if the fetched value (hidden input) matches the actual database value
        if ($request->cli_reg_name !== $add_data->registration_no) {
            return back()->withInput()->with('error', 'Invalid request: Data has been modified illegally!');
        }
        if ($request->name_of_clinic !== $add_data->name) {
            return back()->withInput()->with('error', 'Invalid request: Data has been modified illegally!');
        }

        // Check if already exists
        $alreadyExists = SummaryPatientSurrogacyClinic::where('userid', $userId)
            ->where('clinic_id', $clinicId)
            ->where('quarter', $request->quarter)
            ->where('year', $request->year)
            ->exists();

        if ($alreadyExists) {
            // Redirect back with a session flash message
            return redirect()->back()->with('exists', 'Selected Quarter and Year already exists.');
        }


        $patient_add_data = new SummaryPatientSurrogacyClinic();
        $patient_add_data->userid = $add_data->userid_applicant;;
        $patient_add_data->clinic_id = $add_data->clinic_id;
        $patient_add_data->fill($request->except(['_token']));
        // $p_clinicid=$add_data->surrogacy_reg_no->id;
        // dd($patient_add_data)   ;      
        $patient_add_data->save();

        return redirect()->route('clinic.summary_add_patient_surrogacy_application_form')->with('success', 'Updated Successfully');
    }

    public function list_surrogacy_patient_quarter_view_patient()
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $clinic_id = ClinicRegistrationModel::where('userid_applicant', session()->get('id'))
            ->where('status', 1)
            ->where('clinic_type', 'ARTSURROGACY')
            ->value('clinic_id');
        $userId = Session::get('id');
        $quarter = QuarterTable::all();



        $quarter_list = PatientPeriodReportingTable::select('id', 'quarter', 'year','status')
            ->distinct()
            ->where('clinic_id', $clinic_id)
            ->orderBy('year', 'desc')
            ->orderBy('quarter', 'desc')
            ->get();

        $patient_list = DB::connection('patient_clinic_database')
            ->table('patient_surrogacyclinic AS psc')
            ->select(
                'psc.quarter',
                'psc.year',
                DB::raw('COUNT(*) as patient_count')
            )
            ->Join('patient_period_reporting_table AS pprt', 'pprt.id', '=', 'psc.reporting_id')
            ->where('psc.clinic_id', $clinic_id)
            ->groupBy('psc.quarter', 'psc.year')
            ->orderBy('psc.year', 'desc')
            ->orderBy('psc.quarter', 'desc')
            ->get();

        // dd($patient_list);


        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();
        return view('layouts.clinic.list_surrogacy_patient_quarter_view_patient', compact('quarterDescriptions', 'patient_list', 'quarter_list'));
    }

    public function showUHIDs_surrogacy($encrypted)
    {
        $userId = Session::get('id');
        // $quarter = $request->quarter;
        //  $year = $request->year;
        $clinic_id = ClinicRegistrationModel::where('userid_applicant', session()->get('id'))
            ->where('status', 1)
            ->where('clinic_type', 'ARTSURROGACY')
            ->value('clinic_id');
        $decrypted = Crypt::decrypt($encrypted);
        [$quarter, $year] = explode('|', $decrypted);

        $data = PatientSurrogacyClinic::select(
            'patient_surrogacyclinic.id',
            'patient_surrogacyclinic.pati_uhid',
            'patient_surrogacyclinic.treatment_type',
            'patient_surrogacyclinic.types_of_treat',
            'patient_surrogacyclinic.tratment_Outcome',
            'patient_surrogacyclinic.art_types_of_treat',
            'patient_surrogacyclinic.art_treat_outcomes',
            'patient_period_reporting_table.status'
        )
            ->join('patient_period_reporting_table', function ($join) {
                $join->on('patient_period_reporting_table.clinic_id', '=', 'patient_surrogacyclinic.clinic_id')
                    ->on('patient_period_reporting_table.year', '=', 'patient_surrogacyclinic.year')
                    ->on('patient_period_reporting_table.quarter', '=', 'patient_surrogacyclinic.quarter')
                    ->on('patient_period_reporting_table.id', '=', 'patient_surrogacyclinic.reporting_id');
            })
            ->where('patient_surrogacyclinic.quarter', $quarter)
            ->where('patient_surrogacyclinic.year', $year)
            ->where('patient_surrogacyclinic.clinic_id', $clinic_id)
            ->get();
        // dd($data);   

        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();
        return view('layouts.clinic.list_surrogacy_patient_quarter_view_patient_uhid', compact('quarter', 'year', 'data', 'quarterDescriptions'));
    }

    public function editPatientsurrogacy(Request $request, $uhid = NULL)
    {

        $userId = Session::get('id');
        $countries = countrytable::all();
        $decryptedUhid = Crypt::decrypt($uhid);
        $add = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTSURROGACY')->first();
        // dd($decryptedUhid);
        // $uhidDetails = PatientSurrogacyClinic::where('pati_uhid',$decryptedUhid)->where('clinic_id', $add->clinic_id)->first(); // Fetch the UHID data
        $uhidDetails = PatientSurrogacyClinic::where('id', $decryptedUhid)->where('clinic_id', $add->clinic_id)->first(); // Fetch the UHID data
        // dd($uhidDetails);

        // Fetch existing uploaded docs
        $existingDocs = DocFilePatientUpload::where('app_id', $uhidDetails->id)
            ->pluck('doc_upload_ref', 'doc_type') // ['target_file_...' => 'filename.pdf']
            ->toArray();

        //dd($existingDocs);



        // $reportData = PatientPeriodReportingTable::with('quarter')
        // ->where(function ($query) {
        //     $query->where('status', '=', 'Live')
        //         ->orWhereNull('status');
        // })
        // ->latest()
        // ->get(); 
        // $reporting_data = PatientPeriodReportingTable::where('status', 'Live')->where('userid',$userId)->where('clinic_id', $add->clinic_id)->first();
        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();

        $available_quarters = PatientPeriodReportingTable::where('status', 'Live')
            ->where('userid', $userId)
            ->where('clinic_id', $add->clinic_id)
            ->select('quarter')
            ->first();

        if ($available_quarters) {
            $available_quarters->description = $quarterDescriptions[$available_quarters->quarter] ?? 'Q';
        }

        $available_years = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $add->clinic_id)
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->get();
        $clinic_id = $add->clinic_id;
        return view('layouts.clinic.edit_patient_surrogacy_application_form', compact('uhidDetails', 'available_quarters', 'available_years', 'countries', 'existingDocs', 'clinic_id'));
    }

    public function list_surrogacyclinic_patient_quarter_view()
    {
        //  dd('sdsh');
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        if (empty(session()->has('patient_surrogacy_registration_no') && session()->has('id'))) {

            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        $quarter = QuarterTable::all();

        $add = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('clinic_type', 'ARTSURROGACY')
            ->where('status', 1)
            ->first();
        $clinicId = $add->clinic_id;
        // $reportData = PatientPeriodReportingTable::with('quarter')
        // ->where(function ($query) {
        //     $query->where('status', '=', 'Live')
        //           ->orWhereNull('status');
        // })
        // ->latest()
        // ->get(); 
        $patient_list = SummaryPatientSurrogacyClinic::where('userid', $userId)->where('clinic_id', $clinicId)->get();
        $reporting_data = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $clinicId)->first();
        // dd($reporting_data->id);
        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();

        $available_quarters = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $clinicId)
            ->select('quarter')
            ->distinct()
            ->orderBy('quarter')
            ->get()
            ->map(function ($q) use ($quarterDescriptions) {
                return [
                    'id' => $q->quarter,
                    'description' => $quarterDescriptions[$q->quarter] ?? $q->quarter,
                ];
            });

        $available_years = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $clinicId)
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->get();

        $exists = false;

        //  if ($quarterId && $year) {
        $exists = PatientPeriodReportingTable::where('clinic_id', $clinicId)
            ->where('userid', $userId)
            // ->where('quarter', $quarterId)
            // ->where('year', $year)
            ->where('status', 'Live')
            ->where('status', 'Finished')
            ->exists();

        return view('layouts.clinic.list_surrogacyclinic_patient_quarter_view', compact(
            'quarter',
            'exists',
            'reporting_data',
            'available_quarters',
            'available_years',
            'patient_list'
        ));
    }

    public function viewSummaryPatientsurrogacy($id)
    {
        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');
        $en_id = Crypt::decrypt($id);
        $report = SummaryPatientSurrogacyClinic::findOrFail($en_id);

        // Generate PDF from a Blade view
        $pdf = Pdf::loadView('layouts.clinic.view_summary_patient_surrogacy_application_form', compact('report'));

        return $pdf->download('surrogacy_summary_' . $report->year . '_Q' . $report->quarter . '.pdf');
    }

    public function editSummaryPatientsurrogacy($id)
    {
        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        // $patient_list = signup::with('surrogacy_reg_no')->whereHas('surrogacy_reg_no')->where('id', $userId)->get();
        // $patient_list = SummaryPatientArtLevelTwoClinic::where('userid',$userId)->get(); 
        $patient_list = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTSURROGACY')
            ->first();
        $en_id = Crypt::decrypt($id);
        $report = SummaryPatientSurrogacyClinic::findOrFail($en_id);
        // $report = SummaryPatientSurrogacyClinic::findOrFail($id);

        return view('layouts.clinic.edit_summary_patient_surrogacy_application_form', compact('report'))->with('success', 'updated successfully');
    }

    public function viewPatientSurrogacy(Request $request, $uhid = NULL)
    {
        $userId = Session::get('id');
        $countries = countrytable::all();
        $decryptedUhid = Crypt::decrypt($uhid);
        $clinic = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTSURROGACY')->first();

        // $patient = PatientSurrogacyClinic::select('patient_surrogacyclinic.*', doc_file_patient_medical_uploads.doc_upload_ref, 'country_husband.country_name as husband_country_name',
        // 'country_wife.country_name as wife_country_name')
        // ->join('doc_file_patient_medical_uploads', function($join) {
        //     $join->on('doc_file_patient_medical_uploads.app_id', '=', 'patient_surrogacyclinic.id')
        //         ->on('doc_file_patient_medical_uploads.userid', '=', 'patient_surrogacyclinic.userid');
        // })
        // ->leftJoin('art_dbnew_testing.apps_countries as country_husband','country_husband.id', '=', 'patient_surrogacyclinic.other_nationality' )
        // ->leftJoin('art_dbnew_testing.apps_countries as country_wife', 'country_wife.id',  '=','patient_surrogacyclinic.other_nationality_wife' )
        // ->where('patient_surrogacyclinic.pati_uhid', $decryptedUhid)
        // ->where('patient_surrogacyclinic.clinic_id', $clinic->clinic_id)
        // ->first();

        $patient = PatientSurrogacyClinic::select(
            'patient_surrogacyclinic.*',
            DB::raw('IFNULL(doc_file_patient_medical_uploads.doc_upload_ref, "") as doc_upload_ref'),
            'country_husband.country_name as husband_country_name',
            'country_wife.country_name as wife_country_name'
        )
            ->leftJoin('doc_file_patient_medical_uploads', function ($join) {
                $join->on('doc_file_patient_medical_uploads.app_id', '=', 'patient_surrogacyclinic.id')
                    ->on('doc_file_patient_medical_uploads.userid', '=', 'patient_surrogacyclinic.userid');
            })
            ->leftJoin('art_dbnew_testing.apps_countries as country_husband', function ($join) {
                $join->on('country_husband.id', '=', 'patient_surrogacyclinic.other_nationality');
            })
            ->leftJoin('art_dbnew_testing.apps_countries as country_wife', function ($join) {
                $join->on('country_wife.id', '=', 'patient_surrogacyclinic.other_nationality_wife');
            })
            ->where('patient_surrogacyclinic.id', $decryptedUhid)
            ->where('patient_surrogacyclinic.clinic_id', $clinic->clinic_id)
            ->first();



        $existingDocs = DocFilePatientUpload::where('app_id', $patient->id)->get();


        $quarter = QuarterTable::select('description')->where('quarter', $patient->quarter)->first();

        $aq = $quarter ? $quarter->description : '';

        // dd($patient);
        return view('layouts.clinic.surrogacy_patient_view', compact('patient', 'clinic', 'countries', 'decryptedUhid', 'aq', 'existingDocs'));
    }
    public function summarypatientsurrogacyapplicationformSubmitedit(Request $request)
    {

        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }

        $data = $request->all();



        $validator = Validator::make($request->all(), [
            'cli_reg_name' => 'required',
            'name_of_clinic' => 'required',
            'quarter' => 'string|required',
            'year' => 'string|required',
            'no_foreign_nationals' => 'required|integer|min:0',
            'no_patient_undergoing_procedure' => 'integer|required|min:0',
            'no_ongoing_self_gametes' => 'integer|required|min:0',
            'no_ongoing_oocytes_donor_semen' => 'integer|required|min:0',
            'no_ongoing_semen_donor_oocytes' => 'integer|required|min:0',
            'no_married_couples' => 'integer|required|min:0',
            'no_ongoing_single_woman' => 'integer|required|min:0',
            'no_patient_surrogacy_ongoing' => 'integer|required|min:0',
            'no_completed_self_gametes' => 'integer|required|min:0',
            'no_completed_oocytes_donor_semen' => 'integer|required|min:0',
            'no_completed_semen_donor_oocytes' => 'integer|required|min:0',
            'no_married_couple' => 'integer|required|min:0',
            'no_completed_single_woman' => 'integer|required|min:0',
            'no_patient_surrogacy_completed' => 'integer|required|min:0',
            'no_surrogate_mother_ongoing' => 'integer|required|min:0',
            'no_surrogate_mother_completed' => 'integer|required|min:0',
            'no_surrogate_mothers' => 'integer|required|min:0',
            'no_surgical_retrival_done' => 'integer|required|min:0',
            'no_oocyte_donor' => 'integer|required|min:0',
            'no_self_oocyte_patient' => 'integer|required|min:0',
            'no_oocyte_retrievals' => 'integer|required|min:0',
            'no_patient_semen_cryopreserved' => 'integer|required|min:0',
            'no_patient_oocyte_cryopreserved' => 'integer|required|min:0',
            'no_donor_sperm_cryopreserved' => 'integer|required|min:0',
            'no_donor_oocyte_cryopreserved' => 'integer|required|min:0',
            'no_created_using_self_gametes' => 'integer|required|min:0',
            'no_donor_sperm' => 'integer|required|min:0',
            'no_donor_oocyte' => 'integer|required|min:0',
            // 'no_created_using_both_donor_gamete' => 'integer|required|min:0',
            'no_embryos_cryopreserved' => 'integer|required|min:0',
        ], [
            'cli_reg_name.required' => 'Clinic registration name is required.',
            'name_of_clinic.required' => 'Clinic name is required.',
            'quarter.required' => 'Quarter is required.',
            'year.required' => 'Year is required.',

            'no_foreign_nationals.required' => 'Enter number of foreign nationals.',
            'no_patient_undergoing_procedure.required' => 'Enter number of patients undergoing procedures.',

            'no_ongoing_self_gametes.required' => 'Enter number of ongoing treatments using self gametes.',
            'no_ongoing_oocytes_donor_semen.required' => 'Enter number of ongoing treatments with oocyte and donor semen.',
            'no_ongoing_semen_donor_oocytes.required' => 'Enter number of ongoing treatments with semen and donor oocytes.',
            'no_married_couples.required' => 'Enter number of ongoing married couple treatments.',
            'no_ongoing_single_woman.required' => 'Enter number of ongoing single woman treatments.',
            'no_patient_surrogacy_ongoing.required' => 'Enter number of ongoing patient surrogacy treatments.',

            'no_completed_self_gametes.required' => 'Enter number of completed treatments using self gametes.',
            'no_completed_oocytes_donor_semen.required' => 'Enter number of completed treatments with oocyte and donor semen.',
            'no_completed_semen_donor_oocytes.required' => 'Enter number of completed treatments with semen and donor oocytes.',
            'no_married_couple.required' => 'Enter number of completed married couple treatments.',
            'no_completed_single_woman.required' => 'Enter number of completed single woman treatments.',
            'no_patient_surrogacy_completed.required' => 'Enter number of completed patient surrogacy treatments.',

            'no_surrogate_mother_ongoing.required' => 'Enter number of ongoing surrogate mothers.',
            'no_surrogate_mother_completed.required' => 'Enter number of completed surrogate mothers.',
            'no_surrogate_mothers.required' => 'Enter total number of surrogate mothers.',

            'no_surgical_retrival_done.required' => 'Enter number of surgical retrievals done.',
            'no_oocyte_donor.required' => 'Enter number of oocyte donors.',
            'no_self_oocyte_patient.required' => 'Enter number of self-oocyte patients.',
            'no_oocyte_retrievals.required' => 'Enter number of oocyte retrievals.',

            'no_patient_semen_cryopreserved.required' => 'Enter number of patients with semen cryopreserved.',
            'no_patient_oocyte_cryopreserved.required' => 'Enter number of patients with oocytes cryopreserved.',
            'no_donor_sperm_cryopreserved.required' => 'Enter number of donor sperms cryopreserved.',
            'no_donor_oocyte_cryopreserved.required' => 'Enter number of donor oocytes cryopreserved.',

            'no_created_using_self_gametes.required' => 'Enter number of embryos created using self gametes.',
            'no_donor_sperm.required' => 'Enter number of donor sperm used.',
            'no_donor_oocyte.required' => 'Enter number of donor oocytes used.',
            // 'no_created_using_both_donor_gamete.required' => 'Enter number of embryos created using both donor gametes.',
            'no_embryos_cryopreserved.required' => 'Enter number of embryos cryopreserved.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $quarter = QuarterTable::all();
        //dd($request->id);
        $userId = Session::get('id');
        $patient_list = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTSURROGACY')
            ->get();
        //  dd($request->id);  
        // Find the record to update
        $report = SummaryPatientSurrogacyClinic::findOrFail($request->id);
        // dd($report);
        // Update the record with new data
        $report->update($request->all());

        $reportData = PatientPeriodReportingTable::with('quarter')
            ->where(function ($query) {
                $query->where('status', '=', 'Live')
                    ->orWhereNull('status');
            })
            ->latest()
            ->get();

        return redirect()->route('clinic.list_surrogacyclinic_patient_quarter_view', compact('quarter', 'reportData', 'patient_list'))->with('success', 'updated successfully!');
    }
    public function patientsurrogacyapplicationformSubmiteditpatient(Request $request)
    {
        try{
        // dd($request->all());
        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }
        DB::beginTransaction();

        if ($request->input('updatev') == 'deletebtn') {

            PatientSurrogacyClinic::where('id', $request->p_id)->delete();

            return redirect()
                ->route('clinic.list_surrogacy_patient_quarter_view_patient')
                ->with('message_update', 'Patient details deleted successfully.');
        }
        $action = $request->input('submit');
        $rule1 = [];
        $messages1 = [];
        if ($request->treatment_type == 'surrogacy') {
            $rule1 = [
                'case_of' => 'required|in:one,two',
                'nationality' => 'nullable|required_if:case_of,one|in:Indian,OCI Card Holders',
                'other_nationality' => 'nullable|required_if:nationality,OCI Card Holders|exists:apps_countries,id',
                'nationality_wife' => 'required|in:Indian,OCI Card Holders',
                'other_nationality_wife' => 'nullable|required_if:nationality_wife,OCI Card Holders|exists:apps_countries,id',
                'age' => 'nullable|required_if:case_of,one|numeric',
                'wife_age' => 'nullable|required_if:case_of,one|numeric',
                'age_of_women' => 'nullable|required_if:case_of,two|numeric',
                'num_pre_child' => 'required|string',
                'child_give_details' => 'nullable|required_if:num_pre_child,Yes|string',
                'uterus_ab' => 'in:Y,N',
                'ivf_failure' => 'in:Y,N',
                'preg_loss' => 'in:Y,N',
                'life_threat' => 'in:Y,N',
                'male_factor' => 'in:Y,N',
                // 'undertaken_other'=>'nullable|required_if:art_proc_undertaken,Others|string',
                'types_of_treat' => 'required|in:Surrogacy using self gametes,Surrogacy using donor gametes',
                'types_of_treat1' => 'nullable|required_if:types_of_treat,Surrogacy using donor gametes|in:Self Oocyte & Donor Sperm,Donor Oocyte & Self Sperm',
                'surrogate_mother_age' => 'required|integer|min:25|max:35',
                'total_nun_cycles' => 'required|numeric',
                'no_cycles' => 'required|numeric',
                'Cycle_fail_reason' => 'nullable|required_if:no_cycles,>,1|string',
                'art_undertaken' => 'required|string',
                'art_undertaken_other' => 'nullable|required_if:art_undertaken,Others|string|nullable',

                'cyc_canc_failure_reason' => 'nullable|string',
                'tratment_Outcome' => 'required|in:Pregnant,Not Pregnant',
                'complicatoins_if_any' => 'nullable|string',
                'medical_surrogacy' => 'required|string',
                'remark' => 'nullable|string',
                'declaration' => 'required',
                'declaration1' => 'nullable|required_if:num_pre_child,No',
                // 'declaration3' => 'nullable|required_if:types_of_treat1,Donor Oocyte & Self Sperm',
                // 'declaration4' => [
                //     Rule::requiredIf(function () use ($request) {
                //         return in_array($request->types_of_treat1, [
                //             "Self Oocyte & Donor Sperm",
                //             "Donor Oocyte & Self Sperm"
                //         ]);
                //     })
                // ],
                'declaration3' => [
                    Rule::requiredIf(function () use ($request) {
                        return (
                            $request->types_of_treat === "Surrogacy using donor gametes"
                            && in_array($request->types_of_treat1, [
                                // "Self Oocyte & Donor Sperm",
                                "Donor Oocyte & Self Sperm"
                            ])
                        ) && $request->case_of === 'one'; // 👈 yaha change
                    }),
                ],
                'declaration4' => [
                    Rule::requiredIf(function () use ($request) {
                        return in_array($request->types_of_treat == "Surrogacy using donor gametes" && $request->types_of_treat1, [
                            "Self Oocyte & Donor Sperm",
                            "Donor Oocyte & Self Sperm"
                        ]);
                    })
                ],

                // 'declaration4'=> 'required',
            ];
            $messages1 = [
                'previous_treatment.required' => 'Please select whether previous treatment was taken.',
                'previous_treatment.in' => 'Invalid value selected for previous treatment.',

                'case_of.required' => 'Please select the case type.',
                'case_of.in' => 'Invalid case type selected.',
                'nationality.required_if' => 'Please select nationality of the Husband.',
                'nationality.in' => 'Nationality must be either Indian or OCI Card Holders.',
                'other_nationality.required_if' => 'Please select the country when nationality is OCI Card Holders.',
                'other_nationality.exists' => 'Selected nationality is invalid.',
                'nationality_wife.required' => 'Please select nationality of the Wife.',
                'nationality_wife.in' => 'Wife nationality must be either Indian or OCI Card Holders.',
                'other_nationality_wife.required_if' => 'Please select wife country when nationality is OCI Card Holders.',
                'other_nationality_wife.exists' => 'Selected wife nationality country is invalid.',
                'wife_age.required_if' => 'Please enter the age of wife.',
                'wife_age.numeric' => 'Age of wife must be a number.',
                'age.required_if' => 'Please enter the age of husband.',
                'age.numeric' => 'Age of husband must be a number.',
                'age_of_women.required_if' => 'Please enter the age of woman.',
                'age_of_women.numeric' => 'Age of woman must be a number.',

                'uterus_ab.in' => 'Invalid selection for Uterus Abnormalities.',
                'ivf_failure.in' => 'Invalid selection for Repeated IVF failure or Recurrent implantation failure.',
                'preg_loss.in' => 'Invalid selection for Multiple Pregnancy Loss.',
                'life_threat.in' => 'Invalid selection for Life threatening illness',
                'num_pre_child.required' => 'Having Surviving Child cannot be blank.',
                'num_pre_child.string' => 'Having Surviving Child must be valid text.',
                'male_factor.in' => 'Invalid selection for male factor.',
                'medical_surrogacy.required' => 'Please provide medical reason for opting surrogacy.',
                // 'undertaken_other.required_if' => 'Please specify the ART procedure when "Others" is selected.',
                'types_of_treat.required' => 'Please select the type of treatment.',
                'types_of_treat.in' => 'Invalid treatment type selected.',
                'types_of_treat1.required_if' => 'Please select donor type when donor gametes are used.',
                'types_of_treat1.in' => 'Invalid donor type selected.',
                'surrogate_mother_age.required' => 'Surrogate Mother Age cannot be blank.',
                'art_undertaken.required' => 'ART Procedure Undertaken cannot be blank.',
                'art_undertaken_other.required_if' => 'Please specify other ART Procedures',
                'no_cycles.required' => 'Please enter number of cycles undertaken.',
                'no_cycles.numeric' => 'Number of cycles must be numeric.',
                'Cycle_fail_reason.required_if' => 'Please specify reason for Cycle Cancellation',
                'cyc_canc_failure_reason.required' => 'Please provide reason for cancellation.',
                'cyc_canc_failure_reason.string' => 'Reason must be valid text.',
                'tratment_Outcome.required' => 'Please select treatment outcome.',
                'tratment_Outcome.in' => 'Invalid treatment outcome selected.',
                'complicatoins_if_any.string' => 'Complications must be valid text.',
                'remark.string' => 'Remark must be valid text.',
                'declaration.required' => 'From Surrogate Mother that she has not acted as a surrogate mother more than once in her lifetime.',
                'declaration1.required_if' => 'From intending couple or single woman (widow or divorcee) that they/she do/does not have any surviving child biologically or through adoption or through surrogacy earlier.',
                'declaration1.accepted' => 'Please accept the declaration to continue.',
                'declaration3.required' => 'Please click that Affidavit/undertaking** has been taken on record From Oocyte Donor that she has not donated oocytes more than once in her life time.',
                'declaration4.required' => 'Please Click on Undertaking that Affidavit/undertking** has been taken on record From the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman.',
            ];
        } elseif ($request->treatment_type == 'art_treatment') {
            // dd($request->all());
            $rule1 = [
                'art_case_of' => 'required|in:one,two',
                'art_nationality' => 'nullable|required_if:art_case_of,one|in:Indian,Foreigner',
                'art_other_nationality' => 'nullable|required_if:art_nationality,Foreigner|exists:apps_countries,id',
                'art_nationality_wife' => 'required|in:Indian,Foreigner',
                'art_other_nationality_wife' => 'nullable|required_if:art_nationality_wife,Foreigner|exists:apps_countries,id',
                'art_age_hus_wife' => 'nullable|required_if:art_case_of,one|numeric',
                'art_wife_age' => 'nullable|required_if:art_case_of,one|numeric',
                'art_age_of_women' => 'nullable|required_if:art_case_of,two|numeric',
                'art_male_factor' => 'in:Y,N',
                'art_female_factor' => 'in:Y,N',
                'art_unexplained' => 'in:Y,N',
                'art_cause_of_infretily' => 'required|string',
                'art_proc_undertaken' => 'required|string',
                'art_undertaken_other_2' => 'nullable|required_if:art_proc_undertaken,Others',
                'art_types_of_treat' => 'required|in:ART Treatment using self gametes,ART Treatment using donor gametes',
                'art_types_of_treat1' => 'nullable|required_if:art_types_of_treat,ART Treatment using donor gametes|in:Oocyte Donation,Sperm Donation,Both Oocyte Donation & Sperm Donation',
                'art_total_num_of_cyc' => 'required|numeric',
                'art_no_cycles' => 'required|numeric',
                'art_cyc_canc_failure_reason' => 'nullable|string',
                'art_treat_outcomes' => 'required|in:Pregnant,Not Pregnant',
                'art_complicatoins_if_any' => 'nullable|string',
                'art_remark' => 'nullable|string',
                'art_declaration' => [
                    Rule::requiredIf(function () use ($request) {
                        return $request->types_of_treat == "ART Treatment using donor gametes" &&
                            in_array($request->types_of_treat1, [
                                "Oocyte Donation",
                                "Both Oocyte Donation & Sperm Donation"
                            ]);
                    })
                ],
                'art_declaration1' => [
                    Rule::requiredIf(function () use ($request) {
                        return $request->types_of_treat == "ART Treatment using donor gametes" && in_array($request->types_of_treat1, [
                            "Oocyte Donation",
                            "Sperm Donation",
                            "Both Oocyte Donation & Sperm Donation"
                        ]);
                    })
                ],
                // 'preganancy_outcome' => 'nullable|required_if:treat_outcomes,Pregnant|string',
                //'l_birth' => 'nullable|required_if:preganancy_outcome,live birth|string',
                // 'gender_child' => 'nullable|required_if:l_birth,Singleton,Twin,Stillbirth',
                //'other_gender' => 'nullable|required_if:l_birth,Higher Order|string',
            ];
            $messages1 = [
                'previous_treatment.required' => 'Please select whether previous treatment was taken.',
                'previous_treatment.in' => 'Invalid value selected for previous treatment.',
                'art_case_of.required' => 'Please select the case type.',
                'art_case_of.in' => 'Invalid case type selected.',
                'art_nationality.required_if' => 'Please select nationality of the Husband.',
                'art_nationality.in' => 'Nationality must be either Indian or Foreigner.',
                'art_other_nationality.required_if' => 'Please select the country when nationality is Foreigner.',
                'art_other_nationality.exists' => 'Selected nationality is invalid.',
                'art_nationality_wife.required' => 'Please select nationality of the Wife.',
                'art_nationality_wife.in' => 'Wife nationality must be either Indian or Foreigner.',
                'art_other_nationality_wife.required_if' => 'Please select wife country when nationality is Foreigner.',
                'art_other_nationality_wife.exists' => 'Selected wife nationality country is invalid.',
                'art_age_hus_wife.required_if' => 'Please enter age of husband.',
                'art_age_hus_wife.numeric' => 'Age of husband must be a number.',
                'art_wife_age.required_if' => 'Please enter age of wife.',
                'art_wife_age.numeric' => 'Age of wife must be a number.',
                'art_age_of_women.required_if' => 'Please enter age of woman.',
                'art_age_of_women.numeric' => 'Age of woman must be a number.',
                'art_male_factor.in' => 'Invalid selection for male factor.',
                'art_female_factor.in' => 'Invalid selection for female factor.',
                'art_unexplained.in' => 'Invalid selection for unexplained infertility.',
                'art_cause_of_infretily.required' => 'Please enter the cause of infertility.',
                'art_proc_undertaken.required' => 'Please select the ART procedure undertaken.',
                'art_proc_undertaken.in' => 'Invalid ART procedure selected.',
                'art_undertaken_other.required_if' => 'Please specify the ART procedure when "Others" is selected.1',
                'art_types_of_treat.required' => 'Please select the type of treatment.',
                'art_types_of_treat.in' => 'Invalid treatment type selected.',
                'art_types_of_treat1.required_if' => 'Please select donor type when donor gametes are used.',
                'art_types_of_treat1.in' => 'Invalid donor type selected.',
                'art_total_num_of_cyc.required' => 'Please enter total number of cycles.',
                'art_total_num_of_cyc.numeric' => 'Total number of cycles must be numeric.',
                'art_no_cycles.required' => 'Please enter number of cycles undertaken.',
                'art_no_cycles.numeric' => 'Number of cycles must be numeric.',
                'art_cyc_canc_failure_reason.required' => 'Please provide reason for cancellation.',
                'art_cyc_canc_failure_reason.string' => 'Reason must be valid text.',
                'art_treat_outcomes.required' => 'Please select treatment outcome.',
                'art_treat_outcomes.in' => 'Invalid treatment outcome selected.',
                'art_complicatoins_if_any.string' => 'Complications must be valid text.',
                'art_remark.string' => 'Remark must be valid text.',
                'art_declaration.required' => 'Please click that affidavit/undertaking** has been taken on record from Oocyte Donor that she has not donated oocytes more than once in her life time.',
                'art_declaration.accepted' => 'You must confirm the Oocyte Donor declaration.',
                'art_declaration1.required' => 'Please click on undertaking that affidavit/undertaking** has been taken on record from the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman or clinic and clinic has not used the sperm/oocyte of the same donor for more than one commissioning couple.',
                'art_declaration1.accepted' => 'You must confirm the ART Clinic declaration.',
            ];
        }
        $rule2 = [
                'name_of_clinic' => 'required|string',
                'pati_uhid' => 'required|string|max:15',
                'treatment_type' => 'required|in:art_treatment,surrogacy'
            ];
        $messages2 = [
                'pati_uhid.required' => 'Patient UHID is required.',
                'pati_uhid.max' => 'Patient UHID must not exceed 15 characters.',
                'name_of_clinic.required' => 'Please enter the name of the clinic.',
                'name_of_clinic.string' => 'Clinic name must be valid text.',
                'treatment_type.required' => 'Please select the Treatment type.',
            ];
        $rule = array_merge($rule1, $rule2);
        $messages = array_merge($messages1, $messages2);
        $request->validate($rule, $messages);
        $userId = Session::get('id');
        // $add_data = signup::with('surrogacy_reg_no')->whereHas('surrogacy_reg_no')->where('id', $userId)->first();
        $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTSURROGACY')->first();

        if (!$add_data) {
            return back()->with('error', 'Surrogacy Clinic Registration data not found.');
        }

        // Security validation
        if (
            trim($request->cli_reg_name) !== trim($add_data->registration_no) ||
            trim($request->name_of_clinic) !== trim($add_data->name)
        ) {
            return back()->withInput()->with('error', 'Invalid request: Data has been modified illegally!');
        }


        $patient_list = PatientSurrogacyClinic::select('quarter', 'year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->orderBy('quarter', 'desc')
            ->get();

        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();
        // Find existing patient ART record
        //$reportId = PatientArtclinic::findOrFail($request->id);

        // $reportId = $request->input('report_id');
        $p_id = $request->input('p_id');
        //  dd($reportId);
        $patient_add_data = PatientSurrogacyClinic::find($p_id);
        //  dd($patient_add_data);
        if (!$patient_add_data) {
            return back()->with('error', 'Patient data not found for update.');
        }

        // Convert gender_child to string
        $formData = $request->except(['_token']);
        // dd($formData);
        // $formData['gender_child'] = is_array($request->gender_child) ? implode(',', $request->gender_child) : $request->gender_child;

        // Update reporting table status
        // $report = PatientPeriodReportingTable::find($reportId);
        // if ($report) {
        //     $report->status = 'Live';
        //     $report->save();
        // }

        // Add tracking IDs
        if ($request->treatment_type === 'surrogacy') {

            $formData['userid'] = $add_data->userid_applicant;
            $formData['clinic_id'] = $add_data->clinic_id;
            // $formData['reporting_id'] = $reportId;
            $formData['male_factor']   = !empty($formData['male_factor']) ? 'Y' : 'N';
            $formData['uterus_ab']      = !empty($formData['uterus_ab']) ? 'Y' : 'N';
            $formData['ivf_failure']   = !empty($formData['ivf_failure']) ? 'Y' : 'N';
            $formData['preg_loss']     = !empty($formData['preg_loss']) ? 'Y' : 'N';
            $formData['life_threat']  = !empty($formData['life_threat']) ? 'Y' : 'N';
            $formData['declaration'] = $request->input('declaration', null);
            $formData['declaration1'] = $request->input('declaration1', null);
            $formData['declaration3'] = $request->input('declaration3', null);
            $formData['declaration4'] = $request->input('declaration4', null);

        }
        if ($request->treatment_type === 'art_treatment') {

            $formData['userid'] = $add_data->userid_applicant;
            $formData['clinic_id'] = $add_data->clinic_id;
            // $formData['reporting_id'] = $reportId;
            $formData['art_male_factor']   = !empty($formData['art_male_factor']) ? 'Y' : 'N';
            $formData['art_female_factor']      = !empty($formData['art_female_factor']) ? 'Y' : 'N';
            $formData['art_unexplained']   = !empty($formData['art_unexplained']) ? 'Y' : 'N';
            $formData['art_declaration'] = $request->input('art_declaration', null);
            $formData['art_declaration1'] = $request->input('art_declaration1', null);
        }
        // Update patient clinic data
        $patient_add_data->fill($formData);
        // dd($patient_add_data);


        $patient_add_data->save();

        $this->updateOnlyFile_surrogacypatient($request, $patient_add_data);

        // dd('sdfdsfsd');
        DB::commit();
        return redirect()->route('clinic.list_surrogacy_patient_quarter_view_patient', compact('patient_list', 'quarterDescriptions'))->with('message_update', 'Patient details updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
                // dd('test1');
                DB::rollBack(); // Rollback transaction on validation failure
                Log::error('Surrogacy patient details form validation failed: ', [
                    'errors' => $e->errors(),
                    'Clinic_id'  => $add_data->clinic_id
                ]);
                // throw $e; // IMPORTANT: sends errors back to Blade
                return redirect()->route('clinic.list_surrogacy_patient_quarter_view_patient')
                    ->withErrors($e->errors())
                    ->withInput();
            } catch (\Exception $e) {
                // dd('test2');
                DB::rollBack(); // Rollback on any other error
                Log::error('Error updating clinic record: ', [
                    'errors' => $e->getMessage(),
                    'Clinic_id'  => $add_data->clinic_id
                ]);

                return redirect()->route('clinic.list_surrogacy_patient_quarter_view_patient')
                    ->with('upd_error', 'An error occurred while updating. Please Contact support.')
                    ->withInput();
            }

    }

    public function patientalreadylivereportingsurrogacyapplicationform(Request $request)
    {

        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');
        $quarter = QuarterTable::all();
        $quarter = QuarterTable::all();

        // $patient_list = PatientSurrogacyclinic::where('userid',$userId)->get();
        $add = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTSURROGACY')->first();

        $reporting_data = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $add->clinic_id)->latest()->first();

        // dd($reporting_data);
        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();

        $available_quarters = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $add->clinic_id)
            ->select('quarter')
            ->distinct()
            ->orderBy('quarter')
            ->get()
            ->map(function ($q) use ($quarterDescriptions) {
                return [
                    'id' => $q->quarter,
                    'description' => $quarterDescriptions[$q->quarter] ?? 'Q' . $q->quarter,
                ];
            });
        $available_years = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $add->clinic_id)
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->get();

        return view('layouts/clinic/add_patient_reporting_already_live_period_surrogacy_application_form', compact('quarter', 'reporting_data', 'available_quarters', 'available_years'));
    }

    private function updateOnlyFile_surrogacypatient(Request $request, $appid)
    {

        $allowedExtensions = ['pdf'];
        $docMasters = docmastertable::whereIn('doc_type', [
            'target_file_surrogacypatient_medicalcertificate_docs',
            'target_file_surrogacypatient_child_medicalcertificate_docs',
        ])->where('status', 1)->get();

        $userId = Session::get('id');
        $patient = signup::with('surrogacy_reg_no')
            ->whereHas('surrogacy_reg_no')
            ->where('id', $userId)
            ->first();

        if (!$patient) {
            Log::error('Surrogacy patient not found for file update.');
            return;
        }

        $userid = $patient->surrogacy_reg_no->userid;

        foreach ($docMasters as $docMaster) {
            $fileKey = str_replace('target_file_', '', $docMaster->doc_type);

            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                $extension = strtolower($file->getClientOriginalExtension());

                if (in_array($extension, $allowedExtensions)) {
                    $filename = $appid->id . '-' . $docMaster->doc_type . '-' . time() . '.' . $extension;
                    // $destinationPath = 'D:/xampp/htdocs/artprojfiles/surrogacy_patient_medical_docs';
                    $foldername   = 'surrogacy_patient_medical_docs';
                    $baseDir = folderpath($foldername);
                    $application_no_folder = str_replace('/', '_', $appid->clinic_id);
                    $destinationPath = $baseDir . $application_no_folder;
                    if (!File::exists($destinationPath)) {
                        File::makeDirectory($destinationPath, 0755, true);
                        if (!File::makeDirectory($destinationPath, 0755, true)) {
                            throw new \Exception("Unable to create directory: {$destinationPath}");
                        }
                    }
                    $file->move($destinationPath, $filename);
                    $dbpath = $filename;
                    $existing = DocFilePatientUpload::where([
                        'userid' => $userid,
                        'app_id' => $appid->id,
                        'doc_type' => $docMaster->doc_type,
                    ])->first();

                    if ($existing) {
                        // dd($existing, 'lhlkjsafhlkdshflkjh');
                        // ✅ Only update doc_upload_ref; DB trigger will archive the old one
                        $existing->update([
                            'doc_upload_ref' => $dbpath,
                            'updated_at' => now(),
                        ]);
                        Log::info("Updated file for {$docMaster->doc_type}");
                    } else {
                        $docuFile = docmastertable::where('doc_type', $docMaster->doc_type)->first();
                        DocFilePatientUpload::create([
                            'userid' => $userid,
                            'app_id' => $appid->id,
                            'doc_id' => $docuFile->id,
                            'doc_type' => $docMaster->doc_type,
                            'upload_desc' => $docuFile->doc_desc,
                            'doc_upload_ref' => $dbpath,
                            'ip' => request()->ip(),
                            'updated_at' => now()
                        ]);
                    }
                } else {
                    Log::warning("Invalid file type: $extension for {$docMaster->doc_type}");
                }
            }
        }
    }

    public function list_surrogacy_patient_outcome_view()
    {

        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        $clinic_id = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTSURROGACY')
            ->value('clinic_id');
            
        $quarter = QuarterTable::all();
        $quarter_list = PatientPeriodReportingTable::select('quarter', 'year', 'id')
            ->distinct()
            ->where('clinic_id', $clinic_id)
            ->where('status', 'Finished')
            ->orderBy('year', 'desc')
            ->orderBy('quarter', 'desc')
            ->get();

        $baseQuery = DB::connection('patient_clinic_database')
            ->table('patient_surrogacyclinic AS ps')
            ->join('patient_period_reporting_table AS pprt', 'pprt.id', '=', 'ps.reporting_id')
            ->where('ps.clinic_id', $clinic_id)
            ->where(function ($query) {
                    $query->where('ps.tratment_Outcome', 'Pregnant')
                        ->orWhere('ps.art_treat_outcomes', 'Pregnant');
                })
            // ->where('ps.tratment_Outcome', 'Pregnant')
            // ->orwhere('ps.art_treat_outcomes', 'Pregnant')

            ->whereNotNull('ps.treatment_type')
            ->where('pprt.status', 'Finished')
            ->select(
                'ps.quarter',
                'ps.year',
                'ps.clinic_id',
                DB::raw('COUNT(DISTINCT ps.id) as patient_count')
            )
            ->groupBy('ps.quarter', 'ps.year','ps.clinic_id')
            ->orderBy('ps.year', 'desc')
            ->orderBy('ps.quarter', 'desc')
            ->orderBy('ps.clinic_id', 'desc');
            

        $patient_list = (clone $baseQuery)
            ->whereNull('ps.part2_referenceno')
            ->get();
            //dd($patient_list);


        $baseQuery2 = DB::connection('patient_clinic_database')
            ->table('patient_surrogacyclinic AS ps')
            ->join('patient_period_part2_reporting_table as p2', function ($join) {
                $join->on(
                    DB::raw('p2.ref_no COLLATE utf8mb4_general_ci'),
                    '=',
                    DB::raw('ps.part2_referenceno COLLATE utf8mb4_general_ci')
                );
            })
            ->select(
                'ps.quarter',
                'ps.year',
                DB::raw('COUNT(DISTINCT ps.id) as patient_count')
            )
            ->where('ps.clinic_id', $clinic_id)
             ->where(function ($query) {
                    $query->where('ps.tratment_Outcome', 'Pregnant')
                        ->orWhere('ps.art_treat_outcomes', 'Pregnant');
                })

            ->groupBy('ps.quarter', 'ps.year');

        $patient_list_draft = (clone $baseQuery2)
            ->where('p2.status', 'Live')
            ->get();

        $patient_list_complte  = (clone $baseQuery2)
            ->where(function ($q) {
                $q->Where('p2.status', 'Finished');
            })
            ->get();


        $patient_list_date = DB::connection('patient_clinic_database')
            ->table('patient_period_part2_reporting_table')
            ->where('clinic_id', $clinic_id)
            ->where('status', 'Live')
            ->select('id', 'ref_no', 'initial_submit_date')
            ->first();

        $daysRemaining = 0;
        $expiryDate = null;

        if ($patient_list_date && $patient_list_date->initial_submit_date) {

            $submitDate = \Carbon\Carbon::parse($patient_list_date->initial_submit_date)->startOfDay();
            $today = now()->startOfDay();

            $daysPassed = $submitDate->diffInDays($today);


            $daysRemaining = max(30 - $daysPassed, 0);
            if ($daysPassed >= 30) {

                DB::connection('patient_clinic_database')
                    ->table('patient_period_part2_reporting_table')
                    ->where('ref_no', $patient_list_date->ref_no)
                    ->where('status', 'Live')
                    ->update([
                        'partial_status' => 1,
                        'updated_at' => now(),
                    ]);
            }
        }




        $record = DB::connection('patient_clinic_database')
            ->table('patient_period_part2_reporting_table')
            ->where('clinic_id', $clinic_id)
            ->where('status', 'Live')
            ->first();

        $ref_no = $record->ref_no ?? null;


        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();

        $pendingCount = DB::connection('patient_clinic_database')
            ->table('patient_period_part2_reporting_table')
            ->where('clinic_id', $clinic_id)
            ->where('status', 'Live')
            ->count();
        if ($pendingCount >= 25) {
            return redirect()
                ->route('clinic.part2_for_patient_outcome')
                ->with('error', 'You can only have 25 pending drafts at a time.');
        }


        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();
        return view('layouts.clinic.list_surrogacy_patient_view_outcome', compact(
            'quarterDescriptions',
            'patient_list',
            'quarter_list',
            'patient_list_draft',
            'patient_list_complte',
            'daysRemaining',
            'ref_no'
        ));
    }
}
