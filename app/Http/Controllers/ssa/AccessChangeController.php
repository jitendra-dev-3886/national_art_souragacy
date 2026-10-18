<?php

namespace App\Helpers;
namespace App\Http\Controllers\ssa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\AccessChangeRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use App\Mail\AccessChangeRequest;
use App\Mail\AccessChangeVerify;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use App\Models\clinic\signup;
use App\Models\clinic\ClinicRegistrationModel;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class AccessChangeController extends Controller
{
    public function create()
    {
        if(session()->has('tempurl')){
            session()->forget(['tempurl']);
        }
        return view('layouts.admin.clinic_email_change_request');
    }
    public function checkEmailaccess(Request $request)
    {
        $new_clinic_email = $request->input('new_clinic_email');

        if (!$new_clinic_email) {
            return response()->json(['status' => 'error', 'message' => 'Email is required'], 400);
        }

        $exists = signup::where('email', $new_clinic_email)->exists();
        $exists2 = AccessChangeRequests::where('new_clinic_email', $new_clinic_email)->where('status', '!=', 'failed')->exists();
        $exists3 = DB::table('signup_history')->where('email',$new_clinic_email)->exists();

        if ($exists || $exists2 || $exists3) {
            return response()->json(['status' => 'exists']);
        }

        return response()->json(['status' => 'available']);
    }
    public function store(Request $request)
    {
        // dd($request);
    try {
        if(!session()->has('tempurl')){
            $tempurl = $request->fullUrl();
            session()->put('tempurl', $tempurl);
            // dd($tempurl);
        }
        $request->validate([
        // 'application_no' => 'required|exists:clinic_registration,application_no|exists:accesschange_table_data,application_no',
        // 'registration_no' => 'required|exists:clinic_registration,registration_no|exists:accesschange_table_data,registration_no',
        'application_no' => 'required|exists:clinic_registration,application_no',
        'registration_no' => 'required|exists:clinic_registration,registration_no',
        'registration_date' => 'required|date',
        'clinic_name' => 'required|string|max:255',
        'address' => 'required|string',
        'state' => 'required|string',
        'district' => 'required|string',
        'clinic_type' => 'required|string',
        // 'clinic_level' => 'required|string',
        // 'contact_person_name' => 'required|string',
        // 'contact_mobile' => 'required|digits:10',
        'clinic_phone' => 'required',
        'old_clinic_email' => 'required|email|exists:signup,email',
        'new_clinic_email' => 'required|email',
        'new_clinic_email_confirm' => 'same:new_clinic_email',
        'new_clinic_mobile' => 'required|digits:10',
        'new_clinic_mobile_confirm' => 'same:new_clinic_mobile',
         'change_reason' => 'required|string',
        'request_letter_path' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        'authorized_person_name' => 'required|string',
        'authorized_person_designation' => 'required|string',
        'authorized_person_mobile' => 'required|digits:10',
        'authorized_person_email' => 'required|email',
        'declaration' => 'required|accepted',
    ], [
    'request_letter_path.required' => 'Please upload Request Letter',
    'request_letter_path.mimes' => 'Only pdf, jpg, jpeg, png files are allowed',
    'request_letter_path.max' => 'Maximum file size is 2MB',
    ]);
    } catch (ValidationException $e) {

        Log::error('Clinic change request validation failed', [
            'errors' => $e->errors(),
            'input'  => $request->except(['request_letter_path']),
            'ip'     => $request->ip(),
        ]);
        
        throw $e; // IMPORTANT: sends errors back to Blade
    }
    // dd("test");
    try{    
            session()->forget(['tempurl']);
            $match = ClinicRegistrationModel::where('application_no', $request->application_no) 
                ->where('registration_no', $request->registration_no)
                ->where('email', $request->old_clinic_email)
                ->exists();
            if (!$match) {
                Log::warning("For Application no, registration no or email id server side validation failed.", [
                    'application_no' => $request->application_no,
                    'registration_no' => $request->registration_no,
                    'email' => $request->old_clinic_email
                ]);
                return redirect()->route('clinic.email_change')
                    ->with('error', 'A request with this Application No, Registration No, and Email id is not allowed.');
            }else{
                $state_name = Session::get('state_name'); 
                if($state_name!=$request->state){
                        Log::warning("State name is changed here server side validation failed.", [
                        'application_no' => $request->application_no,
                        'registration_no' => $request->registration_no,
                        'email' => $request->old_clinic_email,
                        'state' => $request->state
                    ]);
                    return redirect()->route('clinic.email_change')
                        ->with('error', 'A request with this Application No, Registration No, and Email id is not allowed.');
                }
            }
            $exists = AccessChangeRequests::where('application_no', $request->application_no) 
                ->where('registration_no', $request->registration_no)
                ->where('old_clinic_email', $request->old_clinic_email)
                ->where('status', '!=', 'failed')
                ->exists();
            if ($exists) {
                Log::warning("Request with these details is already exists.", [
                    'application_no' => $request->application_no,
                    'registration_no' => $request->registration_no,
                    'email' => $request->old_clinic_email
                ]);
                return redirect()->route('clinic.email_change')
                    ->with('error', 'A request with this Application No, Registration No, and Email id is not allowed.');
            }
            $oldEmail = $request->old_clinic_email;
            $newEmail = $request->new_clinic_email;

            $signupExists = Signup::where(function ($q) use ($oldEmail, $newEmail) {
                    $q->where('email', $oldEmail)
                    ->where('isemail_updated', '>', 0)
                    ->orWhere('email', $newEmail);
                })
                ->where('status',1)
                ->exists();
            $signupHistoryExists = DB::table('signup_history')
                ->where('email', $newEmail)
                ->where('status', 1)
                ->exists();
            $accessChangeExists = AccessChangeRequests::where(function ($q) use ($oldEmail, $newEmail) {
                    $q->where('new_clinic_email', $newEmail)
                    ->orWhere('new_clinic_email', $oldEmail)
                    ->orWhere('old_clinic_email', $newEmail);
                })
                ->where('status', '!=', 'failed')
                ->exists();
            if ($signupExists || $signupHistoryExists || $accessChangeExists ) {
                Log::warning("This email id is already exists.", [
                    'signup' => $signupExists,
                    'accesschange' => $accessChangeExists,
                    'signup_history' => $signupHistoryExists
                ]);
                return redirect()->route('clinic.email_change')
                    ->with('error', 'A request to update this desired Email id is not allowed.');
            }
            DB::beginTransaction();
            Log::warning("This transaction begin.", [
                    'state' => $request->state,
                    'date' => now()
                ]);
            $stateCode = strtoupper(substr($request->state, 0, 2));
            $year = date('Y');
            $sequence_no = AccessChangeRequests::latest('id')->value('id');
            $requestId = $stateCode . '-' . $year . '-' . str_pad($sequence_no, 6, '0', STR_PAD_LEFT);
            $active_status=1;
            $ssa_id= Session::get('id');
            $temptoken = Str::random(60);
            // Encrypt the email
            $requestid = Crypt::encrypt($requestId);
            // Construct the custom link
            // $link = URL::temporarySignedRoute(
            //             'clinic.verify_access',        // route name
            //             now()->addDays(7),             // expires in 7 days
            //             [
            //                 'reqno'     => $requestid,
            //                 'temptoken' => $temptoken,
            //             ]
            //         );
            $stoplink = URL::temporarySignedRoute(
                        'clinic.stop_access',        // route name
                        now()->addDays(3),             // expires in 7 days
                        [
                            'reqno'     => $requestid,
                            'temptoken' => $temptoken,
                        ]
                    );
            $clinicstopaccess = [
            'link' => $stoplink,
            'state' => $request->state,
            ];
            // $clinicverifyaccess = [
            // 'link' => $link,
            // 'state' => $request->state,
            // ];
            $file = $request->file('request_letter_path');
            $timestamp = date('Y-m-d_His');
            $allowedExtensions = ["pdf", "jpeg", "jpg", "gif"];
            $originalExtension = $file->getClientOriginalExtension();
            if (in_array(strtolower($originalExtension), $allowedExtensions)){
                    $filename2 = 'clinic_access_change_Request_letter' . $timestamp . '_' . $ssa_id . '.' . $originalExtension;
                    $dbpath = $filename2;

            }else {
                    // Throw a custom exception
                    throw new \Exception("File type not allowed. Allowed types are: " . implode(', ', $allowedExtensions));
            }
            $application_no_folder = str_replace(' ', '_', $request->state) ;
            $foldername = 'clinicaccesschange';
            $baseDir = folderpath($foldername);
            $fullFolderPath = $baseDir . $application_no_folder;
            if (!File::exists($fullFolderPath)) {
                File::makeDirectory($fullFolderPath, 0755, true);
            }
            $file->move($fullFolderPath, $filename2);
            AccessChangeRequests::create([ 'request_id' => $requestId,
            'application_no' => $request->application_no, 
            'registration_no' => $request->registration_no,
            'registration_date' => $request->registration_date,
            'clinic_name' => $request->clinic_name,
            'address' => $request->address, 
            'state' => $request->state,
            'district' => $request->district, 
            'clinic_type' => $request->clinic_type,
            'clinic_level' => $request->clinic_level,
            // 'contact_person_name' => $request->contact_person_name, 
            // 'contact_mobile' => $request->contact_mobile,
            'clinic_phone' => $request->clinic_phone,
            'old_clinic_email' => $request->old_clinic_email,
            'new_clinic_email' => $request->new_clinic_email,
            'new_clinic_mobile' => $request->new_clinic_mobile, 
            'change_reason' => $request->change_reason, 
            'request_letter_path' => $dbpath,
            'authorized_person_name' => $request->authorized_person_name,
            'authorized_person_designation' => $request->authorized_person_designation,
            'authorized_person_mobile' => $request->authorized_person_mobile,
            'authorized_person_email' => $request->authorized_person_email,
            'declaration' => $request->declaration,
            'created_by' => $ssa_id,
            'is_active' => $active_status,
            'token' => $temptoken
         ]);
            $clinic_records = $request->clinic_record;
            foreach ($clinic_records as $record) {
                $clinicType = $record['clinic_type'];
                $applicationNo = $record['application_no'];
                $registrationNo = $record['registration_no'];
                DB::table('accesschange_child')->insert([
                    'accesschange_request_id'        => $requestId,
                    'application_no'    => $applicationNo,
                    'registration_no'   => $registrationNo,
                    'clinic_type'       => $clinicType,
                ]);
                // Use them as needed
            }
        Mail::to($request->old_clinic_email)->send(new AccessChangeRequest($clinicstopaccess));
        // Mail::to($request->new_clinic_email)->send(new AccessChangeVerify($clinicverifyaccess));
        DB::commit();
        return redirect()->route('clinic.email_change')->with('success', 'Clinic details submitted successfully.');
        }
        catch (\Exception $e) {
        DB::rollBack();
        Log::error('clinic access change request not completed: ' . $e->getMessage());
        return redirect()->route('clinic.email_change')->with('error', 'An error occurred while access change request.');
        }
    }
    public function applicaion_no(Request $request)
    {
        $state_name = Session::get('state_name');
        // dd(session()->all());
        $application_no = $request->application_no;
        $registration_no = $request->registration_no;

        // Fetch only by application_no
        // $predata = DB::table('accesschange_table_data')
        //             ->where('application_no', $application_no)
        //             ->where('registration_no',$registration_no)
        //             ->where('state',$state_name)
        //             ->where('status',1)
        //             ->first();
        // if (!$predata) {
        //     Log::info("Access change attempted by SSA", [
        //                     'State' => $state_name,
        //                     'applicationno' => $application_no,
        //                     'registratinno' => $registration_no
        //                 ]);
        //     return response()->json([
        //         'exists' => false,
        //         'match' => false,
        //         'message' => "Either Application Number or Registration not found."
        //     ]);
        // }            
        $data = DB::table('clinic_registration')
                    ->where('application_no', $application_no)
                    ->where('registration_no',$registration_no)
                    ->where('state',$state_name)
                    ->where('status',1)
                    ->first();
        if (!$data) {
            return response()->json([
                'exists' => false,
                'match' => false,
                'message' => "Either Application Number or registration not found."
            ]);
        }
        
        $temp = AccessChangeRequests::where('old_clinic_email', $data->email)
                ->where('status', '!=', 'failed')
                ->exists();
        if ($temp) {
                return response()->json([
                'exists' => true,
                'match' => false,
                'message' => "Email id is already assigned to some other clinic."
            ]);
            }
        // // Now check if registration_no matches
        // if ($data->registration_no != $registration_no) {
        //     return response()->json([
        //         'exists' => true,
        //         'match' => false,
        //         'message' => "The Application No. and Registration No. do not belong to the same clinic"
        //     ]);
        // }
        $data2 = DB::table('clinic_registration')
            ->where('email', $data->email)
            ->where('state',$state_name)
            ->where('status',1)->orderBy('id', 'desc')->get();

        // Both match
        if ($data2->isEmpty()) {
            return response()->json([
                'exists' => true,
                'match' => false,
                'message' => "Clinic with this Application Number or Registration is not registered."
            ]);
        }
        $statusMap = [
            'ARTBANK'   => 'ART BANK',
            'ARTCLINIC' => 'ART CLINIC',
            'ARTSURROGACY'  => 'SURROGACY CLINIC',
        ];
        // dd($data);
        $data2 = $data2->map(function ($row) use ($statusMap) {
            $row->clinic_type_label = $statusMap[$row->clinic_type] ?? ucfirst($row->clinic_type);
            return $row;
        });
        return response()->json([
            'exists' => true,
            'match' => true,
            'data' => [
                        'name' => $data->name,
                        'state' => $data->state,
                        'district' => $data->district,
                        'clinic_type' => $data->clinic_type,
                        'level' => !empty($data->level) ? $data->level : 'NA',
                        'contact_number_clinic' => $data->contact_number_clinic,
                        'address' => $data->address,
                        'email' => $data->email,

                        // Convert registration_date safely
                        'rgistration_date' => !empty($data->rgistration_date)
                            ? date('Y-m-d', strtotime($data->rgistration_date))
                            : null
                    ],
            'data2' => $data2
        ]);
    }
    public function stopemailrequest(Request $request)
    {
        $temptoken = $request->temptoken;
        $dreqno = Crypt::decrypt($request->reqno); 
        if(!empty($dreqno) && !empty($temptoken)){
            $record = DB::table('accesschangerequests')
                                    ->where('request_id', $dreqno)
                                    ->where('status', 'pending')
                                    ->where('token', $temptoken)
                                    ->get();
            // dd($record);
            if($record->isEmpty()){
                    return redirect()->route('error.accesschange')->with('error', 'The link has expired.'); // due to token or status change
            }
            if(!is_null($record[0]->stop_confirmed_at)){
                    return redirect()->route('error.accesschange')->with('error', 'The link has expired.'); // due to token or status change
            }
            try{
                DB::beginTransaction();
                DB::table('clinic_verify_attempts')->insert([
                            'accesschange_request_id'  => $dreqno,
                            'token'                    => $temptoken,
                            'ip_address'               => getHostByName(getHostName()),
                        ]);
                $request_ID = $record->first()->request_id;
                DB::table('hold_change_request')->insert([
                'request_id' => $request_ID,
                'ip_address' => getHostByName(getHostName()),
                'hold_status' => 'Requested',
                'hold_requested_at' => now()
                ]);
                // dd($record);
                DB::table('accesschangerequests')->where('request_id',$request_ID)
                    ->update([
                    'status'=>'requested',
                    ]);
                // dd("temp");
                DB::commit();
                return view('layouts.clinic.thanks');
            }catch (\Exception $e) {
            DB::rollBack();
            Log::error('hold request not updated or accesschangerequest status not updated: ' . $e->getMessage());
            return redirect()->route('error.accesschange')->with('error', 'something went wrong please contact support team.');
            }
        }else{
            return redirect()->route('error.accesschange')->with('error', 'Unauthorized access');   // due to request no change.
        }
    }
    

    public function clinicverify(Request $request)
    {
        // if (!session()->has('verify_url')) {
        //     session(['verify_url' => $request->fullUrl()]);
        // }
        // dd(session('verify_url'));
        $reqno = $request->reqno;
        $temptoken = $request->temptoken;
        // dd($temptoken);
        $dreqno = Crypt::decrypt($request->reqno); 
        if (!empty($dreqno) && !empty($temptoken)) {
                    // dd("tessdfsdfmp");
                    $key = "verify_attempts_{$request->reqno}_{$request->temptoken}";
                    $attempts = Cache::get($key, 0);
                    if ($attempts > 10) {
                        // Log abuse
                        Log::warning("Too many verification attempts", [
                            'reqno' => $dreqno,
                            'temptoken' => $request->temptoken,
                            'ip' => $request->ip()
                        ]);
                        DB::table('accesschangerequests')
                                ->where('request_id', $dreqno)
                                ->where('status', 'pending')
                                ->where('token', $request->temptoken)
                                ->update([
                                    'status'     => 'failed',
                                    'updated_at' => now()
                                ]);
                        Cache::forget("verify_attempts_{$request->reqno}_{$request->temptoken}");
                        return redirect()->route('error.accesschange')
                            ->with('error', 'Too many verification attempts. This link is locked.'); // due to many attempts
                    }
                    // Increase attempt count (expire same time as signed URL)
                    Cache::put($key, $attempts + 1, now()->addDays(7));
                    $record = DB::table('accesschangerequests')
                                    ->where('request_id', $dreqno)
                                    ->where('status', 'pending')
                                    ->where('token', $request->temptoken)
                                    ->get();
                    
                    if($record->isEmpty()){
                        Log::warning("Access change link accessed by verifying clinic but expired", [
                            'reqno' => $dreqno,
                            'temptoken' => $request->temptoken,
                            'ip' => $request->ip()
                        ]);
                    return redirect()->route('error.accesschange')->with('error', 'The link has expired.'); // due to token or status change
                    }
                    $clinic_types = DB::table('accesschange_child')
                            ->where('accesschange_request_id', $dreqno)
                            ->pluck('clinic_type');
                    // dd($clinic_types);
                    $count = count($clinic_types);
                    Log::warning("Access change form opened by verifying clinic successfully", [
                            'reqno' => $dreqno,
                            'temptoken' => $request->temptoken,
                            'ip' => $request->ip()
                        ]);
                    return view('layouts.clinic.clinic_verify_form', [
                    'count' => $count,
                    'clinics' => $clinic_types,
                    'reqno' => $reqno,
                    'temptoken' => $temptoken
                    ]);
            }else{
                // dd("tesmp");
                return redirect()->route('error.accesschange')->with('error', 'Unauthorized access');   // due to request no change.
            }
    }
    public function clinicverifysubmit(Request $request)
    {
        // UNIQUE KEY FOR THIS REQUEST + TOKEN
        // How many attempts so far?
        // dd(session('verify_url'));
        try {
            $dreqno = Crypt::decrypt($request->reqno);
            // dd($request->temptoken);
            // $dreqno = Crypt::decrypt($request->reqno);
            // dd($dreqno);
            if (!empty($dreqno) && !empty($request->temptoken)) {
                    $record = DB::table('accesschangerequests')
                                    ->where('request_id', $dreqno)
                                    ->where('status', 'pending')
                                    ->where('token', $request->temptoken)
                                    ->get();
                    
                    if($record->isEmpty()){
                    return redirect()->route('error.accesschange')->with('error', 'The link has expired.');
                    }
                    $request->validate([
                        'application_no' => 'required|array',
                        'application_no.*' => 'required|string|max:20',
                        'registration_no' => 'required|array',
                        'registration_no.*' => 'required|string|max:50',
                        'verify_new_email'   => 'required|email',
                        'verify_new_phone'   => 'required|digits:10',
                        'reason_for_change'  => 'required',
                        'authorized_person_name' => 'required|string',
                        'authorized_person_designation' => 'required|string',
                        'authorized_person_mobile' => 'required|digits:10',
                        'authorized_person_email' => 'required|email',
                        'declaration' => 'required|accepted'                        
                    ]);
                    $finalrecord = DB::table('accesschangerequests')
                                ->where('request_id', $dreqno)
                                ->where('new_clinic_email', $request->verify_new_email)
                                ->where('new_clinic_mobile', $request->verify_new_phone)
                                ->where('token', $request->temptoken)
                                ->where('is_active', 1)
                                ->where('status', 'pending')
                                ->get();
                    // dd($finalrecord);
                    if($finalrecord->isEmpty()){
                        DB::table('clinic_verify_attempts')->insert([
                            'accesschange_request_id'         => $record->first()->request_id,
                            'token'  => $request->temptoken,
                            'ip_address'        => getHostByName(getHostName()),
                        ]);
                        $attemptCount = DB::table('clinic_verify_attempts')
                            ->where('accesschange_request_id', $record->first()->request_id)
                            ->where('token', $request->temptoken)
                            ->count();

                        if ($attemptCount > 5) {
                            DB::table('accesschangerequests')
                                ->where('request_id', $dreqno)
                                ->where('status', 'pending')
                                ->where('token', $request->temptoken)
                                ->update([
                                    'status'     => 'failed',
                                    'updated_at' => now()
                                ]);
                            return redirect()->route('error.accesschange')
                                ->with('error', 'Too many verification attempts. This link is locked.');
                        }
                        $maxAttempts = 5;
                        $remaining = $maxAttempts - $attemptCount;
                        $access_url = URL::temporarySignedRoute('clinic.verify_access', now()->addDays(7), [
                                    'reqno' => $request->reqno,
                                    'temptoken' => $request->temptoken,
                                ]);
                        return redirect($access_url)->with('error', "Either email or Phone number is not authorized. Attempts left: $remaining");
                    }
                    // dd($finalrecord);
                    $child_records = DB::table('accesschange_child')
                                    ->where('accesschange_request_id', $dreqno)
                                    ->get()
                                    ->keyBy('application_no')
                                    ->toArray();
                    // dd($child_records);
                    $oldEmail = $finalrecord->first()->old_clinic_email;
                    $newEmail = $finalrecord->first()->new_clinic_email;
                    $application_nos  = $request->application_no;      // array
                    $registration_nos = $request->registration_no;     // array
                    $errors = [];
                    // dd($application_nos);
                    // dd($registration_nos);
                    foreach ($application_nos as $index => $app_no) {
                        
                        $reg_no = $registration_nos[$index] ?? null;
                        // dd($index);
                        // dd($app_no);
                        // Check if this application_no exists in DB
                        if (!isset($child_records[$app_no])) {
                            $errors[] = "Application No $app_no is not a valid one or already used with other clinic/bank.";
                            continue;
                        }

                        $dbRecord = $child_records[$app_no];

                        // Compare registration_no
                        if ($dbRecord->registration_no != $reg_no) {
                            $errors[] = "Registration No mismatch for Application No $app_no";
                        }
                        // Remove the matched record so duplicates are caught
                        unset($child_records[$app_no]);
                    }
                    // dd($errors);
                    if (!empty($errors)) {
                        // Log exact errors for developer visibility
                        Log::error("Clinic verification validation failed", [
                            'request_id' => $request->reqno,
                            'user_input_application_no' => $request->application_no,
                            'user_input_registration_no' => $request->registration_no,
                            'errors' => $errors,  // exact details
                        ]);
                        DB::table('clinic_verify_attempts')->insert([
                        'accesschange_request_id'         => $record->first()->request_id,
                        'token'  => $request->temptoken,
                        'ip_address'        => getHostByName(getHostName()),
                        ]);
                        $attemptCount = DB::table('clinic_verify_attempts')
                        ->where('accesschange_request_id', $record->first()->request_id)
                        ->where('token', $request->temptoken)
                        ->count();

                        if ($attemptCount > 3) {
                            DB::table('accesschangerequests')
                                ->where('request_id', $dreqno)
                                ->where('status', 'pending')
                                ->where('token', $request->temptoken)
                                ->update([
                                    'status'     => 'failed',
                                    'updated_at' => now()
                                ]);
                            return redirect()->route('error.accesschange')
                                ->with('error', 'Too many verification attempts. This link is locked.');
                        }
                        $maxAttempts = 3;
                        $remaining = $maxAttempts - $attemptCount;
                        // Show generalized error to user
                        $access_url = URL::temporarySignedRoute('clinic.verify_access', now()->addDays(7), [
                                'reqno' => $request->reqno,
                                'temptoken' => $request->temptoken,
                            ]);
                        return redirect($access_url)->with('error', "The provided application or registration details are invalid. Attempts left: $remaining");
                    }
                    try{
                            DB::beginTransaction();
                            // dd($record);
                            DB::table('clinic_verifications')->insert([
                                'request_id'        => $dreqno,
                                'old_email'         => $record->first()->old_clinic_email,
                                'verify_new_email'  => $request->verify_new_email,
                                'old_phone'         => $record->first()->clinic_phone,
                                'verify_new_phone'  => $request->verify_new_phone,
                                'reason_for_change' => $request->reason_for_change,
                                'ip_address'        => getHostByName(getHostName()),
                                'verified_status'   => 'verified',
                                'authorized_person_name' => $request->authorized_person_name,
                                'authorized_person_designation' => $request->authorized_person_designation,
                                'authorized_person_mobile' => $request->authorized_person_mobile,
                                'authorized_person_email' => $request->authorized_person_email,
                                'declaration' => $request->declaration,
                                'verified_at'       => now(),
                                'updated_at'        => now(),
                            ]);
                            $clinic_verifification_id = DB::table('clinic_verifications')
                                ->where('request_id', $dreqno)
                                ->value('id');
                            $verify_records = [];
                            foreach ($application_nos as $index => $application_no) {
                                $verify_records[] = [
                                    'accesschange_request_id' => $finalrecord->first()->request_id,  // or whichever foreign key applies
                                    'clinic_verifification_id' => $clinic_verifification_id,
                                    'application_no'    => $application_no,
                                    'registration_no'   => $registration_nos[$index] ?? null,
                                ];
                            }
                            // Insert all at once
                            DB::table('clinic_verify_child')->insert($verify_records);
                            DB::table('accesschangerequests')
                                ->where('request_id', $finalrecord->first()->request_id)
                                ->update(['status' => 'verified']);
                            $userids = DB::table('clinic_registration')
                                        ->where('email', $oldEmail)
                                        ->where('status', 1)
                                        ->get(['id', 'userid_applicant']);
                            $uniqueUserIds = $userids->pluck('userid_applicant')->unique();
                            if ($uniqueUserIds->count() !== 1) {
                                Log::error('Clinic Access Verification Error', [
                                    'reqno'      => $dreqno,
                                    'temptoken'  => $request->temptoken,
                                    'ip_address' => $request->ip(),
                                    'userids'    => $userids
                                ]);
                                throw new \Exception('Multiple userid_applicant values found for the same clinic email.');
                            }
                            $userid = $uniqueUserIds->first();
                            $records_clinicreg = DB::table('clinic_registration')
                            ->where('email', $oldEmail)
                            ->where('status', 1)
                            ->get();
                            if ($records_clinicreg->isEmpty()) {
                                DB::rollBack();
                                return redirect()->route('error.accesschange')->with('error', 'Unauthorized access');
                            }
                            // 2. Update old records status to 0
                            DB::table('clinic_registration')
                                ->where('email', $oldEmail)
                                ->where('status', 1)
                                ->update([
                                    'status' => 0,
                                    'update_date' => now(),
                                    'application_type' => 4,
                                ]);
                            // 3. Prepare new records
                            $newRecords = [];

                            foreach ($records_clinicreg as $record) {
                                $new = (array) $record;   // convert object to array
                                unset($new['id']);        // remove primary key
                                // override required fields
                                $new['email'] = $finalrecord->first()->new_clinic_email;
                                $new['application_no'] = $finalrecord->first()->request_id;
                                $new['application_type'] = 4;
                                $new['status'] = 1;
                                $new['update_date'] = now();
                                $newRecords[] = $new;
                            }
                            // 4. Insert new records
                            DB::table('clinic_registration')->insert($newRecords);
                            // dd($userid);
                            DB::table('signup')
                                ->where('id', $userid)
                                ->where('isemail_updated', 0)
                                ->update(
                                    [
                                        'email' => $finalrecord->first()->new_clinic_email,
                                        'isemail_updated' => 1,
                                        'updated_at' => now()
                                    ]
                                );
                            DB::commit();
                            return redirect()->route('clinic.verify_accessthank')
                                    ->with('success', 'Your request has been successfully submitted.');
                    }catch (\Exception $e) {
                        Log::error('Clinic Access Verification Error inner try catch block', [
                            'reqno'      => $dreqno,
                            'temptoken'  => $request->temptoken,
                            'ip_address' => $request->ip(),
                            'action'     => 'Token validation failed in clinic.verify_access',
                            'exception'  => $e->getMessage(),
                            'trace'      => $e->getTraceAsString(),
                        ]);
                        DB::rollBack();
                        throw $e; // or log error
                    }      
            } else {
                return redirect()->route('error.accesschange')->with('error', 'Unauthorized access');
            }
            } catch (\Exception $e) {
                // Log exact failure details for debugging
                    Log::error('Clinic Access Verification Error', [
                        'reqno'      => $dreqno,
                        'temptoken'  => $request->temptoken,
                        'ip_address' => $request->ip(),
                        'action'     => 'Token validation failed in clinic.verify_access',
                        'exception'  => $e->getMessage(),
                        'trace'      => $e->getTraceAsString(),
                    ]);
                $access_url = URL::temporarySignedRoute('clinic.verify_access', now()->addDays(7), [
                            'reqno' => $request->reqno,
                            'temptoken' => $request->temptoken,
                        ]);
                return redirect($access_url)->with('error', 'Something went wrong please Contact Support Team.');
        }
    }
    public function clinicverifythank(){
        return view('layouts.clinic.thanks');
    }
    public function emailchangelist()
    {
        $state_name = Session::get('state_name');
        // dd($state_name);
        $data = DB::table('accesschangerequests as acr')
                ->where('state',$state_name)
                ->get();
        $statusMap = [
            'pending'   => 'Pending',
            'requested' => 'Objection Raised',
            'verified'  => 'Verified by Clinic',
            'Failed'  => 'Failed',
        ];
        // dd($data);
        $data = $data->map(function ($row) use ($statusMap) {
            $row->status_label = $statusMap[$row->status] ?? ucfirst($row->status);
            return $row;
        });
        return view('layouts.admin.accesschange_list', compact('data'));
        // ->select(
        //             // Primary
        //             'acr.request_id as request_id',

        //             // Application details
        //             'acr.application_no',
        //             'acr.registration_no',
        //             // 'acr.registration_date',

        //             // Clinic details
        //             'acr.clinic_name',
        //             // 'acr.address',
        //             // 'acr.state',
        //             // 'acr.district',
        //             'acr.clinic_type',
        //             // 'acr.clinic_level',
        //             'acr.clinic_phone',

        //             // Contact details
        //             // 'acr.contact_person_name',
        //             // 'acr.contact_mobile',

        //             // Change request details
        //             'acr.old_clinic_email',
        //             'acr.new_clinic_email',
        //             'acr.new_clinic_mobile',
        //             'acr.change_reason',
        //             'acr.request_letter_path',

        //             // Authority person details
        //             // 'acr.authorized_person_name',
        //             // 'acr.authorized_person_designation',
        //             // 'acr.authorized_person_mobile',
        //             // 'acr.authorized_person_email',
        //             // Status
        //             'acr.status',
        //             // 'acr.token',
        //             'acr.is_active',

        //             // Verification table fields
        //             // 'cv.old_phone',
        //             // 'cv.verify_new_phone',
        //             // 'cv.verified_status'
        //         )
    }
    public function updateStatus(Request $request)
    {
        $authority_id = Session::get('id');
        $accessRequest = DB::table('accesschangerequests')
            ->where('id', $request->id)
            ->first();
        try{
            DB::beginTransaction();    
            if(!$accessRequest){
                return response()->json([
                    'status' => false,
                    'message' => 'Request not found Contact Support Team'
                ]);
            }
            // Revoke logic
            if($request->action === 'revoke' && $accessRequest->status === 'pending'){
                DB::table('accesschangerequests')
                    ->where('id', $request->id)
                    ->update([
                        'status' => 'failed',
                        'revoked_at' => now(),
                        'revoked_by' => $authority_id
                    ]);
                // dd("revoke");
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Access change request revoked successfully'
                ]);
            }
            if($request->action === 'accept' && $accessRequest->status === 'requested'){
                DB::table('accesschangerequests')
                    ->where('id', $request->id)
                    ->update(['status' => 'failed', 'stop_confirmed_at' => now()]);
                $holdRequest = DB::table('hold_change_request')
                    ->where('request_id', $accessRequest->request_id)
                    ->first();
                if($holdRequest){
                    // $newStatus = $holdRequest->hold_status === 'Requested' ? 'Accepted' : 'Rejected';
                    DB::table('hold_change_request')
                        ->where('request_id', $accessRequest->request_id)
                        ->where('hold_status','Requested')
                        ->update([
                            'hold_status' => 'Accepted',
                            'hold_confirmed_at' => now(),
                            'hold_confirmed_by' => $authority_id
                        ]);
                }
                // dd("accept");
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Raised objection for access change Approved Successfully.'
                ]);
            }
            if($request->action === 'reject' && $accessRequest->status === 'requested'){
                DB::table('accesschangerequests')
                    ->where('id', $request->id)
                    ->update(['status' => 'pending', 'stop_confirmed_at' => now()]);
                $holdRequest = DB::table('hold_change_request')
                    ->where('request_id', $accessRequest->request_id)
                    ->first();
                if($holdRequest){
                    DB::table('hold_change_request')
                        ->where('request_id', $accessRequest->request_id)
                        ->where('hold_status','Requested')
                        ->update([
                            'hold_status' => 'Rejected',
                            'hold_confirmed_at' => now(),
                            'hold_confirmed_by' => $authority_id
                        ]);
                }
                // dd("reject");
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Raised objection for access change Rejected Successfully.'
                ]);
            }
            DB::commit();
            return response()->json([
                'status' => false,
                'message' => 'Action not allowed please contact support team.'
            ]);
        } catch (\Exception $e) {
        DB::rollBack();
        Log::error('One of the action revoke request, objection accept or objection reject not completed: ' . $e->getMessage());
        return response()->json([
                'status' => false,
                'message' => 'Something went wrong please contact support team.'
            ]);
        }
    }
    public function resendMail(Request $request)
    {
        $record = AccessChangeRequests::where('id', $request->id)
                    // ->whereDate('created_at', '<=', Carbon::now()->subDays(3))
                    ->where('status', 'pending')
                    ->first();
        if (!$record) {
            return response()->json([
                'status' => false,
                'message' => 'Request not found Contact Support Team'
            ]);
        }
        // if (is_null($record->email_sent)) {
        //     $remaining_days = Carbon::now()->diffInDays($record->created_at);
        //     // dd()
        //     return response()->json([
        //             'status'  => false,
        //             'message' => "Not allowed to send email. Wait for {$remaining_days} days."
        //         ]);
        // }
        if (!is_null($record->email_sent)) {
            try {
                // :one: Send Mail
                // Mail::to($record->new_clinic_email)
                //     ->send(new SignupUserforgetpassword($record));
                $temptoken = Str::random(60);
                $requestid = Crypt::encrypt($record->request_id);
                // dd($requestid);
                $link = URL::temporarySignedRoute(
                            'clinic.verify_access',        // route name
                            now()->addDays(7),             // expires in 7 days
                            [
                                'reqno'     => $requestid,
                                'temptoken' => $temptoken,
                            ]
                        );
                // dd($link);
                $clinicverifyaccess = [
                'link' => $link,
                'state' => $request->state,
                ];
                Mail::to($record->new_clinic_email)->send(new AccessChangeVerify($clinicverifyaccess));
                $record->update([
                    'email_sent' => now(),
                    'token' => $temptoken
                ]);
                DB::table('email_resend_logs')->insert([
                            'access_change_request_id' => $record->request_id,
                            'token' => $temptoken,
                            'resent_by' => 'ssa',
                            'resent_by_userid' => Session::get('id'),
                            'ip_address' => request()->ip(),
                        ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Mail sent successfully.'
                ]);
            } catch (\Exception $e) {
            Log::error('Resend mail failed', [
                    'error' => $e->getMessage()
                ]);
                return response()->json([
                    'status' => false,
                    'message' => 'Mail sending failed. Please try again.'
                ]);
            }
        }
        return response()->json([
            'status' => false,
            'message' => 'Invalid request please contact support.'
        ]);
    }
    public function accesschangelist()
    {
        $data = DB::table('accesschangerequests as acr')
                ->get();
        $statusMap = [
            'pending'   => 'Pending',
            'requested' => 'Objection Raised',
            'verified'  => 'Verified by Clinic',
            'Failed'  => 'Failed',
        ];
        // dd($data);
        $data = $data->map(function ($row) use ($statusMap) {
            $row->status_label = $statusMap[$row->status] ?? ucfirst($row->status);
            return $row;
        });
        return view('layouts.admin.accesschangelist', compact('data'));
    }
}
