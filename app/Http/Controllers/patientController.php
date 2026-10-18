<?php

namespace App\Http\Controllers;

use App\Models\clinic\ClinicRegistrationModel;
use App\Models\clinic\signup;
use App\Models\DocFilePatientUpload;
use App\Models\Noc\countrytable;
use App\Models\Noc\docmastertable;
use App\Models\patient\PatientArtbank;
use App\Models\patient\PatientArtclinic;
use App\Models\patient\PatientDetailsArtbank;
use App\Models\patient\PatientPeriodReportingSnapshot;
use App\Models\patient\PatientPeriodReportingTable;
use App\Models\patient\PatientSetPeriodSummaryTable;
use App\Models\patient\PatientSurrogacyClinic;
use App\Models\patient\QuarterTable;
use App\Models\patient\SummaryPatientArtLevelOneClinic;
use App\Models\patient\SummaryPatientArtLevelTwoClinic;
use App\Models\patient\SummaryPatientBankClinic;
use App\Models\patient\SummaryPatientSurrogacyClinic;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class patientController extends Controller
{
    public function list_artclinic_patient()
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        $quarter = QuarterTable::all();
        $currentYear = date('Y');
        $startingYear = 2022;
        $currentQuarter = ceil(date('n') / 3);

        $add = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTCLINIC')->first();
        // dd($add->date_of_establishment);

        $patient_list = PatientArtclinic::where('userid', $userId)->where('clinic_id', $add->clinic_id)->get();


        // $reporting_data = PatientPeriodReportingTable::where('status', 'Live')->where('userid',$userId)->where('clinic_id', $add->clinic_id)->first();


        $latestRecord = PatientPeriodReportingTable::where('userid', $userId)
            ->where('clinic_id', $add->clinic_id)
            ->orderByDesc('year')
            ->orderByDesc('quarter')
            ->first();
        // dd($add->date_of_establishment);

        $defaultQuarter = 1;
        $defaultYear = $startingYear;

        if (!$latestRecord) {
            $estDate = $add->date_of_establishment ?? null;
            try {
                $date = Carbon::createFromFormat('Y-m-d', $estDate);
            } catch (\Exception $e) {
                Log::warning("Invalid establishment date format of the ART clinic", [
                    'invalidDate' => $estDate,
                    'Clinic ID' => $add->clinic_id,
                    'singup ID' => $userId,
                ]);
                return view('layouts/clinic/invalid_establishment_date', [
                    'invalidDate' => $estDate,
                    'clinictype'  => "ART Clinic",
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
        // dd($currentQuarter);
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
        $selected_quarter = QuarterTable::select('description')->where('quarter', $defaultQuarter)->first();

        // dd($selected_quarter);

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

            $available_years = PatientPeriodReportingTable::where('status', 'Live')
                ->where('userid', $userId)
                ->where('clinic_id', $add->clinic_id)
                ->select('year')
                ->distinct()
                ->orderByDesc('year')
                ->get();
            return view('layouts/clinic/add_patient_reporting_already_live_period_clinic_application_form', compact(
                'quarter',
                'exists',
                'reporting_data',
                'available_quarters',
                'available_years',
                'defaultQuarter',
                'defaultYear',
                'currentYear'
            ));
        }
        if (!$exists) {
            return view('layouts/clinic/add_patient_reporting_period_clinic_application_form', compact(
                'quarter',
                'exists',
                'defaultQuarter',
                'defaultYear',
                'currentYear',
                'selected_quarter'
            ));
        }
    }

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

    public function list_artclinic_patientsearchApplication(Request $request)
    {
        if (!Session::has('id')) {
            return response()->json(['errorMessage' => 'Unauthorized access'], 403);
        }
        $patient_uhid = $request->input('patient_uhid');
        $stateName = Session::get('state');
        if (empty($patient_uhid)) {
            return response()->json(['errorMessage' => 'Please enter a UHID number.']);
        }
        $signupUserIds = signup::where('state', $stateName)->pluck('id')->toArray();
        $patient_list = PatientArtclinic::with('signupid')
            ->where('patient_uhid', $patient_uhid)
            ->whereIn('userid', $signupUserIds) // Use fetched user IDs
            ->get();
        // $patient_list = PatientArtclinic::where('patient_uhid', $patient_uhid) // Filter by UHID in patient_artclinic table
        // ->whereHas('signupid', function ($query) use ($stateName) {
        //     $query->where('state', $stateName); // Filter by state in signup table
        // })
        // ->take(5) // Limit the results to 5 records
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

    public function list_artbank_patient()
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }

        if (empty(session()->has('patient_artbank_registration_no') && session()->has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');
        $quarter = QuarterTable::all();
        $currentYear = date('Y');
        $startingYear = 2022;
        $currentQuarter = ceil(date('n') / 3);

        // fetch bank clinic registration
        $add = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('clinic_type', 'ARTBANK')
            ->where('status', 1)
            ->first();

        if (!$add) {
            return redirect()->back()->with('error', 'Clinic not found');
        }

        $clinicId = $add->clinic_id;

        $patient_list = PatientArtbank::where('userid', $userId)
            ->where('clinic_id', $clinicId)
            ->get();

        // $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();

        // $reporting_data = PatientPeriodReportingTable::where('status', 'Live')
        //     ->where('userid', $userId)
        //     ->where('clinic_id', $clinicId)
        //     ->first();

        // $available_quarters = PatientPeriodReportingTable::where('status', 'Live')
        //     ->where('userid', $userId)
        //     ->where('clinic_id', $clinicId)
        //     ->select('quarter')
        //     ->distinct()
        //     ->orderBy('quarter')
        //     ->get()
        //     ->map(function ($q) use ($quarterDescriptions) {
        //         return [
        //             'id' => $q->quarter,
        //             'description' => $quarterDescriptions[$q->quarter] ?? $q->quarter,
        //         ];
        //     });

        // $available_years = PatientPeriodReportingTable::where('status', 'Live')
        //     ->where('userid', $userId)
        //     ->where('clinic_id', $clinicId)
        //     ->select('year')
        //     ->distinct()
        //     ->orderByDesc('year')
        //     ->get();

        // latest record for this clinic/user
        $latestRecord = PatientPeriodReportingTable::where('userid', $userId)
            ->where('clinic_id', $clinicId)
            ->orderByDesc('year')
            ->orderByDesc('quarter')
            ->first();

        // defaults
        $defaultQuarter = 1;
        $defaultYear = $startingYear;
        // dd($currentQuarter);
        if (!$latestRecord) {
            //ranvendra code start
            $estDate = $add->date_of_establishment ?? null;
            try {
                $date = Carbon::createFromFormat('Y-m-d', $estDate);
            } catch (\Exception $e) {
                Log::warning("Invalid establishment date format of the ART Bank", [
                    'invalidDate' => $estDate,
                    'Clinic ID' => $add->clinic_id,
                    'singup ID' => $userId,
                ]);
                return view('layouts/clinic/invalid_establishment_date', [
                    'invalidDate' => $estDate,
                    'clinictype'  => "ART BANK",
                    'errorMessage' => 'Invalid establishment date format'
                ]);
            }
            //    ranvendra code end




            // no records → use establishment date fallback
            $estDate = $add->date_of_establishment;
            $estYear = $estDate ? date('Y', strtotime($estDate)) : $startingYear;
            $estMonth = $estDate ? (int)date('n', strtotime($estDate)) : 1;

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
                } elseif ($estMonth >= 9 && $estMonth <= 12) {
                    $defaultQuarter = 4;
                } else {
                    return view('layouts/clinic/invalid_establishment_date');
                }
            }
        } else {
            // record exists
            if ($latestRecord->status === 'Live') {
                $defaultQuarter = $latestRecord->quarter;
                $defaultYear = $latestRecord->year;
            } elseif ($latestRecord->status === 'Finished') {
                // get next quarter
                $nextQuarter = $this->getNextQuarter($latestRecord->quarter);
                $defaultQuarter = $nextQuarter['quarter'];
                $defaultYear = $latestRecord->year + $nextQuarter['year_add'];
            }
        }

        // block future quarter/year
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

        // get selected quarter description
        $selected_quarter = QuarterTable::select('description')->where('quarter', $defaultQuarter)->first();

        // check live exists
        $exists = PatientPeriodReportingTable::where('userid', $userId)
            ->where('clinic_id', $clinicId)
            ->where('status', 'Live')
            ->exists();

        if ($exists) {
            $reporting_data = PatientPeriodReportingTable::where('status', 'Live')
                ->where('userid', $userId)
                ->where('clinic_id', $clinicId)
                ->first();
            $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();

            $available_quarters = PatientPeriodReportingTable::where('status', 'Live')
                ->where('userid', $userId)
                ->where('clinic_id', $clinicId)
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

            $available_years = PatientPeriodReportingTable::where('status', 'Live')
                ->where('userid', $userId)
                ->where('clinic_id', $clinicId)
                ->select('year')
                ->distinct()
                ->orderByDesc('year')
                ->get();
            return view('layouts/clinic/add_patient_reporting_already_live_period_bank_application_form', compact(
                'quarter',
                'exists',
                'reporting_data',
                'available_quarters',
                'available_years',
                'defaultQuarter',
                'defaultYear',
                'currentYear'
            ));
        }

        return view('layouts/clinic/add_patient_reporting_period_bank_application_form', compact(
            'quarter',
            'exists',
            'defaultQuarter',
            'defaultYear',
            'currentYear',
            'selected_quarter',
            'patient_list'
        ));
    }


    public function list_artbank_patientsearchApplication(Request $request)
    {
        //  dd('hsh'); 
        if (!Session::has('id')) {
            return response()->json(['errorMessage' => 'Unauthorized access'], 403);
        }
        $donor_id = $request->input('donor_id');
        $stateName = Session::get('state');
        if (empty($donor_id)) {
            return response()->json(['errorMessage' => 'Please enter a Donor ID.']);
        }
        $signupUserIds = signup::where('state', $stateName)->pluck('id')->toArray();
        $patient_list = PatientArtbank::with('signupid')
            ->where('donor_id', $donor_id)
            ->whereIn('userid', $signupUserIds) // Use fetched user IDs
            ->get();
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





    public function patientclinicapplicationform(Request $request)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        $quarter = QuarterTable::all();
        $countries = countrytable::all();

        // $patient_list = signup::with('clinic_reg_no')->whereHas('clinic_reg_no')->where('id', $userId)->first();

        $patient_list = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTCLINIC')->first();
        // dd($patient_list);
        $status = 'Live';
        //$previous_data = PatientArtclinic::where('userid', $userId)->where('clinic_id',$patient_list->clinic_id)->latest()->first();
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
                    'description' => $quarterDescriptions[$q->quarter] ?? $q->quarter,
                ];
            });

        $available_years = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $patient_list->clinic_id)
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->get();

        return view('layouts/clinic/add_patient_clinic_application_form', compact(
            'patient_list',
            'countries',
            'quarter',
            'reporting_data',
            'available_quarters',
            'available_years'
        ));
    }
    public function patientbankapplicationform(Request $request)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        $quarter = QuarterTable::all();
        $countries = countrytable::all();
        // $patient_list = signup::with('bank_reg_no')->whereHas('bank_reg_no')->where('id', $userId)->first();  
        $patient_list = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTBANK')->first();
        $status = 'Live';
        //$previous_data = PatientArtbank::where('userid', $userId)->where('clinic_id',$patient_list->clinic_id)->latest()->first();

        // $reporting_data = PatientPeriodReportingTable::where('status', 'Live')->where('clinic_reg_id', $patient_list->bank_reg_no->id)->latest()->first();
        $reporting_data = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $patient_list->clinic_id)->first();
        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();

        $available_quarters = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $patient_list->clinic_id)
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

        $available_years = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $patient_list->clinic_id)
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->get();



        return view('layouts/clinic/add_patient_bank_application_form', compact(
            'patient_list',
            'countries',
            'quarter',
            'reporting_data',
            'available_quarters',
            'available_years'
        ));
    }
    public function patientreportingbankapplicationform(Request $request)
    {

        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');
        $quarter = QuarterTable::all();
        $countries = countrytable::all();

        $previous_data = PatientArtbank::where('userid', $userId)->latest()->first();

        $reportData = PatientPeriodReportingTable::with('quarter')
            ->where(function ($query) {
                $query->where('status', '=', 'Live')
                    ->orWhereNull('status');
            })
            ->latest()
            ->get();

        $patient_list = signup::with('bank_reg_no')
            ->whereHas('bank_reg_no')
            ->where('id', $userId)
            ->first();

        $userId = Session::get('id');
        $quarterId = $request->input('quarter');
        $year = $request->input('year');

        // ✅ Default value for view
        $exists = false;

        if ($quarterId && $year) {
            $exists = PatientPeriodReportingTable::where('userid', $userId)
                ->where('clinic_reg_id', $patient_list->bank_reg_no->id)
                ->where('quarter', $quarterId)
                ->where('year', $year)
                ->where('status', 'Live')
                ->exists();

            // Show "already live" view if needed
            if ($exists) {
                return view('layouts/clinic/add_patient_reporting_already_live_period_bank_application_form', compact('quarter', 'reportData', 'exists'));
            }
        }
        return view('layouts/clinic/add_patient_reporting_period_bank_application_form', compact('quarter', 'reportData', 'exists'));
    }

    public function patientreportingclinicapplicationform(Request $request)
    {

        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');
        $quarter = QuarterTable::all();
        $countries = countrytable::all();

        $previous_data = PatientArtbank::where('userid', $userId)->latest()->first();

        $reportData = PatientPeriodReportingTable::with('quarter')
            ->where(function ($query) {
                $query->where('status', '=', 'Live')
                    ->orWhereNull('status');
            })
            ->latest()
            ->get();

        $patient_list = signup::with('clinic_reg_no')
            ->whereHas('clinic_reg_no')
            ->where('id', $userId)
            ->first();

        $userId = Session::get('id');
        $quarterId = $request->input('quarter');
        $year = $request->input('year');

        // ✅ Default value for view
        $exists = false;

        if ($quarterId && $year) {
            $exists = PatientPeriodReportingTable::where('userid', $userId)
                ->where('clinic_reg_id', $patient_list->clinic_reg_no->id)
                ->where('quarter', $quarterId)
                ->where('year', $year)
                ->where('status', 'Live')
                ->exists();

            // Show "already live" view if needed
            if ($exists) {
                return view('layouts/clinic/add_patient_reporting_already_live_period_clinic_application_form', compact('quarter', 'reportData', 'exists'));
            }
        }
        return view('layouts/clinic/add_patient_reporting_period_clinic_application_form', compact('quarter', 'reportData', 'exists'));
    }









    // public function patientreportingbankapplicationform(Request $request)
    // {
    //     if (empty(Session::has('id'))) {
    //         return redirect()->route('clinic.loginclinicform');
    //     }

    //     $userId = Session::get('id');
    //     $quarter = QuarterTable::all();
    //     $countries = countrytable::all();  

    //     $previous_data = PatientArtbank::where('userid', $userId)->latest()->first();

    //     $reportData = PatientPeriodReportingTable::with('quarter')
    //         ->where(function ($query) {
    //             $query->where('status', '=', 'Live')
    //                   ->orWhereNull('status');
    //         })
    //         ->latest()
    //         ->get();   

    //     $patient_list = signup::with('bank_reg_no')
    //         ->whereHas('bank_reg_no')
    //         ->where('id', $userId)
    //         ->first();    



    //         $userId = Session::get('id');
    //         $quarterId = $request->input('quarter');
    //         $year = $request->input('year');

    //         // Check if already exists for this user, quarter, and year
    //         $exists = PatientPeriodReportingTable::where('userid', $userId)
    //             ->where('quarter', $quarterId)
    //             ->where('year', $year)
    //             ->where('status', 'Live')
    //             ->exists();

    //         if ($exists) {
    //             return redirect()->back()->withInput()->with(['exists' => true]);
    //         }






    //     // Optional: Get message if quarter and year already added (via query params maybe?)
    //     $messagea = $request->query('exists') ? 'This quarter and year has already been added!' : null;

    //     return view('layouts/clinic/add_patient_reporting_period_bank_application_form', compact('quarter','reportData', 'messagea'));
    // }

    //     public function patientreportingbankapplicationform(Request $request)
    //     {
    //       //  dd('dh');
    //         if (empty(Session::has('id'))) {
    //             return redirect()->route('clinic.loginclinicform');
    //         }
    //         $userId = Session::get('id');
    //         $quarter = QuarterTable::all();
    //         $countries = countrytable::all();  

    //         $previous_data = PatientArtbank::where('userid', $userId)->latest()->first();
    //         $reportData = PatientPeriodReportingTable::with('quarter')
    //     ->where(function ($query) {
    //         $query->where('status', '!=', 'Live')
    //               ->orWhereNull('status');
    //     })
    //     ->latest()
    //     ->get();
    //       //  $reporting_data = PatientPeriodReportingTable::where('status', 'Live')->latest()->first();
    // //dd($reporting_data);
    // // $reporting_data = PatientPeriodReportingTable::with('quarter')->whereNot('status', 'Live')->latest()->get();
    //              //       dd($reporting_data);
    //         $patient_list = signup::with('bank_reg_no')->whereHas('bank_reg_no')->where('id', $userId)->first();  
    //         // $quarterDescriptions = [
    //         //     1 => 'Q1 (April - June)',
    //         //     2 => 'Q2 (July - September)',
    //         //     3 => 'Q3 (October - December)',
    //         //     4 => 'Q4 (January - March)',
    //         // ];

    //         // $available_quarters = PatientPeriodReportingTable::where('status', 'Live')
    //         //     ->select('quarter')
    //         //     ->distinct()
    //         //     ->orderBy('quarter')
    //         //     ->get()
    //         //     ->map(function ($q) use ($quarterDescriptions) {
    //         //         return [
    //         //             'id' => $q->quarter,
    //         //             'description' => $quarterDescriptions[$q->quarter] ?? 'Q' . $q->quarter,
    //         //         ];
    //         //     });

    //         // $available_years = PatientPeriodReportingTable::where('status', 'Live')
    //         //     ->select('year')
    //         //     ->distinct()
    //         //     ->orderByDesc('year')
    //         //     ->get();
    //             // $reportData = PatientPeriodReportingTable::where([
    //             //     ['status', '=', 'Live'],
    //             //     ['userid', '=', $patient_list->bank_reg_no->userid],
    //             // ])->get();

    //             // Check if the status is 'live'
    //            // if ($reporting_data && $reporting_data->status === 'Live') {

    //             return view('layouts/clinic/add_patient_reporting_period_bank_application_form', compact('quarter','reportData'));
    //          //       return view('layouts/clinic/add_patient_bank_application_form', compact('patient_list','countries','quarter', 'previous_data','reporting_data', 'available_quarters',
    //      //   'available_years'));

    //          //   }




    //      //   return view('layouts/clinic/add_patient_reporting_period_bank_application_form', compact(
    //      //       'quarter', 'countries', 'previous_data', 'patient_list', 'reporting_data'
    //      //   ));

    //       //  return view('layouts/clinic/add_patient_reporting_period_bank_application_form', compact('quarter'));

    //     }


    // public function patientreportingbankapplicationformSubmit(Request $request)
    // {

    //     if (empty(Session::has('id'))) {
    //         return redirect()->route('clinic.loginclinicform');
    //     }
    //     $test = $request->all();      
    //     $userId = Session::get('id');
    //     $add_data = signup::with('bank_reg_no')->whereHas('bank_reg_no')->where('id', $userId)->first(); 
    //     $patient_add_data = new PatientPeriodReportingTable();
    //     $patient_add_data->userid = $add_data->bank_reg_no->userid;
    //     $patient_add_data->clinic_reg_id = $add_data->bank_reg_no->id;
    //     $patient_add_data->status = 'Live';     
    //     $patient_add_data->fill($request->except(['_token'])); // Exclude _token from mass assignment        
    //     $patient_add_data->save();    
    //     return redirect()->route('clinic.add_patient_bank_application_form')->with('success', 'Reporting Period Updated Successfully');
    // }

    // public function patientreportingbankapplicationformSubmit(Request $request)
    // {
    //     if (!Session::has('id')) {
    //         return response()->json(['message' => 'Session expired. Please login again.'], 401);
    //     }

    //     $userId = Session::get('id');
    //     $add_data = signup::with('bank_reg_no')->whereHas('bank_reg_no')->where('id', $userId)->first(); 

    //     $patient_add_data = new PatientPeriodReportingTable();
    //     $patient_add_data->userid = $add_data->bank_reg_no->userid;
    //     $patient_add_data->clinic_reg_id = $add_data->bank_reg_no->id;
    //     $patient_add_data->status = 'Live';
    //     $patient_add_data->fill($request->except(['_token']));
    //     $patient_add_data->save();

    //     // Fetch records for selected quarter and year with status = 'Live'
    //     $reportData = PatientPeriodReportingTable::where([
    //         ['quarter', '=', $request->quarter],
    //         ['year', '=', $request->year],
    //         ['status', '=', 'Live'],
    //         ['userid', '=', $add_data->bank_reg_no->userid],
    //     ])->get();

    //     dd($reportData);
    //    // $table_html = view('clinic.partials.reporting_table', compact('reportData'))->render();

    //     return response()->json([
    //         'message' => 'Reporting Period Updated Successfully',
    //         'reportData' => $reportData
    //     ]);
    // }

    // public function patientreportingbankapplicationformSubmit(Request $request)
    // {
    //     if (!Session::has('id')) {
    //         return response()->json(['message' => 'Session expired. Please login again.'], 401);
    //     }

    //     $userId = Session::get('id');
    //     $userId = Session::get('id');
    //     $quarter = $request->input('quarter');
    //     $year = $request->input('year');
    //     $status = $request->input('status'); // 'Live' or 'Finished'

    //     // 🛑 Check if entry already exists

    //     $add_data = signup::with('bank_reg_no')->whereHas('bank_reg_no')->where('id', $userId)->first(); 

    //     $patient_add_data = new PatientPeriodReportingTable();
    //     $patient_add_data->userid = $add_data->bank_reg_no->userid;
    //     $patient_add_data->clinic_reg_id = $add_data->bank_reg_no->id;
    //     $patient_add_data->status = $status; // Use dynamic status (Live/Finished)
    //     $patient_add_data->fill($request->except(['_token', 'status']));
    //     $patient_add_data->save();   
    //     $reportData = PatientPeriodReportingTable::where([
    //         ['quarter', '=', $request->quarter],
    //         ['year', '=', $request->year],
    //         ['status', '=', $status],
    //         ['userid', '=', $add_data->bank_reg_no->userid],
    //     ])->get();

    //     return response()->json([
    //         'message' => 'Reporting Period Updated Successfully',
    //         'reportData' => $reportData,
    //         'exists' => false
    //     ]);
    // }

    // public function patientreportingbankapplicationformSubmit(Request $request)
    // {
    //     if (!Session::has('id')) {
    //         return response()->json(['message' => 'Session expired. Please login again.'], 401);
    //     }

    //     $userId = Session::get('id');
    //     $quarter = $request->input('quarter');
    //     $year = $request->input('year');
    //     $status = 'Live';
    //  //   $status = $request->input('status'); // 'Live' or 'Finished'

    //     $add_data = signup::with('bank_reg_no')
    //         ->whereHas('bank_reg_no')
    //         ->where('id', $userId)
    //         ->first();

    //         $existingLive = PatientPeriodReportingTable::where('userid', $add_data->bank_reg_no->userid)
    //         ->where('status', 'Live')
    //         ->first();

    //     // If a Live entry already exists for this user, don't allow another
    //     if ($existingLive) {
    //         return response()->json([
    //             'redirect' => route('clinic.add_reporting_already_live_period_patient_bank_application_form'),
    //             'message' => 'A reporting period with Live status already exists.'
    //         ], 200);
    //     }

    //     // Check if the record exists (regardless of previous status)
    //     $existingRecord = PatientPeriodReportingTable::where('userid', $add_data->bank_reg_no->userid)
    //         ->where('quarter', $quarter)
    //         ->where('year', $year)
    //         ->first();

    //     if ($existingRecord) {
    //         // Update existing record's status
    //         $existingRecord->status = $status;
    //         $existingRecord->fill($request->except(['_token', 'status']));
    //         $existingRecord->save();
    //     } else {
    //         // Insert new record
    //         $patient_add_data = new PatientPeriodReportingTable();
    //         $patient_add_data->userid = $add_data->bank_reg_no->userid;
    //         $patient_add_data->clinic_reg_id = $add_data->bank_reg_no->id;
    //         $patient_add_data->status = $status;
    //         $patient_add_data->fill($request->except(['_token', 'status']));
    //         $patient_add_data->save();
    //     }

    //     // Get report data (based on final status)
    //     $reportData = PatientPeriodReportingTable::where([
    //         ['quarter', '=', $quarter],
    //         ['year', '=', $year],
    //         ['status', '=', $status],
    //         ['userid', '=', $add_data->bank_reg_no->userid],
    //     ])->get();

    //     return response()->json([
    //         'message' => 'Reporting Period ' . ($existingRecord ? 'Updated' : 'Added') . ' Successfully',
    //         'reportData' => $reportData,
    //         'exists' => false
    //     ]);
    // }

    public function patientalreadylivereportingbankapplicationform(Request $request)
    {
        //   dd('hdsh');
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');
        $quarter = QuarterTable::all();


        $quarter = QuarterTable::all();
        //$patient_list = PatientArtbank::where('userid',$userId)->get(); 


        // $add = signup::with('bank_reg_no')
        // ->whereHas('bank_reg_no')
        // ->where('id', $userId)
        // ->first();
        $add = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTBANK')->first();

        // $reportData = PatientPeriodReportingTable::with('quarter')
        // ->where(function ($query) {
        //     $query->where('status', '=', 'Live')
        //           ->orWhereNull('status');
        // })
        // ->latest()
        // ->get(); 


        $reporting_data = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $add->clinic_id)->first();
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
                    'description' => $quarterDescriptions[$q->quarter] ?? $q->quarter,
                ];
            });

        $available_years = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $add->clinic_id)
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->get();

        return view('layouts/clinic/add_patient_reporting_already_live_period_bank_application_form', compact('quarter', 'reporting_data', 'available_quarters', 'available_years'));
    }

    public function patientalreadylivereportingclinicapplicationform(Request $request)
    {
        //   dd('hdsh');
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');
        $quarter = QuarterTable::all();


        $quarter = QuarterTable::all();
        // $patient_list = PatientArtclinic::where('userid',$userId)->get(); 

        $add = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTCLINIC')->first();
        //  $get_leval = ClinicRegistrationModel::where('userid',$userId)->get();
        // if($get_leval->level = 'Level-1'){
        //     $add = ClinicRegistrationModel::where('userid_applicant', $userId)->where('clinic_type', 'ARTCLINIC')->where('level', 'Level-1')->first();
        // }elseif($get_leval->level = 'Level-2'){
        //          $add = ClinicRegistrationModel::where('userid_applicant', $userId)->where('clinic_type', 'ARTCLINIC')->where('level', 'Level-2')->first();
        // }else{
        //      $add = ClinicRegistrationModel::where('userid_applicant', $userId)->where('clinic_type', 'ARTCLINIC')->first();
        // }


        // $reportData = PatientPeriodReportingTable::with('quarter')
        // ->where(function ($query) {
        //     $query->where('status', '=', 'Live')
        //           ->orWhereNull('status');
        // })
        // ->latest()
        // ->get(); 


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
                    'description' => $quarterDescriptions[$q->quarter] ?? $q->quarter,
                ];
            });

        $available_years = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $add->clinic_id)
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->get();

        return view('layouts/clinic/add_patient_reporting_already_live_period_clinic_application_form', compact('quarter', 'reporting_data', 'available_quarters', 'available_years'));
    }


    public function patientalreadylivereportingreportingbankapplicationformSubmit(Request $request)
    {
        if (!Session::has('id')) {
            return redirect()->back()->withErrors(['error' => 'Session expired. Please login again.']);
        }

        $userId = Session::get('id');
        $status = $request->has('status') ? 'Finished' : 'Live';
        $year = $request->input('year');
        $quarter = $request->input('quarter');
        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();

        //dd($request);
        // $add_data = signup::with('bank_reg_no')
        //     ->whereHas('bank_reg_no')
        //     ->where('id', $userId)
        //     ->first();
        $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTBANK')->first();

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


        if ($existingRecord) {
            // Update existing record
            $existingRecord->fill($request->except(['_token']));
            $existingRecord->status = $status;

            $existingRecord->final_submit_date = now();
            $existingRecord->save();
        }

        if ($status == "Finished") {
            return redirect()
                ->route('clinic.list_artbank_patient')
                ->with('success', "Reporting information for {$quarterDescriptions[$quarter]}, {$year} has been successfully saved");
        }
        return redirect()->route('clinic.add_patient_bank_application_form');
    }

    public function patientalreadylivereportingreportingclinicapplicationformSubmit(Request $request)
    {
        if (!Session::has('id')) {
            return redirect()->back()->withErrors(['error' => 'Session expired. Please login again.']);
        }

        // dd($request->all());
        $userId = Session::get('id');
        $status = $request->has('status') ? 'Finished' : 'Live';
        $year = $request->input('year');
        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();
        $quarter = $request->input('quarter');

        $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTCLINIC')->first();

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
        // dd($add_data);
        //dd($existingRecord);
        if ($existingRecord) {
            // Update existing record
            $existingRecord->fill($request->except(['_token']));
            $existingRecord->status = $status;

            $existingRecord->final_submit_date = now();
            $existingRecord->save();
        }

        if ($status == "Finished") {
            return redirect()
                ->route('clinic.list_artclinic_patient')
                ->with('success', "Reporting information for {$quarterDescriptions[$quarter]}, {$year} has been successfully saved");
        }
        return redirect()->route('clinic.add_patient_clinic_application_form');
    }












    // public function patientalreadylivereportingreportingbankapplicationformSubmit(Request $request)
    // {
    //  //  dd('sdhshsjsjsj');
    //     if (!Session::has('id')) {
    //         return redirect()->back()->withErrors(['error' => 'Session expired. Please login again.']);
    //     }

    //     $userId = Session::get('id');
    //    // $quarter = $request->input('quarter');
    //   //  $year = $request->input('year');
    //     $status = 'Live';

    //     $add_data = signup::with('bank_reg_no')
    //         ->whereHas('bank_reg_no')
    //         ->where('id', $userId)
    //         ->first();  
    //         $patient_add_data = new PatientPeriodReportingTable();
    //         $patient_add_data->userid = $add_data->bank_reg_no->userid;
    //         $patient_add_data->clinic_reg_id = $add_data->bank_reg_no->id;
    //         $patient_add_data->status = $status;
    //         $patient_add_data->fill($request->except(['_token', 'status']));
    //         $patient_add_data->save();
    //     // }

    //   //  return redirect()->route('clinic.add_reporting_already_live_period_patient_bank_application_form')->with('message', ' Quarter and Year added Successfully');
    // }



    public function patientreportingbankapplicationformSubmit(Request $request)
    {
        // dd('sdsyysyysysysysysyhshsjsjsj');
        if (!Session::has('id')) {
            return redirect()->back()->withErrors(['error' => 'Session expired. Please login again.']);
        }

        $userId = Session::get('id');
        // $quarter = $request->input('quarter');
        //  $year = $request->input('year');
        $status = 'Live';
        $type_clinic = 'ARTBANK';
        // $add_data = signup::with('bank_reg_no')
        //     ->whereHas('bank_reg_no')
        //     ->where('id', $userId)
        //     ->first();  
        $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTBANK')->first();

        // $clinicRegId = $add_data->bank_reg_no->id;
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


        return redirect()->route('clinic.add_reporting_already_live_period_patient_bank_application_form')->with('message', ' Quarter and Year added Successfully');
    }



    public function patientreportingclinicapplicationformSubmit(Request $request)
    {
        if (!Session::has('id')) {
            return redirect()->back()->withErrors(['error' => 'Session expired. Please login again.']);
        }

        $userId = Session::get('id');
        $status = 'Live';
        $type_clinic = 'ARTCLINIC';
        // $add_data = signup::with('clinic_reg_no')
        //     ->whereHas('clinic_reg_no')
        //     ->where('id', $userId)
        //     ->first();  
        $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTCLINIC')->first();

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

        return redirect()->route('clinic.add_reporting_already_live_period_patient_clinic_application_form')->with('message', ' Quarter and Year added Successfully');
    }













    public function checkuhid(Request $request)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        $uhid = $request->input('patient_uhid');
        $yy_ = $request->input('year_');
        $qq_ = $request->input('quarter_');
        if (!$uhid) {
            return response()->json(['status' => 'error', 'message' => 'Patient UHID is required'], 400);
        }
        if (!$yy_ || !$qq_) {
            return response()->json(['status' => 'error', 'message' => 'year or quarter is not selected'], 400);
        }
        $record = PatientArtclinic::where('userid', $userId)
            ->where('patient_uhid', $uhid)
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

    public function bankcheckuhid(Request $request)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        $uhid = $request->input('donor_id');
        $yy_ = $request->input('year_');
        $qq_ = $request->input('quarter_');
        if (!$uhid) {
            return response()->json(['status' => 'error', 'message' => 'Donor ID is required'], 400);
        }
        if (!$yy_ || !$qq_) {
            return response()->json(['status' => 'error', 'message' => 'year or quarter is not selected'], 400);
        }
        $record = PatientArtbank::where('userid', $userId)
            ->where('donor_id', $uhid)
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





    public function patientclinicapplicationformSubmit(Request $request)
    {
        //dd($request->all());
        try {
            if (empty(Session::has('id'))) {
                return redirect()->route('clinic.loginclinicform');
            }
            // $data = $request->all();
            $action = $request->input('submit');
            $userId = Session::get('id');
            $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTCLINIC')->first();
            $art_proc_undertaken = ['artificial insemination', 'intra-uterine insemination(IUI)', 'in vitro fertilization-embryo transfer', 'gamete intrafallopian tube transfer', 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)', 'physiological Intra-cytoplasmic sperm injection', 'intra-cytoplasmic morphologically selected sperm injection', 'round spermatid nucleus injection', 'Elongated spermatid injection', 'Others'];
            $rule = [
                'previous_treatment' => 'required|in:Yes,No',
                'clinic_level1_reg_num' => 'required|string',
                'name_of_clinic'  => 'required|string',
                'patient_uhid' => 'required|string|max:20',
                'case_of' => 'required|in:one,two',
                'nationality' => 'nullable|required_if:case_of,one|in:Indian,Foreigner',
                'other_nationality' => 'nullable|required_if:nationality,Foreigner|exists:apps_countries,id',
                'nationality_wife' => 'required|in:Indian,Foreigner',
                'other_nationality_wife' => 'nullable|required_if:nationality_wife,Foreigner|exists:apps_countries,id',
                'age_hus_wife' => 'nullable|required_if:case_of,one|numeric',
                'wife_age' => 'nullable|required_if:case_of,one|numeric',
                'age_of_women' => 'nullable|required_if:case_of,two|numeric',
                'male_factor' => 'in:Y,N',
                'female_factor' => 'in:Y,N',
                'unexplained' => 'in:Y,N',
                'cause_of_infretily' => 'required|string',
                'art_proc_undertaken' => 'required|in:' . implode(',', $art_proc_undertaken),
                'art_undertaken_other' => 'nullable|required_if:art_proc_undertaken,Others|string',
                'types_of_treat' => 'required|in:ART Treatment using self gametes,ART Treatment using donor gametes',
                'types_of_treat1' => 'nullable|required_if:types_of_treat,ART Treatment using donor gametes|in:Oocyte Donation,Sperm Donation,Both Oocyte Donation & Sperm Donation',
                'total_num_of_cyc' => 'required|numeric',
                'no_cycles' => 'required|numeric',
                'cyc_canc_failure_reason' => 'nullable|string',
                'treat_outcomes' => 'required|in:Pregnant,Not Pregnant',
                'complicatoins_if_any' => 'nullable|string',
                'remark' => 'nullable|string',
                'declaration' => [
                    Rule::requiredIf(function () use ($request) {
                        return $request->types_of_treat == "ART Treatment using donor gametes" &&
                            in_array($request->types_of_treat1, [
                                "Oocyte Donation",
                                "Both Oocyte Donation & Sperm Donation"
                            ]);
                    })
                ],

                'declaration1' => [
                    Rule::requiredIf(function () use ($request) {
                        return $request->types_of_treat == "ART Treatment using donor gametes" &&
                            in_array($request->types_of_treat1, [
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
            $messages = [

                'previous_treatment.required' => 'Please select whether previous treatment was taken.',
                'previous_treatment.in' => 'Invalid value selected for previous treatment.',

                'clinic_level1_reg_num.required' => 'Clinic registration number is required.',
                'clinic_level1_reg_num.string' => 'Clinic registration number must be a valid text.',

                'name_of_clinic.required' => 'Please enter the name of the clinic.',
                'name_of_clinic.string' => 'Clinic name must be valid text.',

                'patient_uhid.required' => 'Patient UHID is required.',
                'patient_uhid.max' => 'Patient UHID must not exceed 20 characters.',

                'case_of.required' => 'Please select the case type.',
                'case_of.in' => 'Invalid case type selected.',

                'nationality.required_if' => 'Please select nationality when case type is "one".',
                'nationality.in' => 'Nationality must be either Indian or Foreigner.',

                'other_nationality.required_if' => 'Please select the country when nationality is Foreigner.',
                'other_nationality.exists' => 'Selected nationality is invalid.',

                'nationality_wife.required' => 'Please select wife nationality.',
                'nationality_wife.in' => 'Wife nationality must be either Indian or Foreigner.',

                'other_nationality_wife.required_if' => 'Please select wife country when nationality is Foreigner.',
                'other_nationality_wife.exists' => 'Selected wife nationality country is invalid.',

                'age_hus_wife.required_if' => 'Please enter age of husband when case type is one.',
                'age_hus_wife.numeric' => 'Age of husband must be a number.',

                'wife_age.required_if' => 'Please enter age of wife when case type is one.',
                'wife_age.numeric' => 'Age of wife must be a number.',

                'age_of_women.required_if' => 'Please enter age of woman when case type is two.',
                'age_of_women.numeric' => 'Age must be a number.',

                'male_factor.in' => 'Invalid selection for male factor.',
                'female_factor.in' => 'Invalid selection for female factor.',
                'unexplained.in' => 'Invalid selection for unexplained infertility.',

                'cause_of_infretily.required' => 'Please enter the cause of infertility.',

                'art_proc_undertaken.required' => 'Please select the ART procedure undertaken.',
                'art_proc_undertaken.in' => 'Invalid ART procedure selected.',

                'art_undertaken_other.required_if' => 'Please specify the ART procedure when "Others" is selected.',

                'types_of_treat.required' => 'Please select the type of treatment.',
                'types_of_treat.in' => 'Invalid treatment type selected.',

                'types_of_treat1.required_if' => 'Please select donor type when donor gametes are used.',
                'types_of_treat1.in' => 'Invalid donor treatment type selected.',

                'total_num_of_cyc.required' => 'Please enter total number of cycles.',
                'total_num_of_cyc.numeric' => 'Total number of cycles must be numeric.',

                'no_cycles.required' => 'Please enter number of cycles undertaken.',
                'no_cycles.numeric' => 'Number of cycles must be numeric.',

                'cyc_canc_failure_reason.required' => 'Please provide reason for cancellation or failure.',
                'cyc_canc_failure_reason.string' => 'Reason must be valid text.',

                'treat_outcomes.required' => 'Please select treatment outcome.',
                'treat_outcomes.in' => 'Invalid treatment outcome selected.',

                'complicatoins_if_any.string' => 'Complications must be valid text.',

                'remark.string' => 'Remark must be valid text.',

                'declaration.required' => 'Please check the undertaking from the Oocyte Donor that she has not donated oocytes more than once in her lifetime.',
                'declaration.accepted' => 'You must confirm the Oocyte Donor declaration.',

                'declaration1.required' => 'Please check the undertaking from the ART Bank regarding donor usage.',
                'declaration1.accepted' => 'You must confirm the ART Bank declaration.'

            ];
            $request->validate($rule, $messages);

            $checkrecord = PatientArtclinic::where('userid', $userId)
                ->where('patient_uhid', $request->patient_uhid)
                ->exists();

            if ((!$checkrecord && $request->previous_treatment !== 'No') || ($checkrecord && $request->previous_treatment !== 'Yes')) {
                return redirect()->route('clinic.add_patient_clinic_application_form')->withInput()->with('upd_error', 'Either Patient UHID exists or you selected yes for non existing Patient UHID. Please check the UHID and try again.');
            }


            // $get_leval = ClinicRegistrationModel::where('userid',$userId)->get();
            // if($get_leval->level = 'Level-1'){
            //     $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)->where('clinic_type', 'ARTCLINIC')->where('level', 'Level-1')->first();
            // }elseif($get_leval->level = 'Level-2'){
            //          $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)->where('clinic_type', 'ARTCLINIC')->where('level', 'Level-2')->first();
            // }else{
            //      $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)->where('clinic_type', 'ARTCLINIC')->first();
            // }


            // dd($add_data->registration_no);


            if (!$add_data) {
                return back()->with('error', 'ART Clinic Registration data not found.');
            }


            // Check if the fetched value (hidden input) matches the actual database value
            if (trim($request->clinic_level1_reg_num) != trim($add_data->registration_no)) {
                return back()->withInput()->with('error', 'Invalid request: Data has been modified illegally!');
            }
            if (trim($request->name_of_clinic) != trim($add_data->name)) {
                // dd($request->name_of_clinic,'   sdfasdf  ', $add_data->name);
                return back()->withInput()->with('error', 'Invalid request: Data has been modified illegally!');
            }


            // 
            // Convert `gender_child` if it's an array
            // $gender_child = is_array($request->gender_child) ? implode(',', $request->gender_child) : null; 
            // dd($action);

            if ($action == 'continue') {
                DB::beginTransaction();
                $patient_add_data = new PatientArtclinic();
                // $data['gender_child'] = is_array($request->gender_child) ? implode(',', $request->gender_child) : null;
                $patient_add_data->userid = $add_data->userid_applicant;
                $patient_add_data->clinic_id = $add_data->clinic_id;

                $formData = $request->except(['_token', 'gender_child']);
                // $formData['gender_child'] = $gender_child; // Ensure gender_child is a string            
                $patient_add_data->fill($formData);

                // $patient_add_data->fill($request->except(['_token'])); // Exclude _token from mass assignment
                // dd("wwwwwww");
                //dd($patient_add_data);
                $reportId = $request->input('report_id');

                //  dd($reportId);
                $report = PatientPeriodReportingTable::find($reportId);
                //  dd($report);
                $patient_add_data->reporting_id = $reportId;
                //  dd($patient_add_data);
                if ($report) {
                    $report->status = 'Live';
                    //   $report->completed_at = now();
                    //  $report->patient_id = $patient->id; // assuming a relation exists
                    $report->save();
                }
                //  dd($patient_add_data);
                $patient_add_data->save();

                DB::commit();
                // Logic for when the "Continue patient details" button is clicked
                return redirect()->route('clinic.add_patient_clinic_application_form')->with('success', 'Patient details submitted successfully.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // dd('test1');
            DB::rollBack(); // Rollback transaction on validation failure
            Log::error('ART patient details form validation failed: ', [
                'errors' => $e->errors(),
                'Clinic_id'  => $add_data->clinic_id
            ]);
            // throw $e; // IMPORTANT: sends errors back to Blade
            return redirect()->route('clinic.add_patient_clinic_application_form')
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            // dd('test2');
            DB::rollBack(); // Rollback on any other error
            Log::error('Error updating clinic record: ', [
                'errors' => $e->getMessage(),
                'Clinic_id'  => $add_data->clinic_id
            ]);

            return redirect()->route('clinic.add_patient_clinic_application_form')
                ->with('upd_error', 'An error occurred while updating. Please Contact support.')
                ->withInput();
        }
    }

    public function patientbankapplicationformSubmit(Request $request)
    {
        // dd($request->all());
        try {
            if (empty(Session::has('id'))) {
                return redirect()->route('clinic.loginclinicform');
            }
            $action = $request->input('submit');
            // $test = $request->all();
            // dd($request->all());
            // Validate the form inputs
            $userId = Session::get('id');
            $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTBANK')->first();

            $request->validate([
                'previous_treatment' => 'required|in:Yes,No',
                'bank_reg_num'      => 'required|string',
                'name_of_bank'      => 'required|string',
                'donor_id'         => 'required|string|max:20',
                'gender_donor'     => 'required|in:Male,Female',
                'donor_age'        => 'nullable|required_if:gender_donor,Male|integer|min:21|max:55',
                'oocyte_age'       => 'nullable|required_if:gender_donor,Female|integer|min:23|max:35',
                'marital_status'   => 'required|in:Married,Single',
                'nationality'      => 'required|in:Indian,Foreigner',
                'other_nationality' => 'nullable|required_if:nationality,Foreigner|exists:apps_countries,id',
                'gamete_details'   => 'required|integer|min:0|max:99',
                'complicatoins_if_any' => 'nullable|string',
                'remark' =>         'nullable|string',
                'declaration'      => 'sometimes|required_if:gender_donor,Female|accepted',
                'declaration1'     => 'required_if:gender_donor,Male,Female|accepted',
            ], [
                'previous_treatment.required' => 'Please select whether previous treatment was undertaken.',
                'previous_treatment.in' => 'Invalid value selected for previous treatment.',

                'bank_reg_num.required' => 'Bank registration number is required.',
                'bank_reg_num.string' => 'Bank registration number must be valid.',

                'name_of_bank.required' => 'Please enter the name of the ART Bank.',
                'name_of_bank.string' => 'Bank name must be valid text.',

                'donor_id.required' => 'Please enter the donor ID.',
                'donor_id.string' => 'Donor ID must be valid.',
                'donor_id.max' => 'Donor ID must not exceed 20 characters.',

                'gender_donor.required' => 'Please select donor gender.',
                'gender_donor.in' => 'Invalid donor gender selected.',
                'declaration.required_if' => 'Please confirm the declaration required for female donor.',
                'declaration.accepted' => 'You must accept the declaration for female donor.',

                'declaration1.required_if' => 'Please confirm the declaration required for male donor.',
                'declaration1.accepted' => 'You must accept the declaration for male donor.',

                'donor_age.required_if' => 'Please enter donor age for male donor.',
                'donor_age.integer' => 'Donor age must be a valid number.',
                'donor_age.min' => 'Male donor age must be at least 21 years.',
                'donor_age.max' => 'Male donor age must not exceed 55 years.',

                'oocyte_age.required_if' => 'Please enter age of oocyte donor.',
                'oocyte_age.integer' => 'Oocyte donor age must be a valid number.',
                'oocyte_age.min' => 'Oocyte donor age must be at least 23 years.',
                'oocyte_age.max' => 'Oocyte donor age must not exceed 35 years.',

                'marital_status.required' => 'Please select marital status.',
                'marital_status.in' => 'Invalid marital status selected.',

                'nationality.required' => 'Please select nationality.',
                'nationality.in' => 'Nationality must be either Indian or Foreigner.',

                'other_nationality.required_if' => 'Please select country when nationality is Foreigner.',
                'other_nationality.exists' => 'Selected country is invalid.',

                'gamete_details.required' => 'Please enter number of gametes supplied.',
                'gamete_details.integer' => 'Gamete details must be a valid number.',
                'gamete_details.min' => 'Gamete details must be at least 0.',
                'gamete_details.max' => 'Gamete details must not exceed 99.',

                'complicatoins_if_any.string' => 'Complications must be valid text.',

                'remark.string' => 'Remark must be valid text.',

            ]);


            $previous_treatment = $request->input('previous_treatment');

            if (!$add_data) {
                return back()->with('error', 'Bank Registration data not found.');
            }
            // Check if the fetched value (hidden input) matches the actual database value
            if (trim($request->bank_reg_num) != trim($add_data->registration_no)) {
                return back()->withInput()->with('error', 'Invalid request: Data has been modified illegally!');
            }
            if (trim($request->name_of_bank) != trim($add_data->name)) {
                return back()->withInput()->with('error', 'Invalid request: Data has been modified illegally!');
            }

            // if ($action === 'complete') {

            //     $patient_add_data = new PatientArtbank();
            //     $patient_add_data->userid = $add_data->bank_reg_no->userid;
            //     $patient_add_data->bank_reg_id = $add_data->bank_reg_no->id;  
            //     $patient_add_data->fill($request->except(['_token'])); // Exclude _token from mass assignment            
            //     $reportId = $request->input('report_id');
            //     $report = PatientPeriodReportingTable::find($reportId);
            //     $patient_add_data->reporting_id = $reportId;
            //     if ($report) {
            //         $report->status = 'Finished';             
            //         $report->save();
            //     }
            //     $patient_add_data->save(); 

            //     return redirect()->route('clinic.add_reporting_period_patient_bank_application_form')->with('message_update', 'Patient Details saved Successfully.');

            // }

            if ($action === 'continue') {
                //    dd('continue');
                $patient_add_data = new PatientArtbank();
                $patient_add_data->userid = $add_data->userid_applicant;
                $patient_add_data->clinic_id = $add_data->clinic_id;
                $patient_add_data->fill($request->except(['_token'])); // Exclude _token from mass assignment
                // $this->handleFileUploads_surrogacypatient($request, $pb_clinicid);


                $reportId = $request->input('report_id');
                $report = PatientPeriodReportingTable::find($reportId);
                // dd($report);
                $patient_add_data->reporting_id = $reportId;
                if ($report) {
                    $report->status = 'Live';
                    //   $report->completed_at = now();
                    //  $report->patient_id = $patient->id; // assuming a relation exists
                    $report->save();
                }

                $patient_add_data->save();


                // Logic for when the "Continue patient details" button is clicked
                return redirect()->route('clinic.add_patient_bank_application_form')->with('message_update', 'Donor details submitted successfully.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // dd('test1');
            DB::rollBack(); // Rollback transaction on validation failure
            Log::error('ART Bank patient details form validation failed: ', [
                'errors' => $e->validator,
                'Clinic_id'  => $add_data->clinic_id
            ]);
            return redirect()->route('clinic.add_patient_bank_application_form')
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            // dd('test2');
            DB::rollBack(); // Rollback on any other error
            Log::error('Error updating clinic record: ', [
                'errors' => $e->getMessage(),
                'Clinic_id'  => $add_data->clinic_id
            ]);

            return redirect()->route('clinic.add_patient_bank_application_form')
                ->with('upd_error', 'An error occurred while updating. Please Contact support.')
                ->withInput();
        }









        // ✅ Check for existing donor_id     
        // $patient_add_data = new PatientArtbank();
        // $patient_add_data->userid = $add_data->bank_reg_no->userid;
        // $patient_add_data->bank_reg_id = $add_data->bank_reg_no->id;  

        // // Assign all request data
        // $patient_add_data->fill($request->except(['_token'])); // Exclude _token from mass assignment

        // $patient_add_data->save();    
        // return redirect()->route('clinic.list_artbank_patient')->with('success', 'Updated Successfully');
    }



    // public function patientbankapplicationformSubmit(Request $request)
    // {
    //     if (empty(Session::has('id'))) {
    //         return redirect()->route('clinic.loginclinicform');
    //     }
    //     $request->validate([
    //                 'bank_reg_num'      => 'required|string',
    //                 'name_of_bank'      => 'required|string',
    //                 'donor_id'         => 'required|string|max:10',            
    //                 'gender_donor'     => 'required|in:Male,Female',
    //                 // 'declaration'      => 'nullable|required_if:gender_donor,Female|accepted',
    //                 // 'declaration1'     => 'nullable|required_if:gender_donor,Male|accepted',
    //                 'donor_age'        => 'nullable|required_if:gender_donor,Male|integer|min:21|max:55',
    //                 'oocyte_age'       => 'nullable|required_if:gender_donor,Female|integer|min:23|max:35',
    //                 'marital_status'   => 'required|string',
    //                 'nationality'      => 'required|string',
    //                 'other_nationality'=> 'nullable|required_if:nationality,Others|string',
    //                 'gamete_details'   => 'required|string',
    //             ], [
    //                 'donor_id.required' => 'The Donor ID field is required.',
    //                 'gender_donor.required' => 'The Gender Donor field is required.',
    //                 // 'declaration.required_if' => 'You must accept the declaration for Female donors.',
    //                 // 'declaration1.required_if' => 'You must accept the declaration for Male donors.',
    //                 'donor_age.required_if' => 'Sperm donor age is required for Male donors.',
    //                 'donor_age.integer' => 'Sperm donor age must be a valid number.',
    //                 'donor_age.min' => 'Sperm donor must be at least 21 years old.',
    //                 'donor_age.max' => 'Sperm donor age cannot be more than 55 years.',
    //                 'oocyte_age.required_if' => 'Oocyte donor age is required for Female donors.',
    //                 'oocyte_age.integer' => 'Oocyte donor age must be a valid number.',
    //                 'oocyte_age.min' => 'Oocyte donor must be at least 23 years old.',
    //                 'oocyte_age.max' => 'Oocyte donor age cannot be more than 35 years.',
    //                 'marital_status.required' => 'Marital status is required.',
    //                 'nationality.required' => 'Nationality is required.',
    //                 'other_nationality.required_if' => 'Please specify your nationality if you selected "Others".',
    //                 'gamete_details.required' => 'Oocyte/Semen details are required.',
    //             ]);
    //     $userId = Session::get('id');
    //     $add_data = signup::with('bank_reg_no')->whereHas('bank_reg_no')->where('id', $userId)->first(); 

    //     if (!$add_data) {
    //         return back()->with('error', 'Bank Registration data not found.');
    //     }

    //     // Validate hidden fields
    //     if ($request->bank_reg_num !== $add_data->bank_reg_no->registration_no) {
    //         return back()->withInput()->with('error', 'Invalid request: Data has been modified illegally!');
    //     }
    //     if ($request->name_of_bank !== $add_data->clinicname) {
    //         return back()->withInput()->with('error', 'Invalid request: Data has been modified illegally!');
    //     }

    //     $status = $request->input('status'); // 'Live' or 'Finished'
    //     $type_clinic = 'ART Bank';

    //     if (($status === 'Live') || ($type_clinic === 'ART Bank')) {
    //         // Continue patient details
    //         $patient_add_data = new PatientArtbank();
    //         $patient_add_data->userid = $add_data->bank_reg_no->userid;
    //         $patient_add_data->bank_reg_id = $add_data->bank_reg_no->id;
    //         $patient_add_data->fill($request->except(['_token']));

    //         $reportId = $request->input('report_id');
    //         $report = PatientPeriodReportingTable::find($reportId);

    //         $patient_add_data->reporting_id = $reportId;

    //         if ($report) {
    //             $report->status = 'Live';
    //             $report->save();
    //         }

    //         $patient_add_data->save();

    //         return response()->json([
    //             'message' => 'Patient details saved successfully.',
    //             'exists' => false
    //         ]);

    //     } elseif ($status === 'Finished') {
    //         // Mark reporting period as completed
    //         $reportId = $request->input('report_id');
    //         $report = PatientPeriodReportingTable::find($reportId);

    //         if ($report) {
    //             $report->status = 'Finished';
    //             $report->completed_at = now(); // You can also save completion time if needed
    //             $report->save();
    //         }

    //         return response()->json([
    //             'message' => 'Reporting period completed successfully.',
    //             'exists' => false
    //         ]);
    //     } else {
    //         return response()->json([
    //             'message' => 'Invalid status submitted.',
    //             'exists' => true
    //         ]);
    //     }
    // }





















    public function patientclinicForm_view($id)
    {
        if (empty(Session::has('id'))) {

            return redirect()->route('clinic.loginclinicform');
        }
        try {
            $userId = Session::get('id');
            $decryptedId = Crypt::decrypt($id);
            // Fetch the patient details
            $application = PatientArtclinic::findOrFail($decryptedId);
            // Fetch the clinic names from the signup table
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
            return view('layouts.clinic.patient_clinic_form_view', compact('application', 'CountryName', 'CountryName_wife'));
        } catch (DecryptException $e) {
            // Handle invalid or tampered encrypted ID
            abort(404, 'Invalid ID');
        }
    }
    public function patientbankForm_view($id)
    {

        if (empty(Session::has('id'))) {

            return redirect()->route('clinic.loginclinicform');
        }

        try {
            $userId = Session::get('id');
            // Decrypt the encrypted ID safely
            $decryptedId = Crypt::decrypt($id);
            // Fetch the patient details
            $application = PatientArtbank::findOrFail($decryptedId);
            // Fetch the clinic names from the signup table
            $countryIds = [$application->other_nationality]; // IDs to fetch          
            $countryNames = DB::table('apps_countries')
                ->where('id', $countryIds)
                ->pluck('country_name', 'id'); // Retrieve clinic names with IDs as keys
            $CountryName = $countryNames[$application->other_nationality] ?? null;
            // Return the view with the record data
            return view('layouts.clinic.patient_bank_form_view', compact('application', 'CountryName'));
        } catch (DecryptException $e) {
            // Handle invalid or tampered encrypted ID
            abort(404, 'Invalid ID');
        }
    }





    public function summarypatientartapplicationform()
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        $countries = countrytable::all();
        $quarter = QuarterTable::all();
        // $patient_list = signup::with('clinic_reg_no')->whereHas('clinic_reg_no')->where('id', $userId)->first();
        $patient_list = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTCLINIC')
            ->where('level', 'Level-1')
            ->first();
        //dd($patient_list);
        return view('layouts/clinic/add_summary_patient_art_application_form', compact('patient_list', 'countries', 'quarter'));

        //return view('layouts.clinic.add_summary_patient_surrogacy_application_form');
    }

    public function summarypatientartapplicationformSubmit(Request $request)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        //  dd($request->all());  

        // $request->validate([
        // 'cli_reg_name' => 'required',
        // 'name_of_clinic' => 'required',
        //   'month' => 'string|required',
        //   'year' => 'string|required',
        // 'no_indian_nationals' => 'integer|required',
        // 'no_foreign_nationals' => 'integer|required',
        // 'no_ongoing_self_gametes' => 'integer|required',
        // 'no_ongoing_oocytes_donor_semen' => 'integer|required',
        // 'no_ongoing_semen_donor_oocytes' => 'integer|required',            
        // 'no_ongoing_single_woman' => 'integer|required',
        // 'no_completed_self_gametes' => 'integer|required',
        // 'no_completed_oocytes_donor_semen' => 'integer|required',
        // 'no_completed_semen_donor_oocytes' => 'integer|required',
        // 'no_completed_single_woman' => 'integer|required',
        // 'no_surrogate_mother_ongoing' => 'integer|required',
        // 'no_surrogate_mother_completed' => 'integer|required',
        // 'form_submission_date' => 'string|required',







        //   ], [
        //    //    'month.required' => 'Select Month.',
        //     'year.required' => 'Select Year.',
        // 'no_indian_nationals.required' => 'Enter Number of Indian Nationals',
        // 'no_foreign_nationals.required' => 'Enter Number of Indian Nationals',
        // 'no_ongoing_self_gametes.required' => 'Select Month.',
        // 'no_ongoing_oocytes_donor_semen.required' => 'Select Month.',
        // 'no_ongoing_semen_donor_oocytes.required' => 'Select Month.',
        // 'no_ongoing_single_woman.required' => 'Select Month.',
        // 'no_completed_self_gametes.required' => 'Select Month.',
        // 'no_completed_oocytes_donor_semen.required' => 'Select Month.',
        // 'no_completed_semen_donor_oocytes.required' => 'Select Month.',
        // 'no_completed_single_woman.required' => 'Select Month.',
        // 'no_surrogate_mother_ongoing.required' => 'Select Month.',
        // 'no_surrogate_mother_completed.required' => 'Select Month.',
        // 'form_submission_date.required' => 'Select Month.',


        //   ]);    

        $userId = Session::get('id');
        // $add_data = signup::with('clinic_reg_no')->whereHas('clinic_reg_no')->where('id', $userId)->first();  
        $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTCLINIC')
            ->where('level', 'Level-1')
            ->first();

        // dd($add_data);
        if (!$add_data) {
            return back()->with('error', 'ART Clinic Registration data not found.');
        }
        // Check if the fetched value (hidden input) matches the actual database value
        if ($request->clinic_level1_reg_num !== $add_data->registration_no) {
            return back()->withInput()->with('error', 'Invalid request: Data has been modified illegally!');
        }
        if ($request->name_of_clinic !== $add_data->name) {
            return back()->withInput()->with('error', 'Invalid request: Data has been modified illegally!');
        }
        // Check if already exists
        $alreadyExists = SummaryPatientArtLevelOneClinic::where('userid', $userId)
            ->where('quarter', $request->quarter)
            ->where('year', $request->year)
            ->exists();

        if ($alreadyExists) {
            // Redirect back with a session flash message
            return redirect()->back()->with('exists', 'Selected Quarter and Year already exists.');
        }

        // dd($add_data);

        $patient_add_data = new SummaryPatientArtLevelOneClinic();
        $patient_add_data->userid = $add_data->userid_applicant;
        $patient_add_data->clinic_id = $add_data->clinic_id;
        $patient_add_data->fill($request->except(['_token']));
        // $p_clinicid=$add_data->surrogacy_reg_no->id;
        //   dd($patient_add_data)   ;      
        $patient_add_data->save();

        return redirect()->route('clinic.summary_add_patient_art_application_form')->with('success', 'Updated Successfully');
    }

    public function summarypatientarttwoapplicationform()
    {

        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        $countries = countrytable::all();
        $quarter = QuarterTable::all();
        // $patient_list = signup::with('clinic_reg_no')->whereHas('clinic_reg_no')->where('id', $userId)->first();
        $patient_list = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTCLINIC')
            ->where('level', 'Level-2')
            ->first();
        $clinic = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('clinic_type', 'ARTCLINIC')
            ->where('status', 1)
            ->firstOrFail();
        return view(
            'summary.clinic.add_summary_patient_art_application_formtwo',
            compact('patient_list', 'countries', 'quarter', 'clinic')
        );
    }


    // public function summarypatientarttwoapplicationformSubmit(Request $request)
    // {
    //     if (empty(Session::has('id'))) {
    //         return redirect()->route('clinic.loginclinicform');
    //     }     
    //     $data = $request->all();  



    //     $userId = Session::get('id');
    //     // $add_data = signup::with('clinic_reg_no')->whereHas('clinic_reg_no')->where('id', $userId)->first();  
    //     $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)
    //             ->where('status',1)
    //             ->where('clinic_type', 'ARTCLINIC')
    //             ->where('level', 'Level-2')
    //             ->first();
    //             $clinicId=$add_data->clinic_id;
    //    // dd($add_data);
    //     if (!$add_data) {
    //         return back()->with('error', 'ART Clinic Registration data not found.');
    //     }       
    //     // Check if the fetched value (hidden input) matches the actual database value
    //     if ($request->clinic_level1_reg_num !== $add_data->registration_no) {
    //         return back()->withInput()->with('error', 'Invalid request: Data has been modified illegally!');
    //     }
    //     if ($request->name_of_clinic !== $add_data->name) {
    //         return back()->withInput()->with('error', 'Invalid request: Data has been modified illegally!');
    //     }

    //     // Check if already exists
    //     $alreadyExists = SummaryPatientArtLevelTwoClinic::where('userid', $userId)
    //     ->where('clinic_id',$clinicId)
    //     ->where('quarter', $request->quarter)
    //     ->where('year', $request->year)
    //     ->exists();

    //     if ($alreadyExists) {
    //     // Redirect back with a session flash message
    //     return redirect()->back()->with('exists', 'Selected Quarter and Year already exists.');
    //     }


    //     $patient_add_data = new SummaryPatientArtLevelTwoClinic(); 
    //     $patient_add_data->userid = $add_data->userid_applicant;
    //     $patient_add_data->clinic_id = $add_data->clinic_id; 
    //     $patient_add_data->fill($request->except(['_token']));       
    //    // $p_clinicid=$add_data->surrogacy_reg_no->id;
    //  //   dd($patient_add_data)   ;      
    //         $patient_add_data->save();

    // return redirect()->route('clinic.summary_add_patient_art_two_application_form')->with('success', 'Updated Successfully');
    // }


    public function summarypatientarttwoapplicationformSubmit(Request $request)
    {
        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');

        $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTCLINIC')
            ->where('level', 'Level-2')
            ->first();

        if (!$add_data) {
            return back()->with('error', 'ART Clinic Registration data not found.');
        }

        $clinicId = $add_data->clinic_id;

        /* 🔐 Security checks */
        if ($request->clinic_level1_reg_num !== $add_data->registration_no) {
            return back()->withInput()->with('error', 'Invalid request!');
        }

        if ($request->name_of_clinic !== $add_data->name) {
            return back()->withInput()->with('error', 'Invalid request!');
        }

        /* 🔎 Find existing record */
        $patient_add_data = SummaryPatientArtLevelTwoClinic::where('userid', $userId)
            ->where('clinic_id', $clinicId)
            ->where('quarter', $request->quarter)
            ->where('year', $request->year)
            ->first();


        if ($patient_add_data) {

            $patient_add_data->fill($request->except('_token'));
            $patient_add_data->updated_at = now();
            $patient_add_data->save();

            return redirect()
                ->route('clinic.summary_add_patient_art_two_application_form')
                ->with('success', 'Updated Successfully');
        }


        $patient_add_data = new SummaryPatientArtLevelTwoClinic();
        $patient_add_data->userid    = $userId;
        $patient_add_data->clinic_id = $clinicId;
        $patient_add_data->fill($request->except('_token'));
        $patient_add_data->save();

        return redirect()
            ->route('clinic.summary_add_patient_art_two_application_form')
            ->with('success', 'Saved Successfully');
    }


    public function summarypatientbankapplicationform()
    {

        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        $countries = countrytable::all();
        $quarter = QuarterTable::all();
        // $patient_list = signup::with('bank_reg_no')->whereHas('bank_reg_no')->where('id', $userId)->first();
        $patient_list = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTBANK')->first();
        return view('layouts/clinic/add_summary_patient_bank_application_form', compact('patient_list', 'countries', 'quarter'));

        //return view('layouts.clinic.add_summary_patient_surrogacy_application_form');
    }
    public function summarypatientbankapplicationformSubmit(Request $request)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $data = $request->all();

        // $request->validate([
        // 'cli_reg_name' => 'required',
        // 'name_of_clinic' => 'required',
        //   'month' => 'string|required',
        //   'year' => 'string|required',
        // 'no_indian_nationals' => 'integer|required',
        // 'no_foreign_nationals' => 'integer|required',
        // 'no_ongoing_self_gametes' => 'integer|required',
        // 'no_ongoing_oocytes_donor_semen' => 'integer|required',
        // 'no_ongoing_semen_donor_oocytes' => 'integer|required',            
        // 'no_ongoing_single_woman' => 'integer|required',
        // 'no_completed_self_gametes' => 'integer|required',
        // 'no_completed_oocytes_donor_semen' => 'integer|required',
        // 'no_completed_semen_donor_oocytes' => 'integer|required',
        // 'no_completed_single_woman' => 'integer|required',
        // 'no_surrogate_mother_ongoing' => 'integer|required',
        // 'no_surrogate_mother_completed' => 'integer|required',
        // 'form_submission_date' => 'string|required',







        //   ], [
        //    //    'month.required' => 'Select Month.',
        //     'year.required' => 'Select Year.',
        // 'no_indian_nationals.required' => 'Enter Number of Indian Nationals',
        // 'no_foreign_nationals.required' => 'Enter Number of Indian Nationals',
        // 'no_ongoing_self_gametes.required' => 'Select Month.',
        // 'no_ongoing_oocytes_donor_semen.required' => 'Select Month.',
        // 'no_ongoing_semen_donor_oocytes.required' => 'Select Month.',
        // 'no_ongoing_single_woman.required' => 'Select Month.',
        // 'no_completed_self_gametes.required' => 'Select Month.',
        // 'no_completed_oocytes_donor_semen.required' => 'Select Month.',
        // 'no_completed_semen_donor_oocytes.required' => 'Select Month.',
        // 'no_completed_single_woman.required' => 'Select Month.',
        // 'no_surrogate_mother_ongoing.required' => 'Select Month.',
        // 'no_surrogate_mother_completed.required' => 'Select Month.',
        // 'form_submission_date.required' => 'Select Month.',


        //   ]);    

        $userId = Session::get('id');
        $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTBANK')
            ->first();
        $clinic_id = $add_data->clinic_id;
        // dd($add_data);
        if (!$add_data) {
            return back()->with('error', 'ART Bank Registration data not found.');
        }
        // Check if the fetched value (hidden input) matches the actual database value
        if ($request->bank_reg_num !== $add_data->registration_no) {
            return back()->withInput()->with('error', 'Invalid request: Data has been modified illegally!');
        }
        if ($request->name_of_bank !== $add_data->name) {
            return back()->withInput()->with('error', 'Invalid request: Data has been modified illegally!');
        }
        // Check if already exists
        $alreadyExists = SummaryPatientBankClinic::where('userid', $userId)
            ->where('clinic_id', $clinic_id)
            ->where('quarter', $request->quarter)
            ->where('year', $request->year)
            ->exists();

        if ($alreadyExists) {
            // Redirect back with a session flash message
            return redirect()->back()->with('exists', 'Selected Quarter and Year already exists.');
        }

        // dd($add_data);


        $patient_add_data = new SummaryPatientBankClinic();
        $patient_add_data->userid = $add_data->userid_applicant;
        $patient_add_data->clinic_id = $add_data->clinic_id;
        $patient_add_data->fill($request->except(['_token']));
        // $p_clinicid=$add_data->surrogacy_reg_no->id;
        //   dd($patient_add_data)   ;      
        $patient_add_data->save();

        return redirect()->route('clinic.summary_add_patient_bank_application_form')->with('success', 'Updated Successfully');
    }




    public function list_artclinic_patient_quarter_view_patient()
    {

        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $clinic_id = ClinicRegistrationModel::where('userid_applicant', session()->get('id'))
            ->where('status', 1)
            ->where('clinic_type', 'ARTCLINIC')
            ->value('clinic_id');
        $userId = Session::get('id');
        $quarter = QuarterTable::all();
        $quarter_list = PatientPeriodReportingTable::select('quarter', 'year', 'id','status')
            ->distinct()
            ->where('clinic_id', $clinic_id)
            ->orderBy('year', 'desc')
            ->orderBy('quarter', 'desc')
            ->get();

        $patient_list = DB::connection('patient_clinic_database')
            ->table('patient_artclinic AS pa')
            ->select(
                'pa.quarter',
                'pa.year',
                DB::raw('COUNT(*) as patient_count')
            )
            ->Join('patient_period_reporting_table AS pprt', 'pprt.id', '=', 'pa.reporting_id')
            ->where('pa.clinic_id', $clinic_id)
            ->groupBy('pa.quarter', 'pa.year')
            ->orderBy('pa.year', 'desc')
            ->orderBy('pa.quarter', 'desc')
            ->get();




        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();


        return view('layouts.clinic.list_artclinic_patient_quarter_view_patient', compact('quarterDescriptions', 'patient_list', 'quarter_list'));
    }

    public function list_artbank_patient_quarter_view_patient()
    {
        // dd(session()->get('clinic_reg'));

        // dd($patient_list );

        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $clinic_id = ClinicRegistrationModel::where('userid_applicant', session()->get('id'))
            ->where('status', 1)
            ->where('clinic_type', 'ARTBANK')
            ->value('clinic_id');
        $userId = Session::get('id');
        $quarter = QuarterTable::all();


        $quarter_list   = PatientPeriodReportingTable::select('quarter', 'year', 'id','status')
            ->distinct()
            ->where('clinic_id', $clinic_id)
            ->orderBy('year', 'desc')
            ->orderBy('quarter', 'desc')
            ->get();

        $patient_list = DB::connection('patient_clinic_database')
            ->table('patient_artbank AS pb')
            ->select(
                'pb.quarter',
                'pb.year',
                DB::raw('COUNT(*) as patient_count')
            )
            ->Join('patient_period_reporting_table AS pprt', 'pprt.id', '=', 'pb.reporting_id')
            ->where('pb.clinic_id', $clinic_id)
            ->groupBy('pb.quarter', 'pb.year')
            ->orderBy('pb.year', 'desc')
            ->orderBy('pb.quarter', 'desc')
            ->get();
        // dd($patient_list );
        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();
        return view('layouts.clinic.list_artbank_patient_quarter_view_patient', compact('quarterDescriptions', 'patient_list', 'quarter_list'));
    }




    public function showUHIDs_artclinic($encrypted)
    {
        $userId = Session::get('id');
        // $quarter = $request->quarter;
        $clinic_id = ClinicRegistrationModel::where('userid_applicant', session()->get('id'))
            ->where('status', 1)
            ->where('clinic_type', 'ARTCLINIC')
            ->value('clinic_id');
        $decrypted = Crypt::decrypt($encrypted); // e.g. "1|2025"
        [$quarter, $year] = explode('|', $decrypted);

        $data = PatientArtclinic::select(
            'patient_artclinic.id',
            'patient_artclinic.patient_uhid',
            'patient_artclinic.art_proc_undertaken',
            'patient_artclinic.treat_outcomes',
            'patient_period_reporting_table.status'
        )
            ->join('patient_period_reporting_table', function ($join) {
                $join->on('patient_period_reporting_table.clinic_id', '=', 'patient_artclinic.clinic_id')
                    ->on('patient_period_reporting_table.year', '=', 'patient_artclinic.year')
                    ->on('patient_period_reporting_table.quarter', '=', 'patient_artclinic.quarter')
                    ->on('patient_period_reporting_table.id', '=', 'patient_artclinic.reporting_id');
            })
            ->where('patient_artclinic.quarter', $quarter)
            ->where('patient_artclinic.year', $year)
            ->where('patient_artclinic.clinic_id', $clinic_id)
            ->get();
        // dd($data);      
        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();


        return view('layouts.clinic.list_artclinic_patient_quarter_view_patient_uhid', compact('quarter', 'year', 'data', 'quarterDescriptions'));
    }

    public function showUHIDs_artbank($encrypted)
    {
        $userId = Session::get('id');
        // $quarter = $request->quarter;
        //  $year = $request->year;
        $clinic_id = ClinicRegistrationModel::where('userid_applicant', session()->get('id'))
            ->where('status', 1)
            ->where('clinic_type', 'ARTBANK')
            ->value('clinic_id');
        $decrypted = Crypt::decrypt($encrypted);
        [$quarter, $year] = explode('|', $decrypted);

        $data = PatientArtbank::select(
            'patient_artbank.donor_id',
            'patient_period_reporting_table.status'
        )
            ->join('patient_period_reporting_table', function ($join) {
                $join->on('patient_period_reporting_table.clinic_id', '=', 'patient_artbank.clinic_id')
                    ->on('patient_period_reporting_table.year', '=', 'patient_artbank.year')
                    ->on('patient_period_reporting_table.quarter', '=', 'patient_artbank.quarter')
                    ->on('patient_period_reporting_table.id', '=', 'patient_artbank.reporting_id');
            })
            ->where('patient_artbank.quarter', $quarter)
            ->where('patient_artbank.year', $year)
            ->where('patient_artbank.clinic_id', $clinic_id)
            ->get();

        // dd($data);


        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();

        return view('layouts.clinic.list_artbank_patient_quarter_view_patient_uhid', compact('quarter', 'year', 'data', 'quarterDescriptions'));
    }



    public function editPatientArtclinic(Request $request, $uhid = NULL)
    {
        // dd($uhid);
        $userId = Session::get('id');
        $countries = countrytable::all();
        $decryptedUhid = Crypt::decrypt($uhid);
        $add = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTCLINIC')->first();
        // $uhidDetails = PatientArtclinic::where('patient_uhid',$decryptedUhid)->where('clinic_id', $add->clinic_id)->first(); // Fetch the UHID data
        $uhidDetails = PatientArtclinic::where('id', $decryptedUhid)->where('clinic_id', $add->clinic_id)->first(); // Fetch the UHID data
        // $add = signup::with('clinic_reg_no')
        //         ->whereHas('clinic_reg_no')
        //         ->where('id', $userId)
        //         ->first();

        // $get_leval = ClinicRegistrationModel::where('userid',$userId)->get();
        // if($get_leval->level = 'Level-1'){
        //     $add = ClinicRegistrationModel::where('userid_applicant', $userId)->where('clinic_type', 'ARTCLINIC')->where('level', 'Level-1')->first();
        // }elseif($get_leval->level = 'Level-2'){
        //          $add = ClinicRegistrationModel::where('userid_applicant', $userId)->where('clinic_type', 'ARTCLINIC')->where('level', 'Level-2')->first();
        // }else{
        //      $add = ClinicRegistrationModel::where('userid_applicant', $userId)->where('clinic_type', 'ARTCLINIC')->first();
        // }

        // $reportData = PatientPeriodReportingTable::with('quarter')
        //     ->where(function ($query) {
        //         $query->where('status', '=', 'Live')
        //             ->orWhereNull('status');
        //     })
        //     ->latest()
        //     ->get(); 
        // $reporting_data = PatientPeriodReportingTable::where('status', 'Live')->where('userid',$userId)->where('clinic_id', $add->clinic_id)->first();
        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();

        // $available_quarters = PatientPeriodReportingTable::where('status', 'Live')->where('userid',$userId)->where('clinic_id', $add->clinic_id)
        //     ->select('quarter')
        //     ->distinct()
        //     ->orderBy('quarter')
        //     ->get()
        //     ->map(function ($q) use ($quarterDescriptions) {
        //         return [
        //             'id' => $q->quarter,
        //             'description' => $quarterDescriptions[$q->quarter] ?? $q->quarter,
        //         ];
        //     });
        $available_quarters = PatientPeriodReportingTable::where('status', 'Live')
            ->where('userid', $userId)
            ->where('clinic_id', $add->clinic_id)
            ->select('quarter')
            ->first();

        if ($available_quarters) {
            $available_quarters->description = $quarterDescriptions[$available_quarters->quarter];
        }
        $available_years = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $add->clinic_id)
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->get();

        $clinic_id = $add->clinic_id;
        return view('layouts.clinic.edit_patient_clinic_application_form', compact('uhidDetails', 'available_quarters', 'available_years', 'countries', 'clinic_id'));
    }

    public function viewPatientArtclinic(Request $request, $uhid = NULL)
    {
        $userId = Session::get('id');
        $countries = countrytable::all();
        $decryptedUhid = Crypt::decrypt($uhid);
        $clinic = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTCLINIC')->first();
        $patient = PatientArtclinic::select('patient_artclinic.*', 'country_husband.country_name as husband_country_name', 'country_wife.country_name as wife_country_name')
            ->leftJoin('art_dbnew_testing.apps_countries as country_husband', 'country_husband.id', '=', 'patient_artclinic.other_nationality')
            ->leftJoin('art_dbnew_testing.apps_countries as country_wife', 'country_wife.id', '=', 'patient_artclinic.other_nationality_wife')
            ->where('patient_artclinic.id', $decryptedUhid)
            ->where('patient_artclinic.clinic_id', $clinic->clinic_id)
            ->first();
        $quarter = QuarterTable::select('description')->where('quarter', $patient->quarter)->first();

        $aq = $quarter ? $quarter->description : 'N/A';
        //  $available_quarters = PatientPeriodReportingTable::where('status', 'Live')
        //     ->where('userid', $userId)
        //     ->where('clinic_id', $clinic->clinic_id)
        //     ->select('quarter')
        //     ->first();

        // if ($available_quarters) {
        //     $available_quarters->description = $quarterDescriptions[$available_quarters->quarter];
        // }
        //         $available_years = PatientPeriodReportingTable::where('status', 'Live')->where('userid',$userId)->where('clinic_id', $add->clinic_id)
        //             ->select('year')
        //             ->distinct()
        //             ->orderByDesc('year')
        //             ->get();
        // $clinic_id = $add->clinic_id; 
        // dd($patient);
        return view('layouts.clinic.artclinic_patient_view', compact('patient', 'clinic', 'countries', 'decryptedUhid', 'aq'));
    }



    public function editPatientArtbank(Request $request, $uhid = NULL)
    {

        $userId = Session::get('id');
        $countries = countrytable::all();
        $decryptedUhid = Crypt::decrypt($uhid);
        $add = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTBANK')->first();
        $uhidDetails = PatientArtbank::where('donor_id', $decryptedUhid)->where('clinic_id', $add->clinic_id)->first(); // Fetch the UHID data

        // $add = signup::with('bank_reg_no')
        // ->whereHas('bank_reg_no')
        // ->where('id', $userId)
        // ->first();



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
        // dd( $uhidDetails);
        return view('layouts.clinic.edit_patient_bank_application_form', compact('uhidDetails', 'available_quarters', 'available_years', 'countries', 'clinic_id'));
    }

    public function viewPatientArtBank(Request $request, $uhid = NULL)
    {
        $userId = Session::get('id');
        $countries = countrytable::all();
        $decryptedUhid = Crypt::decrypt($uhid);
        $clinic = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTBANK')->first();
        $patient = PatientArtbank::where('donor_id', $decryptedUhid)->where('clinic_id', $clinic->clinic_id)->first();
        $quarter = QuarterTable::select('description')->where('quarter', $patient->quarter)->first();

        $aq = $quarter ? $quarter->description : '';
        //  $available_quarters = PatientPeriodReportingTable::where('status', 'Live')
        //     ->where('userid', $userId)
        //     ->where('clinic_id', $clinic->clinic_id)
        //     ->select('quarter')
        //     ->first();

        // if ($available_quarters) {
        //     $available_quarters->description = $quarterDescriptions[$available_quarters->quarter];
        // }
        //         $available_years = PatientPeriodReportingTable::where('status', 'Live')->where('userid',$userId)->where('clinic_id', $add->clinic_id)
        //             ->select('year')
        //             ->distinct()
        //             ->orderByDesc('year')
        //             ->get();
        // $clinic_id = $add->clinic_id; 
        // dd($patient);
        return view('layouts.clinic.artbank_patient_view', compact('patient', 'clinic', 'countries', 'decryptedUhid', 'aq'));
    }






    public function summarypatientartapplicationformSubmiteditpatient(Request $request)
    {
        //dd('ddh');
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $data = $request->all();
        $quarter = QuarterTable::all();
        //dd($request->id);
        $userId = Session::get('id');
        $patient_list = signup::with('clinic_reg_no')->whereHas('clinic_reg_no')->where('id', $userId)->get();
        // Find the record to update
        $report = PatientArtclinic::findOrFail($request->id);
        //  dd($report);
        // Update the record with new data
        $report->update($request->all());

        $reportData = PatientPeriodReportingTable::with('quarter')
            ->where(function ($query) {
                $query->where('status', '=', 'Live')
                    ->orWhereNull('status');
            })
            ->latest()
            ->get();

        return redirect()->route('clinic.list_artclinic_patient_quarter_view_patient_uhid', compact('quarter', 'reportData', 'patient_list'));
    }



    // public function summarypatientartapplicationformSubmiteditpatient(Request $request)
    //     {
    //         //dd('ddh');
    //         if (empty(Session::has('id'))) {
    //             return redirect()->route('clinic.loginclinicform');
    //         }     
    //         $data = $request->all();  
    //         $quarter = QuarterTable::all();    
    //       //dd($request->id);
    //         $userId = Session::get('id');    
    //         $patient_list = signup::with('clinic_reg_no')->whereHas('clinic_reg_no')->where('id', $userId)->get();    
    //         // Find the record to update
    //     $report = PatientArtclinic::findOrFail($request->id);
    //      dd($report);
    //     // Update the record with new data
    //     $report->update($request->all()); 

    //     $reportData = PatientPeriodReportingTable::with('quarter')
    //     ->where(function ($query) {
    //         $query->where('status', '=', 'Live')
    //               ->orWhereNull('status');
    //     })
    //     ->latest()
    //     ->get(); 

    //     return redirect()->route('clinic.list_artclinic_patient_quarter_view_patient_uhid',compact('quarter', 'reportData', 'patient_list')); 


    //     }
























    public function list_artclinic_patient_quarter_view()
    {
        // dd('ffjfjjfuu');
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        $quarter = QuarterTable::all();

        $add = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('clinic_type', 'ARTCLINIC')
            ->where('status', 1)
            ->where('level', 'Level-2')
            ->first();
        $clinicId = $add->clinic_id;
        // $reportData = PatientPeriodReportingTable::with('quarter')
        // ->where(function ($query) {
        //     $query->where('status', '=', 'Live')
        //           ->orWhereNull('status');
        // })
        // ->latest()
        // ->get(); 
        $patient_list = SummaryPatientArtLevelTwoClinic::where('userid', $userId)->where('clinic_id', $clinicId)->get();
        $reporting_data = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $clinicId)->first();
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

        //  $quarterId = $request->input('quarter');
        //  $year = $request->input('year');

        // ✅ Default value for view
        $exists = false;

        //  if ($quarterId && $year) {
        $exists = PatientPeriodReportingTable::where('userid', $userId)
            ->where('clinic_id', $clinicId)
            // ->where('quarter', $quarterId)
            // ->where('year', $year)
            ->where('status', 'Live')
            ->where('status', 'Finished')
            ->exists();
        //  dd($patient_list);
        //dd( $exists );
        // Show "already live" view if needed
        //     if ($exists) {
        //         return view('layouts/clinic/add_patient_reporting_already_live_period_clinic_application_form', compact('quarter', 'reportData', 'exists','reporting_data', 'available_quarters',
        // 'available_years'));
        //     }

        // if (!$exists) {
        //     return view('layouts/clinic/add_patient_reporting_period_clinic_application_form', compact('quarter', 'reportData', 'exists'));
        // }
        return view('layouts.clinic.list_artclinic_patient_quarter_view', compact(
            'quarter',
            'exists',
            'reporting_data',
            'available_quarters',
            'available_years',
            'patient_list'
        ));
    }


    public function list_artclinicone_patient_quarter_view()
    {
        //  dd('sdsh');
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        if (empty(session()->has('patient_artclinic_registration_no') && session()->has('id'))) {

            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        $quarter = QuarterTable::all();
        $patient_list = SummaryPatientArtLevelOneClinic::where('userid', $userId)->get();
        $add = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTCLINIC')
            ->where('level', 'Level-1')
            ->first();

        $clinicId = $add->clinic_id;
        // $reportData = PatientPeriodReportingTable::with('quarter')
        // ->where(function ($query) {
        //     $query->where('status', '=', 'Live')
        //           ->orWhereNull('status');
        // })
        // ->latest()
        // ->get(); 
        $patient_list = SummaryPatientArtLevelOneClinic::where('userid', $userId)->where('clinic_id', $clinicId)->get();
        // dd($patient_list);
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
                    'description' => $quarterDescriptions[$q->quarter] ??  $q->quarter,
                ];
            });

        $available_years = PatientPeriodReportingTable::where('status', 'Live')->where('userid', $userId)->where('clinic_id', $clinicId)
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->get();

        $exists = false;

        //  if ($quarterId && $year) {
        $exists = PatientPeriodReportingTable::where('userid', $userId)
            ->where('clinic_id', $clinicId)
            // ->where('quarter', $quarterId)
            // ->where('year', $year)
            ->where('status', 'Live')
            ->exists();



        return view('layouts.clinic.list_artclinicone_patient_quarter_view', compact(
            'quarter',
            'exists',
            'reporting_data',
            'available_quarters',
            'available_years',
            'patient_list'
        ));
    }








    public function list_artbank_patient_quarter_view()
    {
        //  dd('sdsh');
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        if (empty(session()->has('patient_artbank_registration_no') && session()->has('id'))) {

            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        $quarter = QuarterTable::all();

        // $add = signup::with('bank_reg_no')
        //     ->whereHas('bank_reg_no')
        //     ->where('id', $userId)
        //     ->first();

        $add = ClinicRegistrationModel::where('userid_applicant', $userId)->where('clinic_type', 'ARTBANK')->where('status', 1)->first();

        $clinicId = $add->clinic_id;
        $patient_list = SummaryPatientBankClinic::where('userid', $userId)->where('clinic_id', $clinicId)->get();
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
        $exists = PatientPeriodReportingTable::where('userid', $userId)
            ->where('clinic_id', $clinicId)
            // ->where('quarter', $quarterId)
            // ->where('year', $year)
            ->where('status', 'Live')
            ->where('status', 'Finished')
            ->exists();
        return view('layouts.clinic.list_artbank_patient_quarter_view', compact(
            'quarter',
            'exists',
            'reporting_data',
            'available_quarters',
            'available_years',
            'patient_list'
        ))->with('success', 'data updated successfully');
    }
































    public function editSummaryPatientArtTwo($id)
    {
        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        // $patient_list = signup::with('clinic_reg_no')->whereHas('clinic_reg_no')->where('id', $userId)->get();
        $patient_list = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTCLINIC')
            ->where('level', 'Level-2')
            ->first();

        $en_id = Crypt::decrypt($id);
        $report = SummaryPatientArtLevelTwoClinic::with('quarterdesc')->findOrFail($en_id);
        //  $report = SummaryPatientArtLevelTwoClinic::findOrFail($id);

        return view('layouts.clinic.edit_summary_patient_art_two_application_form', compact('report'));
    }
    public function editSummaryPatientArtOne($id)
    {
        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        // $patient_list = signup::with('clinic_reg_no')->whereHas('clinic_reg_no')->where('id', $userId)->get();
        $patient_list = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTCLINIC')
            ->where('level', 'Level-1')
            ->first();

        $en_id = Crypt::decrypt($id);
        $report = SummaryPatientArtLevelOneClinic::with('quarterdesc')->findOrFail($en_id);

        //   $report = SummaryPatientArtLevelOneClinic::findOrFail($id);

        return view('layouts.clinic.edit_summary_patient_art_one_application_form', compact('report'));
    }

    public function editSummaryPatientbank($id)
    {
        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }
        // $userId = Session::get('id');  
        // $patient_list = signup::with('bank_reg_no')->whereHas('bank_reg_no')->where('id', $userId)->get();
        //    $patient_list = ClinicRegistrationModel::where('userid_applicant', $userId)
        //             ->where('status',1)
        //             ->where('clinic_type', 'ARTBANK')
        //             ->first();

        $en_id = Crypt::decrypt($id);
        $report = SummaryPatientBankClinic::with('quarterdesc')->findOrFail($en_id);
        return view('layouts.clinic.edit_summary_patient_bank_application_form', compact('report'));
    }

    public function viewSummaryPatientbank($id)
    {
        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');
        $en_id = Crypt::decrypt($id);
        $report = SummaryPatientBankClinic::findOrFail($en_id);

        // Generate PDF from a Blade view
        $pdf = Pdf::loadView('layouts.clinic.view_summary_patient_bank_application_form', compact('report'));

        return $pdf->download('bank_summary_' . $report->year . '_Q' . $report->quarter . '.pdf');
    }

    public function viewSummaryPatientArtOne($id)
    {
        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');
        $en_id = Crypt::decrypt($id);
        $report = SummaryPatientArtLevelOneClinic::findOrFail($en_id);

        // Generate PDF from a Blade view
        $pdf = Pdf::loadView('layouts.clinic.view_summary_patient_art_one_application_form', compact('report'));

        return $pdf->download('artone_summary_' . $report->year . '_Q' . $report->quarter . '.pdf');
    }

    public function viewSummaryPatientArtTwo($id)
    {
        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');
        $en_id = Crypt::decrypt($id);
        $report = SummaryPatientArtLevelTwoClinic::findOrFail($en_id);

        // Generate PDF from a Blade view
        $pdf = Pdf::loadView('layouts.clinic.view_summary_patient_art_two_application_form', compact('report'));

        return $pdf->download('arttwo_summary_' . $report->year . '_Q' . $report->quarter . '.pdf');
    }


    // public function viewSummaryPatientbank($id)
    // {
    //     if (!Session::has('id')) {
    //         return redirect()->route('clinic.loginclinicform');
    //     }
    //     $userId = Session::get('id');  
    //     $patient_list = signup::with('bank_reg_no')->whereHas('bank_reg_no')->where('id', $userId)->get();
    //    // $patient_list = SummaryPatientArtLevelTwoClinic::where('userid',$userId)->get();

    //     $en_id = Crypt::decrypt($id);
    //     $report = SummaryPatientBankClinic::findOrFail($en_id);
    //     return view('layouts.clinic.view_summary_patient_bank_application_form', compact('report'));
    // }





    public function summarypatientarttwoapplicationformSubmitedit(Request $request)
    {
        //dd('ddh');
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $data = $request->all();
        $quarter = QuarterTable::all();
        //dd($request->id);
        $userId = Session::get('id');
        $patient_list = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTCLINIC')
            ->where('level', 'Level-2')
            ->first();

        // Find the record to update
        $report = SummaryPatientArtLevelTwoClinic::findOrFail($request->id);
        // dd($record);
        // Update the record with new data
        $report->update($request->all());

        $reportData = PatientPeriodReportingTable::with('quarter')
            ->where(function ($query) {
                $query->where('status', '=', 'Live')
                    ->orWhereNull('status');
            })
            ->latest()
            ->get();

        return redirect()->route('clinic.list_artclinic_patient_quarter_view', compact('quarter', 'reportData', 'patient_list'))->with('success', 'data updated successfully');
    }
    public function summarypatientartoneapplicationformSubmitedit(Request $request)
    {
        //dd('ddh');
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $data = $request->all();
        $quarter = QuarterTable::all();
        //dd($request->id);
        $userId = Session::get('id');
        $patient_list = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTCLINIC')
            ->where('level', 'Level-1')
            ->first();
        // Find the record to update
        $report = SummaryPatientArtLevelOneClinic::findOrFail($request->id);
        // dd($record);
        // Update the record with new data
        $report->update($request->all());
        // dd($report);
        $reportData = PatientPeriodReportingTable::with('quarter')
            ->where(function ($query) {
                $query->where('status', '=', 'Live')
                    ->orWhereNull('status');
            })
            ->latest()
            ->get();

        return redirect()->route('clinic.list_artclinicone_patient_quarter_view', compact('quarter', 'reportData', 'patient_list'))->with('success', 'data updated successfully');
    }
    public function summarypatientbankapplicationformSubmitedit(Request $request)
    {
        //dd('ddh');
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $data = $request->all();
        $quarter = QuarterTable::all();
        //dd($request->id);
        $userId = Session::get('id');
        // $patient_list = signup::with('bank_reg_no')->whereHas('bank_reg_no')->where('id', $userId)->get(); 
        $patient_list = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTBANK')->first();
        // Find the record to update
        // dd($patient_list);
        $report = SummaryPatientBankClinic::findOrFail($request->id);
        //    dd($report);
        // Update the record with new data
        $report->update($data);

        // $reportData = PatientPeriodReportingTable::with('quarter')
        // ->where(function ($query) {
        //     $query->where('status', '=', 'Live')
        //           ->orWhereNull('status');
        // })
        // ->latest()
        // ->get(); 

        return redirect()->route('clinic.list_artbank_patient_quarter_view', compact('quarter', 'patient_list'))->with('success', 'data updated successfully');
    }


    public function patientartapplicationformSubmiteditpatient(Request $request)
    {
        try {
            if (!Session::has('id')) {
                return redirect()->route('clinic.loginclinicform');
            }
            DB::beginTransaction();
            $dec_uhid = decrypt($request->enc_uhid);

            if ($request->input('updatev') == 'deletebtn') {

                PatientArtclinic::where('quarter', $request->quarter)
                    ->where('year', $request->year)
                    ->where('clinic_id', $request->clinic_id)
                    ->where('id', $dec_uhid)
                    ->delete();

                return redirect()
                    ->route('clinic.list_artclinic_patient_quarter_view_patient')
                    ->with('success', 'Record deleted successfully');
            }


            $userId = Session::get('id');
            // $add_data = signup::with('clinic_reg_no')->whereHas('clinic_reg_no')->where('id', $userId)->first();
            $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTCLINIC')->first();
            $art_proc_undertaken = ['artificial insemination', 'intra-uterine insemination(IUI)', 'in vitro fertilization-embryo transfer', 'gamete intrafallopian tube transfer', 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)', 'physiological Intra-cytoplasmic sperm injection', 'intra-cytoplasmic morphologically selected sperm injection', 'round spermatid nucleus injection', 'Elongated spermatid injection', 'Others'];
            // dd($request->all());
            $rule = [
                'name_of_clinic' => 'required|string',
                'patient_uhid' => 'required|string|max:20',
                'case_of' => 'required|in:one,two',
                'nationality' => 'nullable|required_if:case_of,one|in:Indian,Foreigner',
                'other_nationality' => 'nullable|required_if:nationality,Foreigner|exists:apps_countries,id',
                'nationality_wife' => 'required|in:Indian,Foreigner',
                'other_nationality_wife' => 'nullable|required_if:nationality_wife,Foreigner|exists:apps_countries,id',
                'age_hus_wife' => 'nullable|required_if:case_of,one|numeric',
                'wife_age' => 'nullable|required_if:case_of,one|numeric',
                'age_of_women' => 'nullable|required_if:case_of,two|numeric',
                'male_factor' => 'in:Y,N',
                'female_factor' => 'in:Y,N',
                'unexplained' => 'in:Y,N',
                'cause_of_infretily' => 'required|string',
                'art_proc_undertaken' => 'required|in:' . implode(',', $art_proc_undertaken),
                'art_undertaken_other' => 'nullable|required_if:art_proc_undertaken,Others|string',
                'types_of_treat' => 'required|in:ART Treatment using self gametes,ART Treatment using donor gametes',
                'types_of_treat1' => 'nullable|required_if:types_of_treat,ART Treatment using donor gametes|in:Oocyte Donation,Sperm Donation,Both Oocyte Donation & Sperm Donation',
                'total_num_of_cyc' => 'required|numeric',
                'no_cycles' => 'required|numeric',
                'cyc_canc_failure_reason' => 'nullable|string',
                'treat_outcomes' => 'required|in:Pregnant,Not Pregnant',
                'complicatoins_if_any' => 'nullable|string',
                'remark' => 'nullable|string',
                'declaration' => [
                    Rule::requiredIf(function () use ($request) {
                        return $request->types_of_treat == "ART Treatment using donor gametes" &&
                            in_array($request->types_of_treat1, [
                                "Oocyte Donation",
                                "Both Oocyte Donation & Sperm Donation"
                            ]);
                    })
                ],
                'declaration1' => [
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
            $messages = [
                'patient_uhid.required' => 'Patient UHID is required.',
                'patient_uhid.max' => 'Patient UHID must not exceed 20 characters.',
                'name_of_clinic.required' => 'Please enter the name of the clinic.',
                'name_of_clinic.string' => 'Clinic name must be valid text.',
                'previous_treatment.required' => 'Please select whether previous treatment was taken.',
                'previous_treatment.in' => 'Invalid value selected for previous treatment.',
                'case_of.required' => 'Please select the case type.',
                'case_of.in' => 'Invalid case type selected.',
                'nationality.required_if' => 'Please select nationality of the Husband.',
                'nationality.in' => 'Nationality must be either Indian or Foreigner.',
                'other_nationality.required_if' => 'Please select the country when nationality is Foreigner.',
                'other_nationality.exists' => 'Selected nationality is invalid.',
                'nationality_wife.required' => 'Please select nationality of the Wife.',
                'nationality_wife.in' => 'Wife nationality must be either Indian or Foreigner.',
                'other_nationality_wife.required_if' => 'Please select wife country when nationality is Foreigner.',
                'other_nationality_wife.exists' => 'Selected wife nationality country is invalid.',
                'age_hus_wife.required_if' => 'Please enter age of husband.',
                'age_hus_wife.numeric' => 'Age of husband must be a number.',
                'wife_age.required_if' => 'Please enter age of wife.',
                'wife_age.numeric' => 'Age of wife must be a number.',
                'age_of_women.required_if' => 'Please enter age of woman.',
                'age_of_women.numeric' => 'Age of woman must be a number.',
                'male_factor.in' => 'Invalid selection for male factor.',
                'female_factor.in' => 'Invalid selection for female factor.',
                'unexplained.in' => 'Invalid selection for unexplained infertility.',
                'cause_of_infretily.required' => 'Please enter the cause of infertility.',
                'art_proc_undertaken.required' => 'Please select the ART procedure undertaken.',
                'art_proc_undertaken.in' => 'Invalid ART procedure selected.',
                'art_undertaken_other.required_if' => 'Please specify the ART procedure when "Others" is selected',
                'types_of_treat.required' => 'Please select the type of treatment.',
                'types_of_treat.in' => 'Invalid treatment type selected.',
                'types_of_treat1.required_if' => 'Please select donor type when donor gametes are used.',
                'types_of_treat1.in' => 'Invalid donor type selected.',
                'total_num_of_cyc.required' => 'Please enter total number of cycles.',
                'total_num_of_cyc.numeric' => 'Total number of cycles must be numeric.',
                'no_cycles.required' => 'Please enter number of cycles undertaken.',
                'no_cycles.numeric' => 'Number of cycles must be numeric.',
                'cyc_canc_failure_reason.required' => 'Please provide reason for cancellation.',
                'cyc_canc_failure_reason.string' => 'Reason must be valid text.',
                'treat_outcomes.required' => 'Please select treatment outcome.',
                'treat_outcomes.in' => 'Invalid treatment outcome selected.',
                'complicatoins_if_any.string' => 'Complications must be valid text.',
                'remark.string' => 'Remark must be valid text.',
                'declaration.required' => 'Please click that affidavit/undertaking** has been taken on record from Oocyte Donor that she has not donated oocytes more than once in her life time.',
                'declaration.accepted' => 'You must confirm the Oocyte Donor declaration.',
                'declaration1.required' => 'Please click on undertaking that affidavit/undertaking** has been taken on record from the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman or clinic and clinic has not used the sperm/oocyte of the same donor for more than one commissioning couple.',
                'declaration1.accepted' => 'You must confirm the ART Clinic declaration.',
            ];
            $request->validate($rule, $messages);

            if (!$add_data) {
                return back()->with('error', 'ART Clinic Registration data not found.');
            }


            $patient_list = PatientArtclinic::select('quarter', 'year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->orderBy('quarter', 'desc')
                ->get();

            $quarterDescriptions = [
                1 => 'April - June',
                2 => 'July - Sept',
                3 => 'Oct - Dec',
                4 => 'Jan - March',
            ];
            //  dd($reportId);
            $patient_add_data = PatientArtclinic::find($dec_uhid);

            //    dd($patient_add_data);
            if (!$patient_add_data) {
                return back()->with('error', 'Patient data not found for update.');
            }


            // Convert gender_child to string
            $formData = $request->except(['_token']);

            // $formData['gender_child'] = is_array($request->gender_child) ? implode(',', $request->gender_child) : $request->gender_child;

            // Update reporting table status
            // $report = PatientPeriodReportingTable::find($reportId);
            // if ($report) {
            //     $report->status = 'Live';
            //     $report->save();
            // }
            // Add tracking IDs

            // if ($request->treat_outcomes === 'Not Pregnant') {

            // $formData['male_number'] = null;
            // $formData['female_number'] = null;
            // }
            // if ($request->treat_outcomes === 'Stillbirth') {

            // $formData['l_birth'] = null;

            //  }
            if ($formData['types_of_treat'] == 'ART Treatment using donor gametes' && $formData['types_of_treat1'] == 'Sperm Donation') {
                $formData['declaration'] = NULL;
            }
            if ($formData['types_of_treat'] == 'ART Treatment using self gametes') {
                $formData['declaration'] = NULL;
                $formData['declaration1'] = NULL;
            }

            $formData['userid'] = $add_data->userid_applicant;
            $formData['clinic_id'] = $add_data->clinic_id;
            // dd('dsadsad');
            // $formData['reporting_id'] = $reportId;
            $formData['male_factor'] = !empty($formData['male_factor']) ? 'Y' : 'N';
            $formData['female_factor'] = !empty($formData['female_factor']) ? 'Y' : 'N';
            $formData['unexplained'] = !empty($formData['unexplained']) ? 'Y' : 'N';
            //dd($formData);
            // Update patient clinic data
            $patient_add_data->fill($formData);
            $patient_add_data->save();
            DB::commit();
            return redirect()->route('clinic.list_artclinic_patient_quarter_view_patient', compact('patient_list', 'quarterDescriptions'))->with('success', 'Patient details updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // dd('test1');
            DB::rollBack(); // Rollback transaction on validation failure
            Log::error('ART patient details form validation failed: ', [
                'errors' => $e->validator,
                'Clinic_id'  => $add_data->clinic_id
            ]);
            return redirect()->route('uhid.editPatientArtclinic', ['uhid' => encrypt($dec_uhid)])
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            // dd('test2');
            DB::rollBack(); // Rollback on any other error
            Log::error('Error updating clinic record: ', [
                'errors' => $e->getMessage(),
                'Clinic_id'  => $add_data->clinic_id
            ]);

            return redirect()->route('uhid.editPatientArtclinic', ['uhid' => encrypt($dec_uhid)])
                ->with('upd_error', 'An error occurred while updating. Please Contact support.')
                ->withInput();
        }
    }


    public function patientartbankapplicationformSubmiteditpatient(Request $request)
    {
        // dd('hjjjfjfjf');
        // dd( $request->all());
        try {
            if (!Session::has('id')) {
                return redirect()->route('clinic.loginclinicform');
            }

            if ($request->input('updatev') == 'deletebtn') {

                PatientArtbank::where('quarter', $request->quarter)
                    ->where('year', $request->year)
                    ->where('clinic_id', $request->clinic_id)
                    ->where('donor_id', $request->donor_id)
                    ->delete();

                return redirect()
                    ->route('clinic.list_artbank_patient_quarter_view_patient')
                    ->with('success', 'Record deleted successfully');
            }
            $dec_uhid = decrypt($request->enc_uhid);
            $userId = Session::get('id');
            $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTBANK')->first();
            $request->validate([
                'bank_reg_num'      => 'required|string',
                'name_of_bank'      => 'required|string',
                'donor_id'         => 'required|string|max:20',
                'gender_donor'     => 'required|in:Male,Female',
                'donor_age'        => 'nullable|required_if:gender_donor,Male|integer|min:21|max:55',
                'oocyte_age'       => 'nullable|required_if:gender_donor,Female|integer|min:23|max:35',
                'marital_status'   => 'required|in:Married,Single',
                'nationality'      => 'required|in:Indian,Foreigner',
                'other_nationality' => 'nullable|required_if:nationality,Foreigner|exists:apps_countries,id',
                'gamete_details'   => 'required|integer|min:0|max:99',
                'complicatoins_if_any' => 'nullable|string',
                'remark'           => 'nullable|string',
                'declaration'      => 'sometimes|required_if:gender_donor,Female|accepted',
                'declaration1'     => 'required_if:gender_donor,Male,Female|accepted',
            ], [
                'bank_reg_num.required' => 'Bank registration number is required.',
                'bank_reg_num.string' => 'Bank registration number must be valid.',

                'name_of_bank.required' => 'Please enter the name of the ART Bank.',
                'name_of_bank.string' => 'Bank name must be valid text.',

                'donor_id.required' => 'Please enter the donor ID.',
                'donor_id.string' => 'Donor ID must be valid.',
                'donor_id.max' => 'Donor ID must not exceed 20 characters.',

                'gender_donor.required' => 'Please select donor gender.',
                'gender_donor.in' => 'Invalid donor gender selected.',
                'declaration.required_if' => 'Please confirm the declaration required for female donor.',
                'declaration.accepted' => 'You must accept the declaration for female donor.',

                'declaration1.required_if' => 'Please confirm the declaration required for male donor.',
                'declaration1.accepted' => 'You must accept the declaration for male donor.',

                'donor_age.required_if' => 'Please enter donor age for male donor.',
                'donor_age.integer' => 'Donor age must be a valid number.',
                'donor_age.min' => 'Male donor age must be at least 21 years.',
                'donor_age.max' => 'Male donor age must not exceed 55 years.',

                'oocyte_age.required_if' => 'Please enter age of oocyte donor.',
                'oocyte_age.integer' => 'Oocyte donor age must be a valid number.',
                'oocyte_age.min' => 'Oocyte donor age must be at least 23 years.',
                'oocyte_age.max' => 'Oocyte donor age must not exceed 35 years.',

                'marital_status.required' => 'Please select marital status.',
                'marital_status.in' => 'Invalid marital status selected.',

                'nationality.required' => 'Please select nationality.',
                'nationality.in' => 'Nationality must be either Indian or Foreigner.',

                'other_nationality.required_if' => 'Please select country when nationality is Foreigner.',
                'other_nationality.exists' => 'Selected country is invalid.',

                'gamete_details.required' => 'Please enter number of gametes supplied.',
                'gamete_details.integer' => 'Gamete details must be a valid number.',
                'gamete_details.min' => 'Gamete details must be at least 0.',
                'gamete_details.max' => 'Gamete details must not exceed 99.',

                'complicatoins_if_any.string' => 'Complications must be valid text.',

                'remark.string' => 'Remark must be valid text.',

            ]);
            //dd($add_data);
            if (!$add_data) {
                return back()->with('error', 'ART Bank Registration data not found.');
            }

            // Security validation
            if (
                $request->bank_reg_num !== $add_data->registration_no ||
                $request->name_of_bank !== $add_data->name
            ) {
                return back()->withInput()->with('error', 'Invalid request: Data has been modified illegally!');
            }


            $patient_list = PatientArtbank::select('quarter', 'year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->orderBy('quarter', 'desc')
                ->get();

            $quarterDescriptions = [
                1 => 'April - June',
                2 => 'July - Sept',
                3 => 'Oct - Dec',
                4 => 'Jan - March',
            ];
            // Find existing patient ART record
            //$reportId = PatientArtclinic::findOrFail($request->id);

            // $reportId = $request->input('report_id');
            $p_id = $request->input('p_id');
            //  dd($reportId);
            $patient_add_data = PatientArtbank::find($p_id);
            // dd($reportId);
            //  dd($patient_add_data);
            if (!$patient_add_data) {
                return back()->with('error', 'Patient data not found for update.');
            }

            // Convert gender_child to string
            $formData = $request->except(['_token']);
            // $formData['gender_child'] = is_array($request->gender_child) ? implode(',', $request->gender_child) : $request->gender_child;

            // Update reporting table status
            // $report = PatientPeriodReportingTable::find($reportId);
            // if ($report) {
            //     $report->status = 'Live';
            //     $report->save();
            // }
            if ($formData['gender_donor'] == 'Male') {
                $formData['declaration'] = NULL;
            }
            // Add tracking IDs
            $formData['userid'] = $add_data->userid_applicant;
            $formData['clinic_id'] = $add_data->clinic_id;
            // $formData['reporting_id'] = $reportId;

            // Update patient clinic data
            $patient_add_data->fill($formData);

            // dd($patient_add_data);
            $patient_add_data->save();

            return redirect()->route('clinic.list_artbank_patient_quarter_view_patient', compact('patient_list', 'quarterDescriptions'))->with('message_update', 'Donor details updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // dd('test1');
            DB::rollBack(); // Rollback transaction on validation failure
            Log::error('ART Bank patient details form validation failed: ', [
                'errors' => $e->validator,
                'Clinic id'  => $add_data->clinic_id
            ]);

            return redirect()
                ->route('uhid.editPatientArtbank', ['uhid' => encrypt($dec_uhid)])
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            // dd('test2');
            DB::rollBack(); // Rollback on any other error
            Log::error('Error updating clinic record: ', [
                'errors' => $e->getMessage(),
                'Clinic_id'  => $add_data->clinic_id
            ]);

            return redirect()->route('uhid.editPatientArtbank', ['uhid' => encrypt($dec_uhid)])
                ->with('upd_error', 'An error occurred while updating. Please Contact support.')
                ->withInput();
        }
    }














    public function SummaryClinicConfig($clinic_type)
    {
        return match ($clinic_type) {
            'ARTCLINIC' => [
                'model' => SummaryPatientArtLevelOneClinic::class,
                'view_set_quarter' => 'summary.clinic.set_quarter_for_patient_summary',
                'view_live_quarter' => 'summary.clinic.live_quarter_for_patient_summary',
                'view_add_form' => 'summary.clinic.add_summary_patient_art_application_form',
                'view_summary' => 'summary.clinic.summary_view',
            ],

            'ARTBANK' => [
                'model' => SummaryPatientBankClinic::class,
                'view_set_quarter' => 'summary.bank.set_quarter_for_patient_summary',
                'view_live_quarter' => 'summary.bank.live_quarter_for_patient_summary',
                'view_add_form' => 'summary.bank.add_summary_patient_bank_application_form',
                'view_summary' => 'summary.bank.summary_view',
            ],

            'ARTSURROGACY' => [
                'model' => SummaryPatientSurrogacyClinic::class,
                'view_set_quarter' => 'summary.surrogacy.set_quarter_for_patient_summary',
                'view_live_quarter' => 'summary.surrogacy.live_quarter_for_patient_summary',
                'view_add_form' => 'summary.surrogacy.add_summary_patient_surrogacy_application_form',
                'view_summary' => 'summary.surrogacy.summary_view',
            ],



            default => abort(404, 'Invalid clinic type'),
        };
    }

    public function quarter_set_for_patient_summary($ct)
    {
        $clinic_type = strtoupper($ct);

        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');
        $quarter = QuarterTable::all();
        $currentYear = date('Y');


        $startingYear = 2022;
        $currentQuarter = ceil(date('n') / 3);

        $config = $this->SummaryClinicConfig($clinic_type);

        // dd($userId);
        $model  = $config['model'];

        $add = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', $clinic_type)
            ->firstOrFail();

        $level = $add->level ?? 1;
        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();

        if ($clinic_type === 'ARTCLINIC') {

            $model = match ($level) {
                'Level-1' => SummaryPatientArtLevelOneClinic::class,
                'Level-2' => SummaryPatientArtLevelTwoClinic::class,
                default   => abort(404, 'Invalid ART Clinic Level'),
            };
        } else {
            $config = $this->SummaryClinicConfig($clinic_type);
            $model  = $config['model'];
        }

        $latestRecord = $model::where('userid', $userId)
            ->where('clinic_id', $add->clinic_id)
            ->whereIn('status', ['Live', 'Finished'])
            ->orderByDesc('year')
            ->orderByDesc('quarter')
            ->first();
        // dd($latestRecord);
        $defaultQuarter = 1;
        $defaultYear = $startingYear;

        if (!$latestRecord) {
            // $estDate = $add->date_of_establishment ?? null;
            // try {
            //     $date = Carbon::createFromFormat('Y-m-d', $estDate);
            // } catch (\Exception $e) {
            //     Log::warning("Invalid establishment date format of the ART clinic", [
            //         'invalidDate' => $estDate,
            //         'Clinic ID' => $add->clinic_id,
            //         'singup ID' => $userId,
            //     ]);
            //     return view('layouts/clinic/invalid_establishment_date', [
            //         'invalidDate' => $estDate,
            //         'clinictype'  => "ART Clinic",
            //         'errorMessage' => 'Invalid establishment date format'
            //     ]);
            // }
            // $estDate  = $add->date_of_establishment;
            // $estYear  = date('Y', strtotime($estDate));
            // $estMonth = date('n', strtotime($estDate));

            // if ($estYear < $startingYear) {
            //     $defaultYear = $startingYear;
            //     $defaultQuarter = 1;
            // } else {
            //     $defaultYear = $estYear;

            //     if ($estMonth >= 1 && $estMonth <= 3) {
            //         $defaultQuarter = 1;
            //     } elseif ($estMonth >= 4 && $estMonth <= 6) {
            //         $defaultQuarter = 2;
            //     } elseif ($estMonth >= 7 && $estMonth <= 9) {
            //         $defaultQuarter = 3;
            //     } else {
            //         $defaultQuarter = 4;
            //     }
            // }

        } else {

            if ($latestRecord->status === 'Live') {
                $defaultQuarter = (int) $latestRecord->quarter;
                $defaultYear    = (int) $latestRecord->year;
            } elseif ($latestRecord->status === 'Finished') {

                $nextQuarter = $this->getNextQuarter($latestRecord->quarter);

                $defaultQuarter = $nextQuarter['quarter'];
                $defaultYear    = $latestRecord->year + $nextQuarter['year_add'];
            }
        }


        // if ($defaultYear > $currentYear) {
        //     $defaultYear = $currentYear-1;
        //     $defaultQuarter = $currentQuarter -1;

        // } elseif ($defaultYear == $currentYear && $defaultQuarter > $currentQuarter) {
        //     $defaultQuarter = $currentQuarter;
        // }
        // current  year 
        if ($defaultYear >= $currentYear) {

            if ($currentQuarter > 1) {
                $defaultYear    = $currentYear;
                $defaultQuarter = $currentQuarter - 1;
            } else {

                $defaultYear    = $currentYear - 1;
                $defaultQuarter = 4;
            }
        }

        $selected_quarter = QuarterTable::select('description')->where('quarter', $defaultQuarter)->first();

        $exists = $model::where('userid', $userId)
            ->where('clinic_id', $add->clinic_id)
            ->where('status', 'Live')
            ->exists();
        if ($exists) {
            $summary = $model::where('userid', $userId)
                ->where('clinic_id', $add->clinic_id)
                ->where('status', 'Live')
                ->first();

            $available_quarters = QuarterTable::where('quarter', $summary->quarter)->first();
            $available_years = $summary->year;
            // dd( $available_years);

            return view($config['view_live_quarter'], compact(
                'available_quarters',
                'available_years',
                'clinic_type',
                'level'
            ));
        }

        $quarter = QuarterTable::all();
        $currentYear = date('Y');
        return view($config['view_set_quarter'], compact(
            'clinic_type',
            'exists',
            'defaultQuarter',
            'defaultYear',
            'currentYear',
            'selected_quarter',
            'level'
        ));
    }

    public function quarter_set_for_patient_summary_submit(Request $request)
    {

        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }
        $data = $request->except(['_token', 'status']);
        $clinic_type = $data['clinic_type'];
        $userId = Session::get('id');
        $clinic = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('clinic_type', $clinic_type)
            ->where('status', 1)
            ->firstOrFail();


        $year = $data['year'] ?? null;
        $quarter = $data['quarter'] ?? null;
        $clinicId = $clinic->clinic_id;
        $level = $clinic->level;

        if ($clinic_type === 'ARTCLINIC') {
            if ($level === 'Level-1') {
                $model = SummaryPatientArtLevelOneClinic::class;
            } elseif ($level === 'Level-2') {
                $model = SummaryPatientArtLevelTwoClinic::class;
            } else {
                abort(500, 'Invalid ART Clinic Level');
            }
        } elseif ($clinic_type === 'ARTBANK') {
            $model = SummaryPatientBankClinic::class;
        } elseif ($clinic_type === 'ARTSURROGACY') {
            $model = SummaryPatientSurrogacyClinic::class;
        } else {
            abort(500, 'Invalid Clinic Type');
        }


        $alreadyExists = $model::where('clinic_id', $clinicId)
            ->where('year', $year)
            ->where('quarter', $quarter)
            ->where('status', 'Finished')
            ->exists();

        if ($alreadyExists) {

            return redirect()->back()->with(
                'error',
                'Summary for this Year & Quarter is already Filled.'
            );
        }



        $config = $this->SummaryClinicConfig($clinic_type);
        $model  = $config['model'];

        $available_quarters = QuarterTable::select('quarter', 'description')
            ->where('quarter', $data['quarter'])
            ->first();
        $available_years = $data['year'];
        //dd($available_years);
        return view($config['view_live_quarter'], compact('available_years', 'available_quarters', 'clinic_type'));
    }


    public function patient_summary_detail_form(Request $request, $ct)
    {
        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }

        $clinic_type = strtoupper($ct);
        $userId = Session::get('id');
        $data   = $request->except('_token');

        $selected_quarter = QuarterTable::where('quarter', $data['quarter'])->firstOrFail();
        $quarter_desc = $selected_quarter->description;

        $clinic = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('clinic_type', $clinic_type)
            ->where('status', 1)
            ->firstOrFail();

        $level = $clinic->level;


        if ($clinic_type === 'ARTCLINIC') {
            $model = match ($level) {
                'Level-1' => SummaryPatientArtLevelOneClinic::class,
                'Level-2' => SummaryPatientArtLevelTwoClinic::class,
                default   => abort(404, 'Invalid clinic level'),
            };

            $view = match ($level) {
                'Level-1' => 'summary.clinic.add_summary_patient_art_application_form',
                'Level-2' => 'summary.clinic.add_summary_patient_art_application_formtwo',
            };
        } else {
            $config = $this->SummaryClinicConfig($clinic_type);
            $model  = $config['model'];
            $view   = $config['view_add_form'];
        }


        if ($data['action'] === 'Continue Patient Summary') {

            $summary_exists = $model::where('userid', $userId)
                ->where('clinic_id', $clinic->clinic_id)
                ->where('quarter', $data['quarter'])
                ->where('year', $data['year'])
                ->where('status', 'Live')
                ->first();

            return view($view, compact(
                'data',
                'clinic',
                'summary_exists',
                'clinic_type',
                'quarter_desc',
                'level'
            ));
        }


        if ($data['action'] === 'Final Submit') {

            $clinicType = $clinic_type;
            $level      = $clinic->level;

            $updated = $model::where('userid', $userId)
                ->where('clinic_id', $clinic->clinic_id)
                ->where('quarter', $data['quarter'])
                ->where('year', $data['year'])
                ->where('status', 'Live')
                ->update([
                    'status'     => 'Finished',
                    'date_of_submission'    => now(),
                    'updated_at' => now(),
                    'date_of_submission' => now(),
                ]);


            if ($updated === 0) {
                return redirect()
                    ->route('clinic.quarter_set_for_patient_summary', [$clinic_type, $ct])
                    ->with('error', 'Final submit failed. Please complete all required data before submitting.');
            }

            $messageType = $updated ? 'success' : 'error';
            $messageText = $updated
                ? 'Summary final submitted successfully.'
                : 'Summary not found or already submitted.';


            if ($clinicType === 'ARTCLINIC' && $level === 'Level-2') {
                return redirect()->to('admin/list-artclinic-patient-view')
                    ->with($messageType, $messageText);
            }


            if ($clinicType === 'ARTCLINIC' && $level === 'Level-1') {
                return redirect()->to('admin/list-artclinicone-patient-view')
                    ->with($messageType, $messageText);
            }


            $config = [
                'ARTBANK' => 'admin/list-artbank-patient-view',
                'ARTSURROGACY' => 'admin/list-surrogacyclinic-patient-view',
            ];

            return redirect()->to($config[$clinicType])
                ->with($messageType, $messageText);
        }
    }

    public function patient_summary_detail_form_old(Request $request, $ct)
    {

        $clinic_type = strtoupper($ct);
        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }
        $config = $this->SummaryClinicConfig($clinic_type);
        $model  = $config['model'];
        $userId = Session::get('id');
        $data   = $request->except('_token');


        $selected_quarter = QuarterTable::select('description')->where('quarter', $data['quarter'])->first();


        $quarter_desc = $selected_quarter->description;

        $clinic = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('clinic_type', $clinic_type)
            ->where('status', 1)
            ->firstOrFail();



        if ($data['action'] === 'Continue Patient Summary') {

            $summary_exists = $model::where('userid', $userId)
                ->where('clinic_id', $clinic->clinic_id)
                ->where('quarter', $data['quarter'])
                ->where('year', $data['year'])
                ->where('status', 'Live')
                ->first();

            //dd($summary_exists);
            return view($config['view_add_form'], compact('data', 'clinic', 'summary_exists', 'clinic_type', 'quarter_desc'));
        }

        if ($data['action'] === 'Final Submit') {

            $updated = $model::where('userid', $userId)
                ->where('clinic_id', $clinic->clinic_id)
                ->where('quarter', $data['quarter'])
                ->where('year', $data['year'])
                ->where('status', 'Live')
                ->update([
                    'status' => 'Finished',
                    'updated_at' => now(),
                ]);

            return redirect()->route('clinic.clinicForm_list')
                ->with(
                    $updated ? 'success' : 'error',
                    $updated ? 'Summary final submitted successfully.' : 'Summary not found.'
                );
        }
    }



    public function patient_summary_detail_form_new(Request $request)
    {

        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId      = Session::get('id');
        $clinic_type = strtoupper($request->input('clinic_type', 'ARTCLINIC')); // default to ARTCLINIC


        $quarter = $request->input('quarter');
        $year    = $request->input('year');

        if (!$quarter || !$year) {
            return back()->with('error', 'Quarter and Year are required');
        }


        $clinic = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('clinic_type', $clinic_type)
            ->where('status', 1)
            ->firstOrFail();

        $level = $clinic->level;


        if ($clinic_type === 'ARTCLINIC') {
            $model = match ($level) {
                'Level-1' => SummaryPatientArtLevelOneClinic::class,
                'Level-2' => SummaryPatientArtLevelTwoClinic::class,
                default   => abort(404, 'Invalid clinic level'),
            };
        } else {
            $config = $this->SummaryClinicConfig($clinic_type);
            $model  = $config['model'];
        }


        if ($request->filled('summary_id')) {
            $summary = $model::where('id', $request->summary_id)
                ->where('userid', $userId)
                ->where('clinic_id', $clinic->clinic_id)
                ->firstOrFail();
            $summary->fill(
                $request->except('_token', 'summary_id', 'date_of_submission')
            );


            $summary->date_of_submission = now();
            $summary->save();

            return redirect()->route('clinic.quarter_set_for_patient_summary', ['clinic_type' => $clinic_type, 'summary_id'  => encrypt($summary->id)])->with('success', 'Summary updated successfully');
        }


        $summary = new $model();
        $summary->userid    = $userId;
        $summary->clinic_id = $clinic->clinic_id;
        $summary->quarter   = $quarter;
        $summary->year      = $year;
        $summary->status    = 'Live';
        $summary->date_of_submission = now();

        $summary->fill($request->except('_token', 'date_of_submission'));

        $summary->save();

        return redirect()->route('clinic.quarter_set_for_patient_summary', ['clinic_type' => $clinic_type, 'summary_id'  => encrypt($summary->id)])->with('success', 'Summary added Successfully');
    }




    public function summary_view($clinic_type, $summary_id)
    {
        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');
        $clinic_type_upper = strtoupper($clinic_type);


        if ($clinic_type_upper === 'ARTCLINIC') {
            $clinic = ClinicRegistrationModel::where('userid_applicant', $userId)
                ->where('clinic_type', $clinic_type_upper)
                ->where('status', 1)
                ->firstOrFail();

            $level = $clinic->level;
            $model = match ($level) {
                'Level-1' => SummaryPatientArtLevelOneClinic::class,
                'Level-2' => SummaryPatientArtLevelTwoClinic::class,
            };
            $view_summary = match ($level) {
                'Level-1' => 'summary.clinic.summary_view',
                'Level-2' => 'layouts.clinic.view_summary_patient_art_two_application_form',
            };
        } else {
            $config = $this->SummaryClinicConfig($clinic_type_upper);
            $model  = $config['model'];
            $view_summary = $config['view_summary'];
        }


        $summaryId = decrypt($summary_id);

        $summary = $model::where('id', $summaryId)
            ->where('userid', $userId)
            ->firstOrFail();

        return view($view_summary, compact('summary', 'clinic_type'));
    }


    public function destroy(Request $request)
    {
        $deleted = PatientArtclinic::where('quarter', $request->quarter)
            ->where('year', $request->year)
            ->where('clinic_id', $request->clinic_id)
            ->where('patient_uhid', $request->patient_uhid)
            ->delete();

        if ($deleted === 0) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Patient summary deleted successfully'
        ]);
    }


    // patient outcome code start

    public function list_artclinic_patient_view_outcome()
    {

        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        $clinic_id = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTCLINIC')
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
            ->table('patient_artclinic AS pa')
            ->join('patient_period_reporting_table AS pprt', 'pprt.id', '=', 'pa.reporting_id')
            ->where('pa.clinic_id', $clinic_id)
            ->where('pa.treat_outcomes', 'Pregnant')
            ->where('pprt.status', 'Finished')
            ->select(
                'pa.quarter',
                'pa.year',
                DB::raw('COUNT(DISTINCT pa.id) as patient_count')
            )
            ->groupBy('pa.quarter', 'pa.year')
            ->orderBy('pa.year', 'desc')
            ->orderBy('pa.quarter', 'desc');


        $patient_list = (clone $baseQuery)
            ->whereNull('pa.part2_referenceno')
            ->get();


        $baseQuery2 = DB::connection('patient_clinic_database')
            ->table('patient_artclinic AS pa')
            ->join('patient_period_part2_reporting_table as p2', function ($join) {
                $join->on(
                    DB::raw('p2.ref_no COLLATE utf8mb4_general_ci'),
                    '=',
                    DB::raw('pa.part2_referenceno COLLATE utf8mb4_general_ci')
                );
            })
            ->select(
                'pa.quarter',
                'pa.year',
                DB::raw('COUNT(DISTINCT pa.id) as patient_count')
            )
            ->where('pa.clinic_id', $clinic_id)
            ->where('pa.treat_outcomes', 'Pregnant')
            ->groupBy('pa.quarter', 'pa.year');
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

        return view('layouts.clinic.list_artclinic_patient_view_outcome', compact('quarterDescriptions', 'patient_list', 'quarter_list', 'patient_list_draft', 'ref_no', 'pendingCount', 'patient_list_complte', 'daysRemaining'));
    }


    public function showUHIDs_artclinic_outcome($encrypted)
    {
        $userId = Session::get('id');
        $type = request()->type;
        $clinic_id = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTCLINIC')
            ->value('clinic_id');
        $decrypted = Crypt::decrypt($encrypted);
        [$quarter, $year] = explode('|', $decrypted);
        $query = PatientArtclinic::select(
            'patient_artclinic.patient_uhid',
            'patient_artclinic.part2_reportingid',
            'patient_period_part2_reporting_table.status'
        )
            ->join('patient_period_part2_reporting_table', function ($join) {
                $join->on(
                    DB::raw('patient_period_part2_reporting_table.ref_no COLLATE utf8mb4_general_ci'),
                    '=',
                    DB::raw('patient_artclinic.part2_referenceno COLLATE utf8mb4_general_ci')
                );
            })
            ->where('patient_period_part2_reporting_table.clinic_id', $clinic_id)
            ->where('patient_artclinic.quarter', $quarter)
            ->where('patient_artclinic.year', $year)
            ->distinct();

        // if($type == 'due'){
        // $query->where('patient_period_part2_reporting_table.status', 'Live');

        // }

        if ($type == 'draft') {
            $query->where('patient_period_part2_reporting_table.status', 'Live')
                ->where('patient_period_part2_reporting_table.partial_status', 0);
        }

        $data = $query->get();


        // dd($data);      
        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();


        return view('layouts.clinic.list_artclinic_patient_outcome_view_patient_uhid', compact('quarter', 'year', 'data', 'quarterDescriptions', 'type'));
    }

    public function editPatientArtclinicOutcome(Request $request, $uhid = NULL)
    {

        $userId = Session::get('id');
        $countries = countrytable::all();
        $decryptedUhid = Crypt::decrypt($uhid);
        $add = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTCLINIC')->first();
        $uhidDetails = PatientArtclinic::where('patient_uhid', $decryptedUhid)->where('clinic_id', $add->clinic_id)->first(); // Fetch the UHID data



        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();
        $available_quarters = PatientPeriodReportingTable::where('status', 'Finished')
            ->where('userid', $userId)
            ->where('clinic_id', $add->clinic_id)
            ->where('quarter', $uhidDetails->quarter)
            ->select('quarter')
            ->first();
        //dd($available_quarters);

        if ($available_quarters) {
            $available_quarters->description = $quarterDescriptions[$available_quarters->quarter];
        }
        $available_years = PatientPeriodReportingTable::where('status', 'Finished')->where('userid', $userId)->where('clinic_id', $add->clinic_id)
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->get();

        $clinic_id = $add->clinic_id;
        return view('layouts.clinic.edit_patient_clinic_application_form_outcome', compact('uhidDetails', 'available_quarters', 'available_years', 'countries', 'clinic_id'));
    }

    public function patientartparttwoapplicationformSubmitpatient(Request $request)
    {


        try {
            if (!Session::has('id')) {
                return redirect()->route('clinic.loginclinicform');
            }

            if ($request->input('updatev') == 'deletebtn') {

                PatientArtclinic::where('quarter', $request->quarter)
                    ->where('year', $request->year)
                    ->where('clinic_id', $request->clinic_id)
                    ->where('patient_uhid', $request->patient_uhid)
                    ->delete();

                return redirect()
                    ->route('clinic.list_artclinic_patient_quarter_view_patient')
                    ->with('success', 'Record deleted successfully');
            }

            $dec_uhid = decrypt($request->enc_uhid);
            $userId = Session::get('id');
            $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTCLINIC')->first();

            $request->validate([
                'preganancy_outcome' => 'required|string',

                'male_number' => 'required_if:preganancy_outcome,live birth,Stillbirth|nullable|integer|min:0',
                'female_number' => 'required_if:preganancy_outcome,live birth,Stillbirth|nullable|integer|min:0',
            ]);

            if (!$add_data) {
                return back()->with('error', 'ART Clinic Registration data not found.');
            }


            $patient_list = PatientArtclinic::select('quarter', 'year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->orderBy('quarter', 'desc')
                ->get();



            $quarterDescriptions = [
                1 => 'April - June',
                2 => 'July - Sept',
                3 => 'Oct - Dec',
                4 => 'Jan - March',
            ];

            $p_Id = $request->input('p_id');
            $patient_add_data = PatientArtclinic::find($p_Id);

            if (!$patient_add_data) {
                return back()->with('error', 'Patient data not found for update.');
            }
            $action = $request->input('updatev');

            $formData = $request->input();
            $preganancy_outcome = $request->input('preganancy_outcome');
            $male_number = $request->input('male_number');
            $female_number = $request->input('female_number');
            $l_birth = $request->input('l_birth');

            if ($action == 'draft') {


                $formData['preganancy_outcome'] = $preganancy_outcome;
                $formData['male_number'] = $male_number;
                $formData['female_number'] = $female_number;
                $formData['l_birth'] = $l_birth;
                $formData['part2_submissiondate'] = now();
            }

            if ($request->preganancy_outcome === 'Therapeutic abortion' || $request->preganancy_outcome === 'Spontaneous abortion' || $request->preganancy_outcome === 'Elective Termination') {

                $formData['male_number'] = null;
                $formData['female_number'] = null;
            }
            if ($request->preganancy_outcome === 'Stillbirth') {

                $formData['l_birth'] = null;
            }

            $formData['userid'] = $add_data->userid_applicant;
            $formData['clinic_id'] = $add_data->clinic_id;
            $patient_add_data->fill($formData);
            $patient_add_data->save();

            return redirect()->route('clinic.list_artclinic_patient_view_outcome', compact('patient_list', 'quarterDescriptions'))->with('success', 'Patient details updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('ART patient details form validation failed: ', [
                'errors' => $e->validator,
                'Clinic_id'  => $add_data->clinic_id
            ]);
            return redirect()->route('uhid.editPatientArtclinicOutcome', ['uhid' => encrypt($dec_uhid)])
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('Error updating clinic record: ', [
                'errors' => $e->getMessage(),
                //'Clinic_id'  => $add_data->clinic_id
            ]);

            return redirect()->route('uhid.editPatientArtclinicOutcome', ['uhid' => encrypt($dec_uhid)])
                ->with('upd_error', 'An error occurred while updating. Please Contact support.')
                ->withInput();
        }
    }



    public function patient_part2_detail_form(Request $request)
    {
        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');
        $data   = $request->all();


        $clinic = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTCLINIC')->first();


        if (isset($data['action']) && $data['action'] === 'Start Filling Patient Output') {

            $exists = DB::connection('patient_clinic_database')
                ->table('patient_period_part2_reporting_table')
                ->where('clinic_id', $clinic->clinic_id)
                ->where('status', 'Live')
                ->first();

            if ($exists) {
                return redirect()
                    ->route('clinic.part2_for_patient_outcome')
                    ->with('success', 'Part B already started. Ref No: ' . $exists->ref_no);
            }


            $lastId = DB::connection('patient_clinic_database')
                ->table('patient_period_part2_reporting_table')
                ->insertGetId([
                    'clinic_id'           => $clinic->clinic_id,
                    'userid'              => $userId,
                    'type_clinic'         => 'ARTCLINIC',
                    'status'              => 'Live',
                    'initial_submit_date' => now(),
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ]);


            $refNo = now()->format('YmdHis') . $lastId;


            $updated = DB::connection('patient_clinic_database')
                ->table('patient_period_part2_reporting_table')
                ->where('id', $lastId)
                ->update([
                    'ref_no' => $refNo,
                ]);


            return redirect()
                ->route('clinic.part2_for_patient_outcome')
                ->with('success', 'Part B initiated successfully. Ref No: ' . $refNo);
        }

        if (isset($data['action']) && $data['action'] === 'Final Submit') {


            $refNo = $data['ref_no'] ?? null;

            if (!$refNo) {
                return back()->with('error', 'Reference number missing.');
            }

            $exists = DB::connection('patient_clinic_database')
                ->table('patient_period_part2_reporting_table')
                ->where('clinic_id', $clinic->clinic_id)
                ->where('ref_no', $refNo)
                ->where('status', 'Live')
                ->first();

            if (!$exists) {
                return back()->with('error', 'No active record found for final submission.');
            }

            DB::connection('patient_clinic_database')
                ->table('patient_period_part2_reporting_table')
                ->where('clinic_id', $clinic->clinic_id)
                ->where('ref_no', $refNo)
                ->update([
                    'status'            => 'Finished',
                    'updated_at'        => now(),
                    'ip_address'        => $request->ip(),
                    'final_submit_date' => now(),
                ]);

            return redirect()
                ->route('clinic.list_artclinic_patient_view_outcome')
                ->with('success', 'Part B submitted successfully. Ref No: ' . $refNo);
        }

        return back()->with('error', 'Invalid action.');
    }


    public function part2_for_patient_outcome()
    {
        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');
        $clinic = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTCLINIC')
            ->first();


        $drafted = DB::connection('patient_clinic_database')
            ->table('patient_period_part2_reporting_table')
            ->where('clinic_id', $clinic->clinic_id)
            ->where('status', 'Live')
            ->count();


        if ($drafted >= 25) {
            return redirect()
                ->route('clinic.list_artclinic_patient_view_outcome')
                ->with('error', 'You have reached 25 draft limit. Please submit existing drafts first.');
        }

        return view('layouts.clinic.part2_for_patient_outcome', compact('drafted'));
    }


    public function searchUhidform(Request $request)
    {
        if (!Session::has('id')) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $userId = Session::get('id');

        $clinic = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTCLINIC')
            ->first();

        if (!$clinic) {
            return response()->json([
                'status' => false,
                'message' => 'Clinic not found'
            ]);
        }

        $uhid = $request->uhid;


        // $patients = DB::connection('patient_clinic_database')
        //     ->table('patient_artclinic')
        //     ->where('patient_uhid', $uhid)
        //     ->where('clinic_id', $clinic->clinic_id)
        //     ->where('treat_outcomes', 'Pregnant')
        //     ->orderByDesc('year')
        //     ->orderByDesc('quarter')
        //     ->get();

        $patients = DB::connection('patient_clinic_database')
            ->table('patient_artclinic as pac')
            ->join('quarter_table as qt', 'qt.id', '=', 'pac.quarter')
             ->leftJoin(
        'art_dbnew_testing.apps_countries  as husband_country',
        'husband_country.id',
        '=',
        'pac.other_nationality'
    )

    ->leftJoin(
        'art_dbnew_testing.apps_countries as wife_country',
        'wife_country.id',
        '=',
        'pac.other_nationality_wife'
    )
            ->where('pac.patient_uhid', $uhid)
            ->where('pac.clinic_id', $clinic->clinic_id)
            ->where('pac.treat_outcomes', 'Pregnant')
            ->orderByDesc('pac.year')
            ->orderByDesc('pac.quarter')
            ->select(
                'pac.*',
                'qt.description as quarter_description',
                  'husband_country.country_name as other_nationality',
        'wife_country.country_name as other_nationality_wife'
            )
            ->get();

        if ($patients->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Patient not found or not Pregnant'
            ]);
        }

        return response()->json([
            'status' => true,
            'count'  => $patients->count(),
            'data'   => $patients
        ]);
    }

    public function searchUhid(Request $request)


    {
        if (!Session::has('id')) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $userId = Session::get('id');

        $clinic = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTCLINIC')
            ->first();

        if (!$clinic) {
            return response()->json([
                'status' => false,
                'message' => 'Clinic not found'
            ]);
        }
        $search  = $request->search;

        // $patients = PatientArtclinic::where('clinic_id', $clinic->clinic_id)
        // ->where('treat_outcomes', 'Pregnant')
        // ->whereNull('part2_referenceno')
        // ->when($search, function ($q) use ($search) {
        //         $q->where('patient_uhid', 'LIKE', "%{$search}%");
        //     })
        // ->orderByDesc('year')
        // ->orderByDesc('quarter')
        // ->limit(5)
        // ->get();

        $patients = DB::connection('patient_clinic_database')
            ->table('patient_artclinic as pa')
            ->join('patient_period_reporting_table as pprt', function ($join) {
                $join->on('pprt.id', '=', 'pa.reporting_id');
            })
            ->where('pa.clinic_id', $clinic->clinic_id)
            ->where('pa.treat_outcomes', 'Pregnant')
            ->where('pprt.status', 'Finished')
            ->whereNull('pa.part2_referenceno')
            ->when($search, function ($q) use ($search) {
                $q->where('pa.patient_uhid', 'LIKE', "%{$search}%");
            })
            ->orderByDesc('pa.year')
            ->orderByDesc('pa.quarter')
            ->limit(5)
            ->get();
        $results = [];

        foreach ($patients as $patient) {
            $results[] = [
                'id' => $patient->patient_uhid,
                'text' => $patient->patient_uhid,
            ];
        }

        return response()->json($results);
    }



    public function patientartparttwoapplicationformSubmitpatientnew(Request $request)
    {
       // dd($request->all());

          $validated = $request->validate([
    'preganancy_outcome' => 'required|string',

    'male_number' => 'required_if:preganancy_outcome,live birth,Stillbirth|nullable|integer|min:0',
    'female_number' => 'required_if:preganancy_outcome,live birth,Stillbirth|nullable|integer|min:0',

   
    
    

], [
    'preganancy_outcome.required' => 'Please select pregnancy outcome.',

   
]);

        try {

            if (!Session::has('id')) {
                return redirect()->route('clinic.loginclinicform');
            }

            DB::beginTransaction();

            $userId = Session::get('id');


            $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)
                ->where('status', 1)
                ->where('clinic_type', 'ARTCLINIC')
                ->first();

            if (!$add_data) {
                return back()->with('upd_error', 'Clinic data not found')->withInput();
            }
            $p_Id = $request->input('p_id');


            $patient = PatientArtclinic::find($p_Id);

            if (!$patient) {
                return back()->with('upd_error', 'Patient not found')->withInput();
            }


            $p2 = DB::connection('patient_clinic_database')
                ->table('patient_period_part2_reporting_table')
                ->where('clinic_id', $add_data->clinic_id)
                ->where('status', 'Live')
                ->first();


                    $data = [
                    'preganancy_outcome' => $validated['preganancy_outcome'],
                    'male_number'        => $validated['male_number'] ?? null,
                    'female_number'      => $validated['female_number'] ?? null,
                    'l_birth'            => $validated['l_birth'] ?? null,
                    'userid'             => $add_data->userid_applicant,
                    'clinic_id'          => $add_data->clinic_id,
                    'aadhar_no_sw' =>$validated['aadhar_no_sw'],
                    'aadhar_no_semen' => $validated['aadhar_no_semen'],
                    'self_oocyte' =>$request->self_oocyte,
                    'donor_oocyte' =>$request->donor_oocyte,
                    'no_of_oocytes_used_retrived' =>$request->no_of_oocytes_used_retrived,
                    'no_of_oocyted_used_for_embryo_creation' =>$request->no_of_oocyted_used_for_embryo_creation,
                    'no_of_oocyte_discarded' =>$request->no_of_oocyte_discarded,
                    'no_of_frozen_oocyte' =>$request->no_of_frozen_oocyte,
                    'aadhar_no_hus' =>$validated['aadhar_no_hus'],
                    'aadhar_no_wife' => $validated['aadhar_no_wife'],
                    'aadhar_no_oocyte' => $validated['aadhar_no_oocyte'],
                    'husband_semen' =>$request->husband_semen,
                    'no_of_semen_vials_discarded' =>$request->no_of_semen_vials_discarded,
                    'no_of_semen_vials_frozen' =>$request->no_of_semen_vials_frozen,
                    'no_of_embryos_transferred' =>$request->no_of_embryos_transferred,
                    'no_of_embryos_discarded' =>$request->no_of_embryos_discarded,
                    'no_of_frozen_embryos'=> $request->no_of_frozen_embryos,
                    'iui'=> $request->iui,
                    'ivf_et'=> $request->ivf_et,
                    'icsi_et'=> $request->icsi_et,

                    ];


            if ($request->updatev == 'Continue') {

                if ($p2) {
                    $data['part2_referenceno'] = $p2->ref_no;
                    $data['part2_reportingid'] = $p2->id;
                }

                $data['part2_submissiondate'] = now();
            }


            $patient->update($data);

            DB::commit();

            return redirect()->route('clinic.part2_for_patient_outcome')
                ->with('success', 'Patient details saved successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Error updating patient ART Clinic Part 2 data', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return redirect()->route('clinic.part2_for_patient_outcome')
                ->with('upd_error', 'Somthing went wrong. Kindly contact support');
        }
    }

    // part 2 function for surrogacy outcomes

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
            ->where('ps.tratment_Outcome', 'Pregnant')
            ->orwhere('ps.art_treat_outcomes', 'Pregnant')
            ->whereNotNull('ps.treatment_type')
            ->where('pprt.status', 'Finished')
            ->select(
                'ps.quarter',
                'ps.year',
                DB::raw('COUNT(DISTINCT ps.id) as patient_count')
            )
            ->groupBy('ps.quarter', 'ps.year')
            ->orderBy('ps.year', 'desc')
            ->orderBy('ps.quarter', 'desc');


        $patient_list = (clone $baseQuery)
            ->whereNull('ps.part2_referenceno')
            ->get();


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
            ->where('ps.tratment_Outcome', 'Pregnant')

            ->groupBy('ps.quarter', 'ps.year');

        $patient_list_draft = (clone $baseQuery2)
            ->where('p2.status', 'Live')
            ->orwhere('ps.art_treat_outcomes', 'Pregnant')
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
    public function part2_for_patientsurrogacy_outcome()
    {

        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');
        $clinic = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTSURROGACY')
            ->first();


        $drafted = DB::connection('patient_clinic_database')
            ->table('patient_period_part2_reporting_table')
            ->where('clinic_id', $clinic->clinic_id)
            ->where('status', 'Live')
            ->count();

        $uhidDetails = PatientSurrogacyClinic::where('clinic_id', $clinic->clinic_id)->first();

        if ($drafted >= 25) {
            return redirect()
                ->route('clinic.list_artclinic_patient_view_outcome')
                ->with('error', 'You have reached 25 draft limit. Please submit existing drafts first.');
        }

        return view('layouts.clinic.part2_for_patientsurrogacy_outcome', compact('drafted', 'uhidDetails'));
    }
    public function patientartparttwoapplicationformSubmitpatientSurrogacynew(Request $request)
    {

        $validated = $request->validate([


            'preganancy_outcome' => 'required|string',

            'male_number' => 'required_if:preganancy_outcome,live birth,Stillbirth|nullable|integer|min:0',
            'female_number' => 'required_if:preganancy_outcome,live birth,Stillbirth|nullable|integer|min:0',

        ], [
            'preganancy_outcome.required' => 'Please select pregnancy outcome',
        ]);

        try {

            if (!Session::has('id')) {
                return redirect()->route('clinic.loginclinicform');
            }

            DB::beginTransaction();

            $userId = Session::get('id');

            $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)
                ->where('status', 1)
                ->where('clinic_type', 'ARTSURROGACY')
                ->first();

            if (!$add_data) {
                return back()->with('upd_error', 'Clinic data not found')->withInput();
            }
            $p_Id = $request->input('p_id');

            $patient = PatientSurrogacyClinic::find($p_Id);

            if (!$patient) {
                return back()->with('upd_error', 'Patient not found')->withInput();
            }


            $p2 = DB::connection('patient_clinic_database')
                ->table('patient_period_part2_reporting_table')
                ->where('clinic_id', $add_data->clinic_id)
                ->where('status', 'Live')
                ->first();


            $data = [
                'preganancy_outcome' => $validated['preganancy_outcome'],
                'male_number'        => $request->male_number,
                'female_number'      => $request->female_number,
                'l_birth'            => $request->l_birth,
                'userid'             => $add_data->userid_applicant,
                'clinic_id'          => $add_data->clinic_id,
            ];

            if ($request->updatev == 'Continue') {

                if ($p2) {
                    $data['part2_referenceno'] = $p2->ref_no;
                    $data['part2_reportingid'] = $p2->id;
                }

                $data['part2_submissiondate'] = now();
            }


            $patient->update($data);

            DB::commit();

            return redirect()->route('clinic.part2_for_patientsurrogacy_outcome')
                ->with('success', 'Data updated successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with('upd_error', $e->getMessage())
                ->withInput();
        }
    }
    public function showUHIDs_artsurrogacy_outcome($encrypted)
    {
        $userId = Session::get('id');
        $type = request()->type;
        $clinic_id = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTSURROGACY')
            ->value('clinic_id');
        $decrypted = Crypt::decrypt($encrypted);
        [$quarter, $year] = explode('|', $decrypted);
        $query = PatientSurrogacyClinic::select(
            'patient_surrogacyclinic.id',
            'patient_surrogacyclinic.pati_uhid',
            'patient_surrogacyclinic.part2_reportingid',
            'patient_period_part2_reporting_table.status',
            'patient_surrogacyclinic.treatment_type',
            'patient_surrogacyclinic.art_types_of_treat',
            'patient_surrogacyclinic.art_treat_outcomes',
            'patient_surrogacyclinic.types_of_treat',
            'patient_surrogacyclinic.tratment_Outcome'
        )
            ->join('patient_period_part2_reporting_table', function ($join) {
                $join->on(
                    DB::raw('patient_period_part2_reporting_table.ref_no COLLATE utf8mb4_general_ci'),
                    '=',
                    DB::raw('patient_surrogacyclinic.part2_referenceno COLLATE utf8mb4_general_ci')
                );
            })



            ->where('patient_period_part2_reporting_table.clinic_id', $clinic_id)
            ->where('patient_surrogacyclinic.quarter', $quarter)
            ->where('patient_surrogacyclinic.year', $year)
            ->distinct();

        if ($type == 'draft') {
            $query->where('patient_period_part2_reporting_table.status', 'Live')
                ->where('patient_period_part2_reporting_table.partial_status', 0);
        }

        $data = $query->get();


        //dd($data);      
        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();


        return view('layouts.clinic.list_surrogacy_patient_outcome_view_patient_uhid', compact('quarter', 'year', 'data', 'quarterDescriptions', 'type'));
    }
    public function editPatientSurrogacyOutcome(Request $request, $id = NULL)
    {


        $userId = Session::get('id');
        $countries = countrytable::all();
        $decryptedUhid = Crypt::decrypt($id);
        // dd($decryptedUhid);
        $add = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTSURROGACY')->first();
        $uhidDetails = PatientSurrogacyClinic::where('id', $decryptedUhid)->where('clinic_id', $add->clinic_id)->first(); // Fetch the UHID data



        $quarterDescriptions = QuarterTable::pluck('description', 'quarter')->toArray();
        $available_quarters = PatientPeriodReportingTable::where('status', 'Finished')
            ->where('userid', $userId)
            ->where('clinic_id', $add->clinic_id)
            ->where('quarter', $uhidDetails->quarter)
            ->select('quarter')
            ->first();
        //dd($available_quarters);

        if ($available_quarters) {
            $available_quarters->description = $quarterDescriptions[$available_quarters->quarter];
        }
        $available_years = PatientPeriodReportingTable::where('status', 'Finished')->where('userid', $userId)->where('clinic_id', $add->clinic_id)
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->get();

        $clinic_id = $add->clinic_id;
        return view('layouts.clinic.edit_patient_surrogacyoutcome_application_form', compact('uhidDetails', 'available_quarters', 'available_years', 'countries', 'clinic_id'));
    }
    public function patientartparttwoapplicationformSubmitpatientsurrogacyoutcome(Request $request)
    {


        try {
            if (!Session::has('id')) {
                return redirect()->route('clinic.loginclinicform');
            }



            $dec_uhid = decrypt($request->enc_uhid);

            $userId = Session::get('id');
            $add_data = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTSURROGACY')->first();

            $request->validate([
                'preganancy_outcome' => 'required|string',

                'male_number' => 'required_if:preganancy_outcome,live birth,Stillbirth|nullable|integer|min:0',
                'female_number' => 'required_if:preganancy_outcome,live birth,Stillbirth|nullable|integer|min:0',
            ]);

            if (!$add_data) {
                return back()->with('error', 'ART Clinic Registration data not found.');
            }


            $patient_list = PatientSurrogacyClinic::select('quarter', 'year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->orderBy('quarter', 'desc')
                ->get();



            $quarterDescriptions = [
                1 => 'April - June',
                2 => 'July - Sept',
                3 => 'Oct - Dec',
                4 => 'Jan - March',
            ];

            $p_Id = $request->input('p_id');
            $patient_add_data = PatientSurrogacyClinic::find($p_Id);

            if (!$patient_add_data) {
                return back()->with('error', 'Patient data not found for update.');
            }
            $action = $request->input('updatev');

            $formData = $request->input();
            $preganancy_outcome = $request->input('preganancy_outcome');
            $male_number = $request->input('male_number');
            $female_number = $request->input('female_number');
            $l_birth = $request->input('l_birth');

            if ($action == 'draft') {


                $formData['preganancy_outcome'] = $preganancy_outcome;
                $formData['male_number'] = $male_number;
                $formData['female_number'] = $female_number;
                $formData['l_birth'] = $l_birth;
                $formData['part2_submissiondate'] = now();
            }

            if ($request->preganancy_outcome === 'Therapeutic abortion' || $request->preganancy_outcome === 'Spontaneous abortion' || $request->preganancy_outcome === 'Elective Termination') {

                $formData['male_number'] = null;
                $formData['female_number'] = null;
            }
            if ($request->preganancy_outcome === 'Stillbirth') {

                $formData['l_birth'] = null;
            }

            $formData['userid'] = $add_data->userid_applicant;
            $formData['clinic_id'] = $add_data->clinic_id;
            $patient_add_data->fill($formData);
            $patient_add_data->save();

            return redirect()->route('clinic.list_surrogacy_patient_outcome_view', compact('patient_list', 'quarterDescriptions'))->with('success', 'Patient details updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('ART patient details form validation failed: ', [
                'errors' => $e->validator,
                'Clinic_id'  => $add_data->clinic_id
            ]);
            return redirect()->route('uhid.editPatientSurrogacyOutcome', ['uhid' => encrypt($dec_uhid)])
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('Error updating clinic record: ', [
                'errors' => $e->getMessage(),
                //'Clinic_id'  => $add_data->clinic_id
            ]);

            return redirect()->route('uhid.editPatientSurrogacyOutcome', ['uhid' => encrypt($dec_uhid)])
                ->with('upd_error', 'An error occurred while updating. Please Contact support.')
                ->withInput();
        }
    }
    public function patientsurrogacy_part2_detail_form(Request $request)
    {

        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');
        $data   = $request->all();


        $clinic = ClinicRegistrationModel::where('userid_applicant', $userId)->where('status', 1)->where('clinic_type', 'ARTSURROGACY')->first();


        if (isset($data['action']) && $data['action'] === 'Start Filling Patient Output') {

            $exists = DB::connection('patient_clinic_database')
                ->table('patient_period_part2_reporting_table')
                ->where('clinic_id', $clinic->clinic_id)
                ->where('status', 'Live')
                ->first();

            if ($exists) {
                return redirect()
                    ->route('clinic.part2_for_patientsurrogacy_outcome')
                    ->with('success', 'Part B already started. Ref No: ' . $exists->ref_no);
            }


            $lastId = DB::connection('patient_clinic_database')
                ->table('patient_period_part2_reporting_table')
                ->insertGetId([
                    'clinic_id'           => $clinic->clinic_id,
                    'userid'              => $userId,
                    'type_clinic'         => 'ARTSURROGACY',
                    'status'              => 'Live',
                    'initial_submit_date' => now(),
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ]);


            $refNo = now()->format('YmdHis') . $lastId;


            DB::connection('patient_clinic_database')
                ->table('patient_period_part2_reporting_table')
                ->where('id', $lastId)
                ->update([
                    'ref_no' => $refNo,
                ]);

            return redirect()
                ->route('clinic.part2_for_patientsurrogacy_outcome')
                ->with('success', 'Part B initiated successfully. Ref No: ' . $refNo);
        }

        if (isset($data['action']) && $data['action'] === 'Final Submit') {



            $refNo = $data['ref_no'] ?? null;

            if (!$refNo) {
                return back()->with('error', 'Reference number missing.');
            }

            $exists = DB::connection('patient_clinic_database')
                ->table('patient_period_part2_reporting_table')
                ->where('clinic_id', $clinic->clinic_id)
                ->where('ref_no', $refNo)
                ->where('status', 'Live')
                ->first();

            if (!$exists) {
                return back()->with('error', 'No active record found for final submission.');
            }

            DB::connection('patient_clinic_database')
                ->table('patient_period_part2_reporting_table')
                ->where('clinic_id', $clinic->clinic_id)
                ->where('ref_no', $refNo)
                ->update([
                    'status'            => 'Finished',
                    'updated_at'        => now(),
                    'ip_address'        => $request->ip(),
                    'final_submit_date' => now(),
                ]);

            return redirect()
                ->route('clinic.list_surrogacy_patient_outcome_view')
                ->with('success', 'Part B submitted successfully. Ref No: ' . $refNo);
        }

        return back()->with('error', 'Invalid action.');
    }
    public function searchUhidsurrogacy(Request $request)
    {
        if (!Session::has('id')) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $userId = Session::get('id');

        $clinic = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTSURROGACY')
            ->first();

        if (!$clinic) {
            return response()->json([
                'status' => false,
                'message' => 'Clinic not found'
            ]);
        }
        $search  = $request->search;



        $patients = DB::connection('patient_clinic_database')
            ->table('patient_surrogacyclinic as ps')
            ->join('patient_period_reporting_table as pprt', function ($join) {
                $join->on('pprt.id', '=', 'ps.reporting_id');
            })
            ->where('ps.clinic_id', $clinic->clinic_id)
            ->whereNotNull('ps.treatment_type')
            ->where(function ($q) {
                $q->where('ps.tratment_Outcome', 'Pregnant')
                    ->orWhere('ps.art_treat_outcomes', 'Pregnant');
            })
            ->where('pprt.status', 'Finished')
            ->whereNull('ps.part2_referenceno')
            ->when($search, function ($q) use ($search) {
                $q->where('ps.pati_uhid', 'LIKE', "%{$search}%");
            })
            ->orderByDesc('ps.year')
            ->orderByDesc('ps.quarter')
            ->limit(5)
            ->get();
        //sdd($patients);
        $results = [];

        foreach ($patients as $patient) {
            $results[] = [
                'id' => $patient->pati_uhid,
                'text' => $patient->pati_uhid,
            ];
        }

        return response()->json($results);
    }
    public function searchUhidSurrogacyform(Request $request)
    {
        if (!Session::has('id')) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $userId = Session::get('id');

        $clinic = ClinicRegistrationModel::where('userid_applicant', $userId)
            ->where('status', 1)
            ->where('clinic_type', 'ARTSURROGACY')
            ->first();

        if (!$clinic) {
            return response()->json([
                'status' => false,
                'message' => 'Clinic not found'
            ]);
        }

        $uhid = $request->uhid;


        //  $patients = DB::connection('patient_clinic_database')
        //     ->table('patient_surrogacyclinic')
        //     ->where('pati_uhid', $uhid)
        //     ->where('clinic_id', $clinic->clinic_id)
        //     ->where(function ($q) {
        //         $q->where('tratment_Outcome', 'Pregnant')
        //           ->orWhere('art_treat_outcomes', 'Pregnant');
        //     })
        //     ->orderByDesc('year')
        //     ->orderByDesc('quarter')
        //     ->get();
        $patients = DB::connection('patient_clinic_database')
            ->table('patient_surrogacyclinic as p')


            ->leftJoin('quarter_table as q', 'q.id', '=', 'p.quarter')
            ->leftJoin('patient_period_reporting_table as pr', 'pr.id', '=', 'p.reporting_id')
             ->where('p.pati_uhid', $uhid)
            ->where('p.clinic_id', $clinic->clinic_id)

            ->where('pr.status', 'Finished')
            ->where(function ($query) {
                $query->where('p.tratment_Outcome', 'Pregnant')
                    ->orWhere('p.art_treat_outcomes', 'Pregnant');
            })
           ->orderByDesc('p.quarter')

 
            ->select(
                'p.*',
                'q.description as quarter_name',
                 'pr.id as reporting_id',

                'pr.year as reporting_year',
                'pr.status as reporting_status'
            )

            ->get();

        //sdd($patients);      
        if ($patients->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Patient not found or not Pregnant'
            ]);
        }

        return response()->json([
            'status' => true,
            'count'  => $patients->count(),
            'data'   => $patients
        ]);
    }
    // unlock Patient Report
    public function unlockPatientReport()
    {

        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }
        $userId = Session::get('id');

        $clinics = ClinicRegistrationModel::select('clinic_id', 'clinic_type')->where('userid_applicant', $userId)->where('status', 1)->orderByRaw("FIELD(clinic_type, 'ARTCLINIC', 'ARTSURROGACY', 'ARTBANK')")->get();

        return view('layouts.clinic.unlockPatient.unlock_patient_period', compact('clinics'));
    }

    public function ajaxUnlockPatientReport(Request $request)
    {
        $userId = Session::get('id');
        $clinic_id = Crypt::decryptString($request->clinic_id);
        $isalreadyLive = PatientPeriodReportingTable::where('userid', $userId)
            ->where('clinic_id', $clinic_id)
            ->where('type_clinic', $request->clinic_type)
            ->where('status', 'Live')
            ->orderByDesc('year')
            ->orderByDesc('quarter')
            ->first();

        if (!empty($isalreadyLive)) {

            return response()->json([
                'message' => 'Please Finish the live quarter first'
            ]);
        }
        $previousRecord = PatientPeriodReportingTable::where('userid', $userId)
            ->where('clinic_id', $clinic_id)
            ->where('type_clinic', $request->clinic_type)
            ->where('status', 'Finished')
            ->orderByDesc('year')
            ->orderByDesc('quarter')
            ->get();
        if ($previousRecord->isEmpty()) {

            return response()->json([
                'message' => 'No Quarter Started.'
            ]);
        }
        $quarterTable = QuarterTable::get();
        return response()->json([
            'previousRecord' => $previousRecord,
            'quarterTable' => $quarterTable,
            'status' => true
        ]);
    }
    public function unlockPatientReportSubmit(Request $request)
    {
        if($request->clinic_type == "" && $request->quarter == "" && $request->year == "" && $request->revision_reason == ""){
                return redirect()->route('clinic.unlock.patient.report')->with('error', 'Please select clinic type, quarter, year and revision reason.');
            }
        $clinic_id = Crypt::decryptString($request->clinic_id);
        try {
            $report = new PatientPeriodReportingTable();
            $connectionName = $report->getConnectionName();

            DB::connection($connectionName)->beginTransaction();

            $userId = Session::get('id');
            $clinic_type = $request->clinic_type;
            $quarter = $request->quarter;
            $year = $request->year;
               

            $recordToUnlock = PatientPeriodReportingTable::where('userid', $userId)
                ->where('clinic_id', $clinic_id)
                ->where('type_clinic', $clinic_type)
                ->where('quarter', $quarter)
                ->where('year', $year)
                ->where('status', 'Finished')
                ->first();

            if ($recordToUnlock) {

                PatientPeriodReportingSnapshot::create([
                    'reporting_id' => $recordToUnlock->id,
                    'clinic_id' => $recordToUnlock->clinic_id,
                    'type_clinic' => $recordToUnlock->type_clinic,
                    'quarter' => $recordToUnlock->quarter,
                    'year' => $recordToUnlock->year,
                    'userid' => $recordToUnlock->userid,
                    'previous_status' => $recordToUnlock->status,
                    'previous_is_nilldata' => $recordToUnlock->is_nilldata,
                    'previous_final_submit_date' => $recordToUnlock->final_submit_date,
                    'previous_ip_address' => $recordToUnlock->ip_address,
                    'original_created_at' => $recordToUnlock->created_at,
                    'original_updated_at' => $recordToUnlock->updated_at,
                    'revised_userid' => $userId,
                    'revision_reason' => $request->revision_reason,
                    'revised_ip' => $request->ip(),
                ]);

                $recordToUnlock->status = 'Live';
                $recordToUnlock->save();

                DB::connection($connectionName)->commit();
                Log::info('Quarter unlocked successfully', [
                    'quarter' => $quarter,
                    'year' => $year,
                    'clinic_type' => $clinic_type,
                    'user_id' => $userId
                ]);
                $clinicTypeName = match ($clinic_type) {
                    'ARTCLINIC' => 'ART Clinic',
                    'ARTBANK' => 'ART Bank',
                    'ARTSURROGACY' => 'Surrogacy Clinic',
                    default => 'Clinic',
                };
                $quarterName = QuarterTable::where('id', $quarter)->first();
                return redirect()->route('clinic.unlock.patient.report')->with('message', $year . ' (' . $quarterName->description . ') Quarter of ' . $clinicTypeName . ' unlocked successfully. You may continue to fill or edit the patient/donor details of this quarter.');
                // return redirect()->route('clinic.unlock.patient.report')->with('message', 'Quarter unlocked successfully. Now you may continue fill or edit the patient details.');
            } else {
                DB::connection($connectionName)->rollBack();
                Log::warning('Attempted to unlock a quarter that does not exist or is already unlocked', [
                    'quarter' => $quarter,
                    'year' => $year,
                    'clinic_type' => $clinic_type,
                    'user_id' => $userId
                ]);
                return redirect()->route('clinic.unlock.patient.report')->with('message', 'No matching quarter found to unlock or it is already unlocked.');
            }
        } catch (\Exception $e) {
            DB::connection($connectionName)->rollBack();

            Log::error('Error unlocking patient report: ', [
                'error' => $e->getMessage(),
                'clinic_id' => $clinic_id,
                'quarter' => $quarter,
                'year' => $year,
                'clinic_type' => $clinic_type
            ]);

            return redirect()->route('clinic.unlock.patient.report')->with('error', 'An error occurred while unlocking the quarter. Please contact support.');
        }
    }
}
