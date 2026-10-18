<?php

namespace App\Http\Controllers;

use App\Mail\SSALoginOtp;
use App\Models\Admin\user;
use Illuminate\Http\Request;
use App\Models\clinic\signup;
use App\Helpers\ClinicRegistration;
use App\Models\DocFileUpload;
use Illuminate\Support\Carbon;
use App\Models\clinic\BankModel;
use App\Models\LoginAttempt;
use App\Models\Noc\docmastertable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\clinic\ArtClinicModel;
use App\Models\DocFilereceivedUpload;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Models\clinic\SurrogacyClinicModel;
use App\Models\clinic\BankCertificateDetails;
use App\Models\clinic\ArtClinicCertificateDetails;
use App\Models\DocFileRegistrationCertificateUpload;
use App\Models\clinic\SurrogacyClinicCertificateDetails;
use App\Events\FolderMissingEvent;
use App\Mail\SignupUserforgetpassword;
use Illuminate\Support\Str;
use App\Models\renewal\RenewalSCApplication;
use App\Models\ChangeAddress\ChangeAddressApplication;

class SSAController extends Controller
{
    public function storeShaPass(Request $request)
    {
        session(['sha_password' => $request->input('sha_password')]);
        return response()->json(['status' => true]);
    }

    public function showLoginForm_ssa()
    {
        // dd(generateRandomNumber());
        return view('layouts/admin/loginssaform');
        Session::put('ssa_login', 'No');
    }
    public function showLoginForm_ssa_data(Request $request)
    {
        //decryption starts here
        $encryptedPassword = $request->input('_password');

        $privateKey = file_get_contents(storage_path('app/rsa/private.key'));
        $decrypted = null;

        if (!openssl_private_decrypt(base64_decode($encryptedPassword), $decrypted, $privateKey)) {
            return back()->withErrors(['password' => 'Decryption failed.']);
        }

        // Merge decrypted password into request for validation
        $request->merge(['password' => $decrypted]);
        //decryption ends here
        //dd($decrypted);

        // Validate input fields
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
                'captcha' => 'required|captcha'

            ],

            ['captcha.captcha' => 'Invalid captcha code.']
        );

        $email = $request->input('email');
        $password = $request->input('password');
        //$password = session('sha_password');


        // Retrieve the user along with the related verified data
        $user = user::where('email', $email)->first();
        if(empty($user)){
            return redirect()->route('admin.loginssaform')->withErrors(['email' => 'Your account is not active.'])->withInput();
        }
        if($user->isAdmin==0)
        {
            return redirect()->route('admin.loginssaform')->withErrors(['email' => 'Your account is not active.'])->withInput();
        }
        if ($user && Hash::check($password, $user->password)) {
            // Store email in session
            $request->session()->put('email', $user->email);
            $request->session()->put('state', $user->stateid);
            $request->session()->put('id', $user->id);
            //$usertype = LoginAttempt::where('userid', session('id'))->latest()->value('user_type');
            $request->session()->put('user_type', '5');
            // Fetch the state name using the relationship
            $stateName = $user->state ? $user->state->state_name : 'Unknown State';
            // Store the state name in session for convenience
            $request->session()->put('state_name', $stateName);
            $otp = rand(100000, 999999); // 6 digit OTP
            // error_log("otp for ssa is undr /art url..................................." . $otp);
            // Store OTP in session
            // dd('temp');
            Log::warning('otp of ssa is...........................', ['ssa' => $user->id, 'state' => $stateName]);
            // error_log("otp of ssa is:........................." . $stateName);
            Session::put('login_otp', $otp);
            Session::put('otp_generated_at', now());
            // Prepare the email content
            $SSAotprequest = [
                'link' => $otp,
            ];
            // Send the email
            // Mail::to($request->email)->send(new SSALoginOtp($SSAotprequest));
            // Redirect to dashboard with a success message
            return redirect()->route('admin.showOtpForm_ssa')->with('success', 'Please check the email to Verify the OTP.' . $otp);
        }
        return redirect()->route('admin.loginssaform')->withErrors(['email' => 'Invalid credentials'])->withInput();

    }
    public function showOtpForm_ssa()
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }
        Session::put('ssa_login', 'No');
        return view('layouts.admin.SSAlogin_otp');
    }
    public function verifyssaOtpLogin(Request $request)
    {
        // Validate OTP
        $request->validate(
            [
                'login_otp' => 'required|numeric|digits:6',
                'captcha' => 'required|captcha'
            ],
            ['captcha.captcha' => 'Invalid captcha code.']
        );

        // Retrieve OTP from session
        $sessionOtp = Session::get('login_otp');
        $otpGeneratedAt = Session::get('otp_generated_at');
        // Check if OTP matches and is within the expiration time
        if ($sessionOtp && $sessionOtp == $request->login_otp && now()->diffInMinutes($otpGeneratedAt) <= 5) {

            $request->session()->regenerate();
            //dd(session()->all());
            // ✅ Bind session to fingerprint
            session([
                'fingerprint' => [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]
            ]);
            // OTP is valid
            Session::forget(['login_otp', 'otp_generated_at']); // Clear OTP from session
            LoginAttempt::where('userid', session('id'))->latest()->first();
            //print_r($sessionhistory);
            //  Step 3: Invalidate any old session for this user
            LoginAttempt::where('userid', session('id'))
                ->where('user_type', session('user_type'))
                ->whereNull('end_time')
                ->update([
                    'end_time' => Carbon::now(),
                ]);
            $sessionhistory = new LoginAttempt();
            $sessionhistory->start_time = Carbon::now();
            $sessionhistory->session_id = $request->session()->getId();
            $sessionhistory->id = LoginAttempt::max('id') + 1;
            $sessionhistory->userid = session('id');
            $sessionhistory->user_type = session('user_type');
            $sessionhistory->ip = $request->ip();
            $sessionhistory->save();
            return redirect()->route('ssa.dashboard')->with('success', 'Login successful!'); // Redirect to the home page or the dashboard
        } else {
            // OTP is invalid or expired
            return redirect()->route('admin.showOtpForm_ssa')->withErrors(['login_otp' => 'Invalid or expired OTP.']);
        }
    }
    public function ssa_dashboard()
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }
        // Get the logged-in user ID from the session
        $userId = Session::get('id');
        $stateName = Session::get('state_name');
        $totalartSubmittedData = ArtClinicModel::where('status', 1)->whereIn('archive_status', [0, 1])->where('state', $stateName)->count();
        $totalbankSubmittedData = BankModel::where('status', 1)->whereIn('archive_status', [0, 1])->where('state', $stateName)->count();
        $totalsurrogacySubmittedData = SurrogacyClinicModel::where('status', 1)->whereIn('archive_status', [0, 1])->where('state', $stateName)->count();
        // $totalartSubmittedData = signup::with('artclinics.app_no')->whereHas('artclinics.app_no')->where('state', $stateName)->whereIn('archive_status',[0,1])->count();
        // $totalbankSubmittedData = signup::with('bankclinics.bapp_no')->whereHas('bankclinics.bapp_no')->where('state', $stateName)->where('archive_status',[0,1])->count();
        // $totalsurrogacySubmittedData = signup::with('surrogacyclinics.sapp_no')->whereHas('surrogacyclinics.sapp_no')->where('state', $stateName)->where('archive_status',[0,1])->count();
        
        // renewal
        $totalrenewalsurrogacyData = RenewalSCApplication::select([
            DB::raw('COUNT(*) as total_submitted'),
            DB::raw("SUM(app_received = 'received') as total_received"),
            DB::raw("SUM(appstatus = 'Approved') as total_approved"),
            DB::raw("SUM(appstatus = 'Rejected') as total_rejected"),
            DB::raw("SUM(appstatus = 'Pending') as total_pending"),
        ])
            ->where('state', $stateName)
            ->where('clinic_type', 'ARTSURROGACY')
            ->where('status', 1)
            ->first();;
        $totalrenewalbankData = RenewalSCApplication::select([
            DB::raw('COUNT(*) as total_submitted'),
            DB::raw("SUM(app_received = 'received') as total_received"),
            DB::raw("SUM(appstatus = 'Approved') as total_approved"),
            DB::raw("SUM(appstatus = 'Rejected') as total_rejected"),
            DB::raw("SUM(appstatus = 'Pending') as total_pending"),
        ])
            ->where('state', $stateName)
            ->where('clinic_type', 'ARTBANK')
            ->where('status', 1)
            ->first();
        $totalrenewalclinicData = RenewalSCApplication::select([
            DB::raw('COUNT(*) as total_submitted'),
            DB::raw("SUM(app_received = 'received') as total_received"),
            DB::raw("SUM(appstatus = 'Approved') as total_approved"),
            DB::raw("SUM(appstatus = 'Rejected') as total_rejected"),
            DB::raw("SUM(appstatus = 'Pending') as total_pending"),
        ])->where('state', $stateName)->where('clinic_type', 'ARTCLINIC')->where('status', 1)->first();
        // dd($totalrenewalsurrogacyData);
        $totalrenewalduesurrogacyData = 0;
        $totalrenewalduebankData = 0;
        $totalrenewaldueclinicData = 0;

        // Change Address @(06-05-2026)
        $changeAddressData = ChangeAddressApplication::select(
            'clinic_type',
            DB::raw('COUNT(*) as total_submitted'),
            DB::raw("SUM(app_received = 'received') as total_received"),
            DB::raw("SUM(appstatus = 'Approved') as total_approved"),
            DB::raw("SUM(appstatus = 'Rejected') as total_rejected"),
            DB::raw("SUM(appstatus = 'Pending') as total_pending")
        )
        ->where('state', $stateName)
        ->where('status', 1)
        ->whereIn('clinic_type', ['ARTSURROGACY', 'ARTBANK', 'ARTCLINIC'])
        ->groupBy('clinic_type')
        ->get()
        ->keyBy('clinic_type');

        return view('layouts/admin/SSA_dashboard', compact('totalartSubmittedData', 
                                'totalbankSubmittedData', 'totalsurrogacySubmittedData', 
                                'totalrenewalsurrogacyData', 'totalrenewalbankData', 'totalrenewalclinicData',
                                'totalrenewalduesurrogacyData', 'totalrenewalduebankData', 'totalrenewaldueclinicData','changeAddressData'
                                ));
    }

 
    
    private function reg_handleFileUploads(Request $request, $clinicId)
    {
        //dd('hello');
        //$allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
        $allowedExtensions = ['pdf'];
        $docMasters = docmastertable::whereIn('doc_type', [
            'target_file_reg_artclinic_certificate'
            // Add more document types here 
            //reg_artclinic_certificate
        ])->where('status', 1)->get();

        //dd($docMasters);
        //$User = $this->getUserdata();       
        foreach ($docMasters as $docMaster) {

            //  dd($docMaster->doc_type);
            // Generate the file key based on the doc type
            $fileKey = str_replace('target_file_', '', $docMaster->doc_type);
            //     dd($fileKey);

            // Check if the file exists for this document type
            //dd($request->all());

            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                //dd($file);
                $extension = $file->getClientOriginalExtension();
                // Validate the file extension
                //dd($extension);
                if (in_array(strtolower($extension), $allowedExtensions)) {
                    $filename = $docMaster->doc_type . '-' . Carbon::now()->timestamp . '.' . $extension;
                    // dd($filename) ;               
                    // $basePath = url('/');   
                    // //dd($basePath) ; 
                    // $uploadPath = env('UPLOAD_PATH', 'art_clinic_receipt_no');
                    // //dd($uploadPath);
                    // $filePath = str_replace('art','',$basePath.''.$uploadPath) ;  
                    // dd($filePath);    
                    $destinationPath = 'C:/wamp64/www/art_clinic_certificate';

                    //dd($destinationPath);
                    // Store the file in the 'noc_documents' directory in the public disk
                    $filePath = $file->move($destinationPath, $filename);
                    $dbpath = $filename;
                    //dd($dbpath)   ;            
                    $stateName = Session::get('state_name');
                    $clinicId1 = $request->input('id');

                    $receivedssaartformList = signup::with('artclinics.app_no')->whereHas('artclinics', function ($query) use ($clinicId1) {
                        $query->where('id', $clinicId1); // Ensure correct column name
                    })->first();

                    DocFileRegistrationCertificateUpload::create([
                        'userid' => $receivedssaartformList->artclinics->userid,
                        'app_id' => $clinicId,
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



    private function reg_bankhandleFileUploads(Request $request, $bclinicId)
    {
        //dd('hello');
        //$allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
        $allowedExtensions = ['pdf'];
        $docMasters = docmastertable::whereIn('doc_type', [
            'target_file_reg_artbank_certificate'
            // Add more document types here 
            //reg_artclinic_certificate
        ])->where('status', 1)->get();
       
    
        //$User = $this->getUserdata();       
        foreach ($docMasters as $docMaster) {
            $fileKey = str_replace('target_file_', '', $docMaster->doc_type);
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                $extension = $file->getClientOriginalExtension();
                if (in_array(strtolower($extension), $allowedExtensions)) {
                    $filename = $docMaster->doc_type . '-' . Carbon::now()->timestamp . '.' . $extension;  
                    $destinationPath = 'C:/wamp64/www/art_bank_certificate';
                    $filePath = $file->move($destinationPath, $filename);                  
                    $dbpath = $filename;    
                    //dd($dbpath)   ;            
                    $stateName = Session::get('state_name');    
                        $clinicId1 = $request->input('id');
                        $receivedssabankformList = signup::with('bankclinics.bapp_no')->whereHas('bankclinics', function ($query) use ($clinicId1) {
                            $query->where('id', $clinicId1); // Ensure correct column name
                            })->first();

                    DocFileRegistrationCertificateUpload::create([
                        'userid' => $receivedssabankformList->bankclinics->userid,
                        'app_id' => $bclinicId,
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


    private function reg_surrogacyhandleFileUploads(Request $request, $sclinicId)
    {
        //dd('hello');
        //$allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
        $allowedExtensions = ['pdf'];
        $docMasters = docmastertable::whereIn('doc_type', [
            'target_file_reg_surrogacyclinic_certificate'
            // Add more document types here 
            //reg_artclinic_certificate
        ])->where('status', 1)->get();
       
   
        //$User = $this->getUserdata();       
        foreach ($docMasters as $docMaster) {

            //  dd($docMaster->doc_type);
            // Generate the file key based on the doc type
            $fileKey = str_replace('target_file_', '', $docMaster->doc_type);
            //  dd($fileKey);

            // Check if the file exists for this document type
            //dd($request->all());

            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                //  dd($request->hasFile($fileKey));
                $extension = $file->getClientOriginalExtension();
                // Validate the file extension
                //dd($extension);
                if (in_array(strtolower($extension), $allowedExtensions)) {
                    $filename = $docMaster->doc_type . '-' . Carbon::now()->timestamp . '.' . $extension;
                    // dd($filename) ;               
                    // $basePath = url('/');   
                    // //dd($basePath) ; 
                    // $uploadPath = env('UPLOAD_PATH', 'art_clinic_receipt_no');
                    // //dd($uploadPath);
                    // $filePath = str_replace('art','',$basePath.''.$uploadPath) ;  
                    // dd($filePath);    
                    $destinationPath = 'C:/wamp64/www/surrogacy_certificate';

                    //dd($destinationPath);
                    // Store the file in the 'noc_documents' directory in the public disk
                    $filePath = $file->move($destinationPath, $filename);
                    $dbpath = $filename;
                    //dd($dbpath)   ;            
                    $stateName = Session::get('state_name');
                    // Use `firstOrFail()` to handle cases where no record is found
                    // $receivedssaartformList = signup::with('artclinics.app_no')
                    //     ->whereHas('artclinics.app_no')
                    //     ->where('state', $stateName)
                    //     ->firstOrFail();





                        $clinicId1 = $request->input('id');

                        $receivedssasurrogacyformList = signup::with('surrogacyclinics.sapp_no')->whereHas('surrogacyclinics', function ($query) use ($clinicId1) {
                            $query->where('id', $clinicId1); // Ensure correct column name
                            })->first();

                    DocFileRegistrationCertificateUpload::create([
                        'userid' => $receivedssasurrogacyformList->surrogacyclinics->userid,
                        'app_id' => $sclinicId,
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
public function signupshowResetForm(Request $request)
{
    $decryptedEmail = Crypt::decryptString($request->email);
    $get_user = DB::table('user')
            ->where([
                'email' => $decryptedEmail,
                'ministry_approved' => 1,
            ])->where('isresetrequest', '>=', 1)
            ->first();
    if(!$get_user){
        return redirect('/');
    }
    return view('layouts/admin/signup-reset-password-ssa', compact('get_user'));
}
public function signupresetPassword(Request $request)
{
    $request->validate([
        'password' => 'required|string|max:50|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/|confirmed',
        //'password' => ['required', 'confirmed'],
    ]);
    //  $pp = $request->all();
    // Get user_request_table record
    $userRequest = DB::table('user')
            ->where([
                'email' => $request->email,
                'ministry_approved' => 1,
            ])->where('isresetrequest', '>=', 1)
            ->first();
    if (!$userRequest) {
        return redirect()->route('password.reset_signup_ssa')->withErrors(['email' => 'Email address is invalid or already requested for the password reset.']);
    }
    //check last password should not match:
    if (Hash::check($request->password, $userRequest->password)) {
        // dd($userRequest->password);
        return redirect()->route('password.reset_signup_ssa')->withErrors(['email' => 'New password should not be the same as last one']);
    } else {
            // Update the password in user_verified_table
            // dd('test');
            DB::table('user')
                ->where('id', $userRequest->id)
                ->where('isAdmin',1)
                ->update([
                    'password' => Hash::make($request->password),
                    'ministry_approved' => 0,
                    'updated_at' => now(),

                ]);
            // $request->session()->invalidate();
            // $request->session()->regenerateToken();
            return redirect()->route('admin.loginssaform')->with('status', 'Password reset successfully!');
    }
}
public function artimportdata()
{
    try {
        $results = DB::table('artclinic_certificate_details')
                    ->get();
        $i = 1001;
        $j=0;
        DB::beginTransaction();
        foreach ($results as $result) {
        
        try{
        if($result->approved_rejected=='Registration Granted'){
            
            $filename = $result->reg_no_file;
            $filename2 = NULL;
            if($filename){

            $timestamp = date('Y-m-d_His');
            $filename2 = 'target_file_reg_artclinic_certificate' . $timestamp . '_' . $filename;

            $sourcePath = "D:/xampp/htdocs/art_clinic_certificate/" . $filename;
            $baseDir = "D:/xampp/htdocs/artprojfiles/clinic_registration_certificate/";
            $fullFolderPath = $baseDir . $i;

            $destinationPath = $fullFolderPath . '/' . $filename2;
            
            // Insert into doc_file_uploads_registration_certificate
            DB::table('doc_file_uploads_registration_certificate')->insert([
                'userid' => $result->userid,
                'clinic_id' => $i,
                'doc_id' => 33,
                'doc_type' => 'target_file_reg_artclinic_certificate',
                'doc_upload_ref' => $filename2,
            ]);
            if (!file_exists($fullFolderPath)) {
                    mkdir($fullFolderPath, 0777, true);
                }
                if (!file_exists($sourcePath)) {
                    continue;
                }

                if (!copy($sourcePath, $destinationPath)) {
                    continue;
                }
            }
            // Get artclinic data once
            $artclinic = DB::table('artclinic')->where('status',1)->where('userid', $result->userid)->first();
            if (!$artclinic) continue;

            // Insert staff data
            $staffdata = DB::table('artclinic_otherstaff')
                            ->where('userid', $result->userid)
                            ->where('artclinic_id', $artclinic->id)
                            ->get();

            $insertStaff = [];
            foreach ($staffdata as $staff) {
                $insertStaff[] = [
                    'clinic_id' => $i,
                    'name' => $staff->name_otherstaff ?? null,
                    'post' => $staff->designation_otherstaff ?? null,
                    'qualification' => $staff->quali_otherstaff ?? null,
                    'application_no' => $artclinic->applicationno ?? null,
                    'status' => 1,
                    'clinic_type' => 'ARTCLINIC',
                    'type_emp' => 'ARTCLINICSTAFF',
                    'created_at' => $staff->datetime,
                    'updated_at' => now(),
                    'validitydate' => now()
                ];
            }
            if (!empty($insertStaff)) {
                DB::table('tbl_clinic_staff')->insert($insertStaff);
            }

            $artdirectdata = DB::table('artclinic_director')->select('*')
                      ->where('userid', $result->userid)
                      ->where('artclinic_id', $artclinic->id)
                      ->get();

                  $artinsertData = [];

                    // Step 102: Prepare insert data
                    foreach ($artdirectdata as $data) {
                        $artinsertData[] = [
                            'clinic_id'        => (string) $i, // ensure it's a string since DB column is varchar(30)
                            'name_director'    => $data->name_director ?? null,
                            'quali_director'   => $data->quali_director ?? null,
                            'reg_director'     => $data->reg_director ?? null,
                            'status'           => 1,
                            'clinic_type'      => 'ARTCLINIC',
                            'application_no'   => $artclinic->applicationno ?? null,
                            'created_at'       => $data->datetime,
                            'updated_at'       => now(),
                            'validitydate'     => now()
                        ];
                    }

                    if (!empty($artinsertData)) {
                        DB::table('tbl_director_staff')->insert($artinsertData);
                    }



            $equipments = DB::table('artclinic_equipment')
                            ->where('userid', $result->userid)
                            ->where('artclinic_id', $artclinic->id)
                            ->get();
            
           
        

            $insertEquip = [];
            foreach ($equipments as $equip) {
                $insertEquip[] = [
                    'clinic_id' => (string) $i,
                    'equipmentname' => $equip->equipmentname,
                    'application_no' => $artclinic->applicationno ?? null,
                    'status' => 1,
                    'clinic_type' => 'ARTCLINIC',
                    'created_at' => $equip->datetime,
                    'updated_at' => now(),
                    'validitydate' => now()
                ];
            }
            if (!empty($insertEquip)) {
                DB::table('tbl_clinic_equipment')->insert($insertEquip);
            }

             $artdata = [
                        'level'                         => $artclinic->cliniclevel ?? null,
                        'name'                          => $artclinic->clinicname ?? null,
                        'address'                       => $artclinic->address ?? null,
                        'state'                         => $artclinic->state ?? null,
                        'district'                      => $artclinic->district ?? null, 
                        'nature'                        => $artclinic->nature ?? null, 
                        'pincode'                       => $artclinic->pincode ?? null,
                        'mobile'                        => $artclinic->contact_person_mobile ?? null,
                        'email'                         => $artclinic->email ?? null,
                        'contact_number_clinic'         => $artclinic->contactno ?? null,
                        'fax_number'                    => $artclinic->fax ?? null,
                        'apply_registration'            => null,
                        'website'                       => $artclinic->website ?? null,
                        'date_of_establishment'         => $artclinic->dateestab ?? null,
                        'clinic_reg_mpt'                => $artclinic->mtpact ?? null,
                        'clinic_reg_pcpndt'             => $artclinic->pcpndtact ?? null,
                        'clinic_director'               => $artclinic->director ?? null,
                        'iui_h_s'                       => $artclinic->iuih ?? null,
                        'iui_d_s'                       => $artclinic->iuid ?? null,
                        'ivf_et'                        => $artclinic->ivfet ?? null,
                        'icsi'                          => $artclinic->icsi ?? null,
                        'pgt'                           => $artclinic->pgt ?? null,
                        'sperm_oocyte'                  => $artclinic->spermandoocyte ?? null,
                        'any_other_procedure'           => $artclinic->anyotherprocedure ?? null,
                        'any_other_detail'              => $artclinic->otherdetails ?? null,
                        'ejaculation'                   => $artclinic->ejaculation ?? null,
                        'electrojaculation'             => $artclinic->electroejaculation ?? null,
                        'processing_sperm'              => $artclinic->processingsperm ?? null,
                        'storage_sperm'                 => $artclinic->storagesperm ?? null,
                        'oocyte_doner'                  => $artclinic->oocytedonor ?? null,
                        'cryopreservation_of_sperm'     => $artclinic->cryopreservation ?? null,
                        'methode_of_freezing_of_sperm'  => $artclinic->spermslow ?? null,
                        'sperm_vitrification'           => $artclinic->spermvitrification ?? null,
                        'freezing_of_testicular_tissue' => $artclinic->tisticulartissue ?? null,
                        'application_no'                => $artclinic->applicationno ?? null,
                        'registration_no'               => $result->registration_no ?? null,
                        'certificate_valid_date'        => $result->validity_upto ?? null,
                        'certificate_path'              => $filename2 ?? null,
                        'status'                        => 1,
                        'clinic_type'                   => 'ARTCLINIC',
                        'clinic_id'                     => $i,
                        'userid_applicant'              => $result->userid ?? null,
                        'rgistration_date'              => $result->date_reg  ?? null,
                        'state_authority_id'            => Session::get('id')?? null,
                        'verify_certificate'            => 1,
                        'created_date'                  => now(),
                        'update_date'                   => now(),
                        'validitydate'                  => now(),
                        'ip_address'                    => getHostByName(getHostName())
                    ];
                  
            DB::table('clinic_registration')->insert($artdata);
            Log::error('clinic registered with clinic id: ' . $i);
            $i++;
        }
        
        else if($result->approved_rejected=='Registration Rejected' && $result->reg_no_file){
            $timestamp = date('Y-m-d_His');
            $filename = $result->reg_no_file;
            $filename2 = 'target_file_artclinic_rejected_certificate' . $timestamp . '_' . $filename;

            $sourcePath = "D:/xampp/htdocs/art_clinic_certificate/" . $filename;
            $baseDir = "D:/xampp/htdocs/artprojfiles/application_sa/";
            $application_no_folder= str_replace('/', '_', $result->application_no);
            $fullFolderPath = $baseDir . $application_no_folder;

            $destinationPath = $fullFolderPath . '/' . $filename2;
            DB::table('artclinic_certificate_details')
                ->where('userid', $result->userid) // 👈 your extra condition
                ->update(['reg_no_file' => $filename2]);

            if (!file_exists($fullFolderPath)) {
                    mkdir($fullFolderPath, 0777, true);
                }
                if (!file_exists($sourcePath)) {
                    Log::error("Reject copy skipped. File not found: " . $filename);
                    continue;
                }

                if (!copy($sourcePath, $destinationPath)) {
                    $error = error_get_last();
                    Log::error("Reject copy failed. From: $filename To: $destinationPath Error: " . print_r($error, true));
                    continue;
                }
            Log::error('clinic rejected with clinic id next to: ' . $i);
            Log::error('clinic rejected with reject sequence no: ' . $j);
            $j++;
        }
        
        }
        catch (\Exception $e) {
        
        Log::error('clinic registered with clinic id failed: ' . $i);
        Log::error('clinic rejection with clinic id failed: ' . $j);
        Log::error('clinic registered/rejection with clinic id failed: ' . $result->userid);
        Log::error('clinic registered/rejection with clinic id failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while importing data.');
        }
        }
        $recipts = DB::table('artclinic')
                    ->where('status',1)
                    ->whereNotNull('receipt_pdf')
                    ->get();
        $j=0;
        foreach ($recipts as $recipt) {
            $timestamp = date('Y-m-d_His');
            $filename = $recipt->receipt_pdf;
            $filename2 = 'target_file_receiving_artclinic_docs' . $timestamp . '_' . $filename;
            $sourcePath = "D:/xampp/htdocs/art_clinic_receipt_no/" . $filename;
            $baseDir = "D:/xampp/htdocs/artprojfiles/application_sa/";
            $application_no_folder= str_replace('/', '_', $recipt->applicationno);
            $fullFolderPath = $baseDir . $application_no_folder;
            $destinationPath = $fullFolderPath . '/' . $filename2;
            DocFilereceivedUpload::create([
                                        'userid'         => $recipt->userid,
                                        'app_id'         => $recipt->id,
                                        'doc_id'         => 30,
                                        'doc_type'       => 'target_file_receiving_artclinic_docs',
                                        'doc_upload_ref' => $filename2
                                        ]);
            if (!file_exists($fullFolderPath)) {
                    mkdir($fullFolderPath, 0777, true);
                }
                if (!file_exists($sourcePath)) {
                    Log::error("Reject copy skipped. File not found: " . $filename);
                    continue;
                }
                if (!copy($sourcePath, $destinationPath)) {
                    $error = error_get_last();
                    Log::error("Reject copy failed. From: $filename To: $destinationPath Error: " . print_r($error, true));
                    continue;
                }
            Log::error('clinic reciept with clinic id : ' . $recipt->id); 
            Log::error('clinic reciept with clinic sequence no: ' . $j);
            $j++;
        }
        DB::commit();
        return redirect()->back()->with('success', 'Art Clinic Data imported successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Art Clinic Data import failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while importing data.');
    }
    
    
}

public function surrogacyimportdata()
{
    try {
        $results = DB::table('surrogacy_certificate_details')
                    ->get();
        $i = 4001;
        $j=0;
        DB::beginTransaction();
        foreach ($results as $result) {
        try{
        if($result->approved_rejected=='Registration Granted'){
            $filename = $result->reg_no_file;
            $filename2 = NULL;
            if($filename){

            $timestamp = date('Y-m-d_His');
            $filename2 = 'target_file_reg_surrogacyclinic_certificate' . $timestamp . '_' . $filename;

            $sourcePath = "D:/xampp/htdocs/surrogacy_certificate/" . $filename;
            $baseDir = "D:/xampp/htdocs/artprojfiles/clinic_registration_certificate/";
            $fullFolderPath = $baseDir . $i;

            $destinationPath = $fullFolderPath . '/' . $filename2;

            // Insert into doc_file_uploads_registration_certificate
            DB::table('doc_file_uploads_registration_certificate')->insert([
                'userid' => $result->userid,
                'clinic_id' => $i,
                'doc_id' => 34,
                'doc_type' => 'target_file_reg_surrogacyclinic_certificate',
                'doc_upload_ref' => $filename2,
            ]);
            if (!file_exists($fullFolderPath)) {
                    mkdir($fullFolderPath, 0777, true);
                }
                if (!file_exists($sourcePath)) {
                    continue;
                }

                if (!copy($sourcePath, $destinationPath)) {
                    continue;
                }
            }
            // Get artclinic data once
            $surrogacyclinic = DB::table('surrogacyclinic')->where('status',1)->where('userid', $result->userid)->first();
            if (!$surrogacyclinic) continue;

            // Insert staff data
            $staffdata = DB::table('surrogacyclinic_otherstaff')
                            ->where('userid', $result->userid)
                            ->where('surrogacyclinic_id', $surrogacyclinic->id)
                            ->get();

            $insertStaff = [];
            foreach ($staffdata as $staff) {
                $insertStaff[] = [
                    'clinic_id' => $i,
                    'name' => $staff->name_otherstaff ?? null,
                    'post' => $staff->designation_otherstaff ?? null,
                    'qualification' => $staff->quali_otherstaff ?? null,
                    'application_no' => $surrogacyclinic->applicationno ?? null,
                    'status' => 1,
                    'clinic_type' => 'ARTSURROGACY',
                    'type_emp' => 'SURROGACYCLINICSTAFF',
                    'created_at' => $staff->datetime,
                    'updated_at' => now(),
                    'validitydate' => now()
                ];
            }
            if (!empty($insertStaff)) {
                DB::table('tbl_clinic_staff')->insert($insertStaff);
            }

            $surrogacydirectordata = DB::table('surrogacyclinic_director')->select('*')
                      ->where('userid', $result->userid)
                      ->where('surrogacyclinic_id', $surrogacyclinic->id)
                      ->get();

                  $surrogacyinsertData = [];

                    // Step 102: Prepare insert data
                    foreach ($surrogacydirectordata as $data) {
                        $surrogacyinsertData[] = [
                            'clinic_id'        => (string) $i, // ensure it's a string since DB column is varchar(30)
                            'name_director'    => $data->name_director ?? null,
                            'quali_director'   => $data->quali_director ?? null,
                            'reg_director'     => $data->reg_director ?? null,
                            'status'           => 1,
                            'clinic_type'      => 'ARTSURROGACY',
                            'application_no'   => $surrogacyclinic->applicationno ?? null,
                            'created_at'       => $data->datetime,
                            'updated_at'       => now(),
                            'validitydate'     => now()
                        ];
                    }

                    if (!empty($surrogacyinsertData)) {
                        DB::table('tbl_director_staff')->insert($surrogacyinsertData);
                    }
            $equipments = DB::table('surrogacyclinic_equipment')
                            ->where('userid', $result->userid)
                            ->where('surrogacyclinic_id', $surrogacyclinic->id)
                            ->get();
            
            $insertEquip = [];
            foreach ($equipments as $equip) {
                $insertEquip[] = [
                    'clinic_id' => (string) $i,
                    'equipmentname' => $equip->equipmentname,
                    'application_no' => $surrogacyclinic->applicationno ?? null,
                    'status' => 1,
                    'clinic_type' => 'ARTSURROGACY',
                    'created_at' => $equip->datetime,
                    'updated_at' => now(),
                    'validitydate' => now()
                ];
            }
            if (!empty($insertEquip)) {
                DB::table('tbl_clinic_equipment')->insert($insertEquip);
            }

             $surrogacydata = [
                        'level'                         => $surrogacyclinic->cliniclevel ?? null,
                        'name'                          => $surrogacyclinic->clinicname ?? null,
                        'address'                       => $surrogacyclinic->address ?? null,
                        'state'                         => $surrogacyclinic->state ?? null,
                        'district'                      => $surrogacyclinic->district ?? null, 
                        'nature'                        => $surrogacyclinic->nature ?? null, 
                        'pincode'                       => $surrogacyclinic->pincode ?? null,
                        'mobile'                        => $surrogacyclinic->contact_person_mobile ?? null,
                        'email'                         => $surrogacyclinic->email ?? null,
                        'contact_number_clinic'         => $surrogacyclinic->contactno ?? null,
                        'fax_number'                    => $surrogacyclinic->fax ?? null,
                        'apply_registration'            => null,
                        'website'                       => $surrogacyclinic->website ?? null,
                        'date_of_establishment'         => $surrogacyclinic->dateestab ?? null,
                        'clinic_reg_mpt'                => $surrogacyclinic->mtpact ?? null,
                        'clinic_reg_pcpndt'             => $surrogacyclinic->pcpndtact ?? null,
                        'clinic_director'               => $surrogacyclinic->director ?? null,
                        'iui_h_s'                       => $surrogacyclinic->iuih ?? null,
                        'iui_d_s'                       => $surrogacyclinic->iuid ?? null,
                        'ivf_et'                        => $surrogacyclinic->ivfet ?? null,
                        'icsi'                          => $surrogacyclinic->icsi ?? null,
                        'pgt'                           => $surrogacyclinic->pgt ?? null,
                        'sperm_oocyte'                  => $surrogacyclinic->spermandoocyte ?? null,
                        'any_other_procedure'           => $surrogacyclinic->anyotherprocedure ?? null,
                        'any_other_detail'              => $surrogacyclinic->otherdetails ?? null,
                        'ejaculation'                   => $surrogacyclinic->ejaculation ?? null,
                        'electrojaculation'             => $surrogacyclinic->electroejaculation ?? null,
                        'processing_sperm'              => $surrogacyclinic->processingsperm ?? null,
                        'storage_sperm'                 => $surrogacyclinic->storagesperm ?? null,
                        'oocyte_doner'                  => $surrogacyclinic->oocytedonor ?? null,
                        'cryopreservation_of_sperm'     => $surrogacyclinic->cryopreservation ?? null,
                        'methode_of_freezing_of_sperm'  => $surrogacyclinic->spermslow ?? null,
                        'sperm_vitrification'           => $surrogacyclinic->spermvitrification ?? null,
                        'freezing_of_testicular_tissue' => $surrogacyclinic->tisticulartissue ?? null,
                        'application_no'                => $surrogacyclinic->applicationno ?? null,
                        'registration_no'               => $result->registration_no ?? null,
                        'certificate_valid_date'        => $result->validity_upto ?? null,
                        'certificate_path'              => $filename2 ?? null,
                        'status'                        => 1,
                        'clinic_type'                   => 'ARTSURROGACY',
                        'clinic_id'                     => $i,
                        'userid_applicant'              => $result->userid ?? null,
                        'rgistration_date'              => $result->date_reg  ?? null,
                        'state_authority_id'            => null,
                        'verify_certificate'            => 1,
                        'created_date'                  => now(),
                        'update_date'                   => now(),
                        'validitydate'                  => now(),
                        'ip_address'                    => getHostByName(getHostName())
                    ];
                  
            DB::table('clinic_registration')->insert($surrogacydata);
            
            Log::error('clinic registered with clinic id: ' . $i);
            $i++;
        }
        else if($result->approved_rejected=='Registration Rejected' && $result->reg_no_file){
            $timestamp = date('Y-m-d_His');
            $filename = $result->reg_no_file;
            $filename2 = 'target_file_surrogacyclinic_rejected_certificate' . $timestamp . '_' . $filename;

            $sourcePath = "D:/xampp/htdocs/surrogacy_certificate/" . $filename;
            $baseDir = "D:/xampp/htdocs/artprojfiles/application_sa/";
            $application_no_folder= str_replace('/', '_', $result->application_no);
            $fullFolderPath = $baseDir . $application_no_folder;

            $destinationPath = $fullFolderPath . '/' . $filename2;
            DB::table('surrogacy_certificate_details')
                ->where('userid', $result->userid) // 👈 your extra condition
                ->update(['reg_no_file' => $filename2]);

            if (!file_exists($fullFolderPath)) {
                    mkdir($fullFolderPath, 0777, true);
                }
                if (!file_exists($sourcePath)) {
                    Log::error("Reject copy skipped. File not found: " . $filename);
                    continue;
                }

                if (!copy($sourcePath, $destinationPath)) {
                    $error = error_get_last();
                    Log::error("Reject copy failed. From: $filename To: $destinationPath Error: " . print_r($error, true));
                    continue;
                }
            Log::error('clinic rejected with clinic id next to: ' . $i);
            Log::error('clinic rejected with reject sequence no: ' . $j);
            $j++;
        }
        
        }
        catch (\Exception $e) {
        
        Log::error('clinic registered with clinic id failed: ' . $i);
        Log::error('clinic rejection with clinic id failed: ' . $j);
        Log::error('clinic registered/rejection with clinic id failed: ' . $result->userid);
        Log::error('clinic registered/rejection with clinic id failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while importing data.');
        }
        }
        $recipts = DB::table('surrogacyclinic')
                    ->where('status',1)
                    ->whereNotNull('receipt_pdf')
                    ->get();
        $j=0;
        foreach ($recipts as $recipt) {
            $timestamp = date('Y-m-d_His');
            $filename = $recipt->receipt_pdf;
            $filename2 = 'target_file_receiving_surrogacyclinic_docs' . $timestamp . '_' . $filename;
            $sourcePath = "D:/xampp/htdocs/s_clinic_receipt_no/" . $filename;
            $baseDir = "D:/xampp/htdocs/artprojfiles/application_sa/";
            $application_no_folder= str_replace('/', '_', $recipt->applicationno);
            $fullFolderPath = $baseDir . $application_no_folder;
            $destinationPath = $fullFolderPath . '/' . $filename2;
            DocFilereceivedUpload::create([
                                        'userid'         => $recipt->userid,
                                        'app_id'         => $recipt->id,
                                        'doc_id'         => 31,
                                        'doc_type'       => 'target_file_receiving_surrogacyclinic_docs',
                                        'doc_upload_ref' => $filename2
                                        ]);
            if (!file_exists($fullFolderPath)) {
                    mkdir($fullFolderPath, 0777, true);
                }
                if (!file_exists($sourcePath)) {
                    Log::error("Reject copy skipped. File not found: " . $filename);
                    continue;
                }
                if (!copy($sourcePath, $destinationPath)) {
                    $error = error_get_last();
                    Log::error("Reject copy failed. From: $filename To: $destinationPath Error: " . print_r($error, true));
                    continue;
                }
            Log::error('clinic reciept with clinic id : ' . $recipt->id); 
            Log::error('clinic reciept with clinic sequence no: ' . $j);
            $j++;
        }
        DB::commit();
        return redirect()->back()->with('success', 'surrogacy Clinic Data imported successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('surrogacy Clinic Data import failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while importing data.');
    }
    
    
}

public function artbankimportdata()
{
    try {
        $results = DB::table('artbank_certificate_details')
                    ->get();
        $i = 5001;
        $j=0;
        DB::beginTransaction();
        foreach ($results as $result) {
        try{
        if($result->approved_rejected=='Registration Granted'){
            $filename = $result->reg_no_file;
            $filename2 = NULL;
            if($filename) {

            $timestamp = date('Y-m-d_His');
            $filename2 = 'target_file_reg_artbank_certificate' . $timestamp . '_' . $filename;

            $sourcePath = "D:/xampp/htdocs/art_bank_certificate/" . $filename;
            $baseDir = "D:/xampp/htdocs/artprojfiles/clinic_registration_certificate/";
            $fullFolderPath = $baseDir . $i;

            $destinationPath = $fullFolderPath . '/' . $filename2;

            // Insert into doc_file_uploads_registration_certificate
            DB::table('doc_file_uploads_registration_certificate')->insert([
                'userid' => $result->userid,
                'clinic_id' => $i,
                'doc_id' => 35,
                'doc_type' => 'target_file_reg_artbank_certificate',
                'doc_upload_ref' => $filename2,
            ]);
            if (!file_exists($fullFolderPath)) {
                    mkdir($fullFolderPath, 0777, true);
                }
                if (!file_exists($sourcePath)) {
                    continue;
                }

                if (!copy($sourcePath, $destinationPath)) {
                    continue;
                }
            }
            // Get artclinic data once
            $surrogacyclinic = DB::table('artbank')->where('status',1)->where('userid', $result->userid)->first();
            if (!$surrogacyclinic) continue;

            // Insert staff data
            $staffdata = DB::table('artbank_otherstaff')
                            ->where('userid', $result->userid)
                            ->where('artbank_id', $surrogacyclinic->id)
                            ->get();

            $insertStaff = [];
            foreach ($staffdata as $staff) {
                $insertStaff[] = [
                    'clinic_id' => $i,
                    'name' => $staff->name_otherstaff ?? null,
                    'post' => $staff->designation_otherstaff ?? null,
                    'qualification' => $staff->quali_otherstaff ?? null,
                    'application_no' => $surrogacyclinic->applicationno ?? null,
                    'status' => 1,
                    'clinic_type' => 'ARTBANK',
                    'type_emp' => 'ARTBANKSTAFF',
                    'created_at' => $staff->datetime,
                    'updated_at' => now(),
                    'validitydate' => now()
                ];
            }
            if (!empty($insertStaff)) {
                DB::table('tbl_clinic_staff')->insert($insertStaff);
            }
            $equipments = DB::table('artbank_equipment')
                            ->where('userid', $result->userid)
                            ->where('artbank_id', $surrogacyclinic->id)
                            ->get();
            
            $insertEquip = [];
            foreach ($equipments as $equip) {
                $insertEquip[] = [
                    'clinic_id' => (string) $i,
                    'equipmentname' => $equip->equipmentname,
                    'application_no' => $surrogacyclinic->applicationno ?? null,
                    'status' => 1,
                    'clinic_type' => 'ARTBANK',
                    'created_at' => $equip->datetime,
                    'updated_at' => now(),
                    'validitydate' => now()
                ];
            }
            if (!empty($insertEquip)) {
                DB::table('tbl_clinic_equipment')->insert($insertEquip);
            }

             $surrogacydata = [
                'name' => $surrogacyclinic->clinicname ?? null,
                'address' => $surrogacyclinic->address ?? null,
                'state' => $surrogacyclinic->state ?? null,
                'district' => $surrogacyclinic->district ?? null,
                'nature' => $surrogacyclinic->nature ?? null,
                'pincode' => $surrogacyclinic->pincode ?? null,
                'mobile' => $surrogacyclinic->contact_person_mobile ?? null,
                'email' => $surrogacyclinic->email ?? null,
                'contact_number_clinic' => $surrogacyclinic->contactno ?? null,
                'fax_number' => $surrogacyclinic->fax ?? null,
                'apply_registration' => null,
                'website' => $surrogacyclinic->website,
                'date_of_establishment' => $surrogacyclinic->dateestab,
                'clinic_reg_mpt' => $surrogacyclinic->mtpact ?? null,
                'clinic_reg_pcpndt' => $surrogacyclinic->pcpndtact ?? null,
                'clinic_director' => $surrogacyclinic->director ?? null,
                'iui_h_s' => $surrogacyclinic->iuih ?? null,
                'iui_d_s' => $surrogacyclinic->iuid ?? null,
                'ivf_et' => $surrogacyclinic->ivfet ?? null,
                'icsi' => $surrogacyclinic->icsi ?? null,
                'pgt' => $surrogacyclinic->pgt ?? null,
                'sperm_oocyte' => $surrogacyclinic->spermandoocyte ?? null,
                'any_other_procedure' => $surrogacyclinic->anyotherprocedure ?? null,
                'any_other_detail' => $surrogacyclinic->otherdetails ?? null,
                'ejaculation' => $surrogacyclinic->ejaculation ?? null,
                'electrojaculation' => $surrogacyclinic->electroejaculation ?? null,
                'processing_sperm' => $surrogacyclinic->processingsperm ?? null,
                'storage_sperm' => $surrogacyclinic->storagesperm ?? null,
                'oocyte_doner' => $surrogacyclinic->oocytedonor ?? null,
                'cryopreservation_of_sperm' => $surrogacyclinic->cryopreservation ?? null,
                'methode_of_freezing_of_sperm' => $surrogacyclinic->spermslow ?? null,
                'sperm_vitrification' => $surrogacyclinic->spermvitrification ?? null,
                'freezing_of_testicular_tissue' => $surrogacyclinic->tisticulartissue ?? null,
                'application_no' => $surrogacyclinic->applicationno ?? null,
                'registration_no' => $result->registration_no ?? null,
                'certificate_valid_date' => $result->validity_upto ?? null,
                'certificate_path' => $filename2 ?? null,
                'status' => 1,
                'clinic_type' => 'ARTBANK',
                'clinic_id' => $i,
                'userid_applicant' => $result->userid,
                'rgistration_date' => $result->date_reg ?? null,
                'state_authority_id' => Session::get('id') ?? null,
                'verify_certificate' => 1,
                'created_date' => now(),
                'update_date' => now(),
                'validitydate' => now(),
                'ip_address' => getHostByName(getHostName())
            ];
                  
            DB::table('clinic_registration')->insert($surrogacydata);
            
            Log::error('clinic registered with clinic id: ' . $i);
            $i++;
        }
        else if($result->approved_rejected=='Registration Rejected' && $result->reg_no_file){
            $timestamp = date('Y-m-d_His');
            $filename = $result->reg_no_file;
            $filename2 = 'target_file_artbank_rejected_certificate' . $timestamp . '_' . $filename;

            $sourcePath = "D:/xampp/htdocs/art_bank_certificate/" . $filename;
            $baseDir = "D:/xampp/htdocs/artprojfiles/application_sa/";
            $application_no_folder= str_replace('/', '_', $result->application_no);
            $fullFolderPath = $baseDir . $application_no_folder;

            $destinationPath = $fullFolderPath . '/' . $filename2;
            DB::table('artbank_certificate_details')
                ->where('userid', $result->userid) // 👈 your extra condition
                ->update(['reg_no_file' => $filename2]);

            if (!file_exists($fullFolderPath)) {
                    mkdir($fullFolderPath, 0777, true);
                }
                if (!file_exists($sourcePath)) {
                    Log::error("Reject copy skipped. File not found: " . $filename);
                    continue;
                }

                if (!copy($sourcePath, $destinationPath)) {
                    $error = error_get_last();
                    Log::error("Reject copy failed. From: $filename To: $destinationPath Error: " . print_r($error, true));
                    continue;
                }
            Log::error('clinic rejected with clinic id next to: ' . $i);
            Log::error('clinic rejected with reject sequence no: ' . $j);
            $j++;
        }
        
        }
        catch (\Exception $e) {
        
        Log::error('clinic registered with clinic id failed: ' . $i);
        Log::error('clinic rejection with clinic id failed: ' . $j);
        Log::error('clinic registered/rejection with clinic id failed: ' . $result->userid);
        Log::error('clinic registered/rejection with clinic id failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while importing data.');
        }
        }
        $recipts = DB::table('artbank')
                    ->where('status',1)
                    ->whereNotNull('receipt_pdf')
                    ->get();
        $j=0;
        foreach ($recipts as $recipt) {
            $timestamp = date('Y-m-d_His');
            $filename = $recipt->receipt_pdf;
            $filename2 = 'target_file_receiving_artbank_docs' . $timestamp . '_' . $filename;
            $sourcePath = "D:/xampp/htdocs/s_clinic_receipt_no/" . $filename;
            $baseDir = "D:/xampp/htdocs/artprojfiles/application_sa/";
            $application_no_folder= str_replace('/', '_', $recipt->applicationno);
            $fullFolderPath = $baseDir . $application_no_folder;
            $destinationPath = $fullFolderPath . '/' . $filename2;
            DocFilereceivedUpload::create([
                                        'userid'         => $recipt->userid,
                                        'app_id'         => $recipt->id,
                                        'doc_id'         => 32,
                                        'doc_type'       => 'target_file_receiving_artbank_docs',
                                        'doc_upload_ref' => $filename2
                                        ]);
            if (!file_exists($fullFolderPath)) {
                    mkdir($fullFolderPath, 0777, true);
                }
                if (!file_exists($sourcePath)) {
                    Log::error("Reject copy skipped. File not found: " . $filename);
                    continue;
                }
                if (!copy($sourcePath, $destinationPath)) {
                    $error = error_get_last();
                    Log::error("Reject copy failed. From: $filename To: $destinationPath Error: " . print_r($error, true));
                    continue;
                }
            Log::error('clinic reciept with clinic id : ' . $recipt->id); 
            Log::error('clinic reciept with clinic sequence no: ' . $j);
            $j++;
        }
        DB::commit();
        return redirect()->back()->with('success', 'art bank Data imported successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('art bank Data import failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while importing data.');
    }
    

}

}