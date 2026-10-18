<?php 
namespace App\Http\Controllers;
use Exception;
use Carbon\Carbon;
use App\Mail\LoginOtp;
use App\Mail\NOCFormMail;
use App\Mail\UserRequest;
use App\Models\Noc\Nocforeigner;
use App\Models\Noc\UserNoc;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\clinic\signup;
use App\Models\DocFileForeignerUpload;
use App\Models\Admin\Noctable;
use App\Models\Admin\userTable;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\Userforgetpassword;
use App\Models\ApplicantProfile;
use App\Models\clinic\BankModel;
use App\Models\Noc\countrytable;
use App\Models\Noc\requesttable;
use App\Models\Noc\verifiedtable;
use App\Models\Noc\docmastertable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\clinic\ArtClinicModel;

//add on 18-12-2024
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\ArtClinicRequest;
use Illuminate\Support\Facades\Session;
use App\Models\clinic\BankEquipmentModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log as log;

use Illuminate\Contracts\Encryption\DecryptException;




class NocForiegnerController extends Controller
{

    

    private function handleFileUploads(Request $request, $nocForm)
    {
        //$allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
        $allowedExtensions = ['pdf'];
        $docMasters = DB::table('doc_masters')
            ->whereIn('doc_type', [
                            'target_file_affidavit_embryos_outside',
                            'target_file_affidavit_gametes_outside',
                            'target_file_affidavit_embryos_within',
                            'target_file_affidavit_gametes_within',
                            'target_file_affidavit_clinic_holding_embryos',
                            'target_file_affidavit_clinic_holding_gametes',
                            'target_file_affidavit_clinic_receiving_embryos',
                            'target_file_affidavit_clinic_receiving_gametes',
                            'target_file_copy_aadhar',
                            'target_file_copy_passport',
                            'target_file_copy_aadhar_card_spouse',
                            'target_file_copy_passport_spouse',
                            'target_file_ssn',
                            'target_file_dob_proof_applicant',
                            'target_file_dob_proof_spouse',
                            'target_file_declaration_applicant',
                            'target_file_other_docs',
                            'target_file_sign_applicant',
                            'target_file_sign_spouse',
                            'copy_of_identity_proof_applicant',
                            'copy_of_identity_proof_spouse',
                            'oci_applicant_file',
                            'oci_spouse_file',
            ])
            ->where('status', 1)
            ->select('doc_type', 'status', 'doc_desc', 'id', 'doc_master_id')
            ->get();

    
        $User = $this->getUserdata();

      //  dd($docMasters);

        //target_file_affidavit_embryos_outside

        foreach ($docMasters as $docMaster) {
            // Generate the file key based on the doc type
            $fileKey = str_replace('target_file_', '', $docMaster->doc_type);

            // Check if the file exists for this document type
            if ($request->hasFile($fileKey)) {

                $file = $request->file($fileKey);
                $extension = $file->getClientOriginalExtension();

                if (in_array(strtolower($extension), $allowedExtensions)) {
                    $filename = $docMaster->doc_type . '-' . Carbon::now()->timestamp . '.' . $extension;
                    //$destinationPath = 'C:/xampp/htdocs/noc_documents';
                    $destinationPath = 'C:/xampp/htdocs/noc_documents';
                    // Store the file in the 'noc_documents' directory in the public disk
                    $filePath = $file->move($destinationPath, $filename);
                    //dd($filePath);
                    //error_log("......................................................".$filename);
                    $dbpath = $filename;

                    

                    DocFileForeignerUpload::create([
                            'noc_user_id' => $User->id,
                            'app_id' => $nocForm->id,
                            'doc_id' => $docMaster->id,
                            'doc_type' => $docMaster->doc_type,
                            'upload_desc' => $docMaster->doc_desc,
                            'doc_master_id_ref' => $docMaster->doc_master_id,
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

    public function nocforeignerapplicationform(Request $request)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('noc.loginnocform');
        }

        $countries = countrytable::all();
        $email = $request->session()->get('email');
        $user = requesttable::where('email', $email)->first();

        $get_id = Session::get('id');
        //dd($get_id);
        // Fetch the user profile based on the user ID
        $user_profile = ApplicantProfile::where('noc_userid', $get_id)->first();
        //dd($user_profile);
        // Check if the user profile is empty or incomplete
        // Check if the user profile exists and if the profile is updated
        if (!$user_profile) {
            // If no user profile exists, redirect to the profile update page
            return redirect()->route('noc.profile.update')->with('success', 'Please complete your profile before proceeding to the application form.');
        }

        // Check if the profile is updated, if not, prompt user to update it
        if ($user_profile) {
            return view('layouts/noc/add_noc_foreiner_app_form', ['tab' => $request->input('tab', 1), 'countries' => $countries, 'requesttable' => $user], compact('user_profile'));
        }
    }

    private function generateApplicationNo($latestForm, $transfer, $transferOf, $purposeOfTransfer)
    {
        $year = Carbon::now()->year;
        $prefix = 'NOC';

        // Check transfer type (Within India or Outside India)
        if ($transfer === 'Within India') {
            $transferPrefix = 'WI';
        } elseif ($transfer === 'Outside India') {
            $transferPrefix = 'Exp'; // "Exp" for Export (Outside India)
        } else {
            throw new Exception("Invalid transfer type provided.");
        }

        // Define transfer_of prefix for multiple values
        $transferOfMapping = [
            'Embryos' => 'Emb',
            'Sperms' => 'S',
            'Oocytes' => 'O',
        ];

        if (is_array($transferOf)) {
            $transferOfPrefix = array_map(function ($item) use ($transferOfMapping) {
                return $transferOfMapping[$item] ?? throw new Exception("Invalid transfer_of value: $item");
            }, $transferOf);

            $transferOfPrefix = implode('-', $transferOfPrefix);
        } else {
            throw new Exception("transfer_of must be an array.");
        }

        // Define purpose_of_transfer suffix
        $purposeSuffix = match ($purposeOfTransfer) {
            'Invitro Fertilization' => 'IVF',
            'Surrogacy' => 'Surrogacy',
            'Future Cryopreservation' => 'Cry',
            default => throw new Exception("Invalid purpose_of_transfer value provided."),
        };

        // Generate serial number
        if ($latestForm) {
            $ano = $latestForm->application_no;
            $serialNumber = (int)substr($ano, -7, 3) + 1; // Extract and increment last 3 digits of serial number
            $serialNumber = str_pad($serialNumber, 3, '0', STR_PAD_LEFT);
        } else {
            $serialNumber = '001'; // Start at 001 if no previous record exists
        }

        // Combine to form the application number
        return "{$prefix}/{$transferPrefix}/{$transferOfPrefix}/{$year}/{$purposeSuffix}/{$serialNumber}-DHR";
    }

    public function submitForm(Request $request)
    {

   // dd($request['transfer_of']);

   $validator = Validator::make($request->all(), [
       
    'name_applicant'                       => 'required|string',
    'gender'                               => 'required|string',
    'nationality_applicant'                => 'required|string',
    'm_status'                             => 'required|string',
    'gender_sp'                            => 'required_if:m_status,married|nullable',
    'name_spouse'                          => 'required_if:m_status,married|nullable',
    'nationality_spouse'                   => 'required_if:m_status,married|nullable',
    'country_applicant_spouse'             => 'required_if:m_status,married|nullable',
    'email_spouse'                         => 'required_if:m_status,married|nullable',
    'mobile_spouse'                        => 'required_if:m_status,married|nullable',
    'voterid_spouse'                       => 'required_if:m_status,married|nullable',
    'passport_spouse'                      => 'required_if:m_status,married|nullable',
    'pan_spouse'                           => 'required_if:m_status,married|nullable',
    'oci_spouse'                           => '',
    'dob_spouse'                           => 'required_if:m_status,married|nullable',
    'identity_proof_applicant_spouse'      => 'required_if:m_status,married|nullable',
    'copy_aadhar_card_spouse'              => 'required_if:m_status,married|nullable',
    'copy_of_identity_proof_spouse'        => 'required_if:m_status,married|nullable',
                         
    'country_applicant'                    => 'required_if:nationality_applicant,Foreigner|nullable',
    'zipcode'                              => '',
    'address'                              => 'required',
    'pincode'                              => 'required_if:nationality_applicant,Indian|integer|nullable',
    'state'                                => 'required_if:nationality_applicant,Indian|nullable',
    'district'                             => 'required_if:nationality_applicant,Indian|nullable',
    'mobileno'                             => 'required',
    'email'                                => 'required|email',
    'transfer'                             => 'required|string',
    'transfer_of'                          => 'required|array|min:1',
    'embryos_number'                       => 'required_if:transfer_of,1|nullable',
    'sperm_vials'                          => 'required_if:transfer_of,1|nullable',
    'oocytes_number'                       => 'required_if:transfer_of,1|nullable',
    'purpose_of_transfer'                  => 'required|string',

    'dob_applicant'                        => [
                function ($attribute, $value, $fail) use ($request) {
                            if(!empty($value)){
                                $date1 = Carbon::now();
                                $date2 = Carbon::parse($value);
                                $year = $date1->diffInYears($date2);
                                      
                                      $arr = $request['transfer_of'];
                                      //dd($arr);
                                      if (in_array("Embryos", $arr)) {

                                          $Embryos = 'Embryos';

                                      }else if(in_array("Sperms", $arr)){
                                          
                                          $Sperms = 'Sperms';

                                      }else if(in_array("Oocytes", $arr)){

                                          $Oocytes = 'Oocytes';

                                      }

                                    if($request['gender'] == 'Man' && ($request['m_status'] == 'Divorced' || $request['m_status'] == 'Unmarried' || $request['m_status'] == 'Widow') && $request['nationality_applicant'] == 'Foreigner' && $request['transfer'] == 'Outside India' && ($request['purpose_of_transfer'] == 'Future Cryopreservation' || $request['purpose_of_transfer'] == 'Invitro Fertilization' || $request['purpose_of_transfer'] == 'Surrogacy') && !empty($Sperms) == 'Sperms'){
                                        if ($year < 11 || $year > 99) {
                                            $fail("Age of applicant should be Valid");
                                            
                                        }
                                    }else if($request['gender'] == 'Man' && $request['m_status'] == 'Married'  && $request['nationality_applicant'] == 'Indian' && $request['nationality_spouse'] == 'Foreigner' && $request['transfer'] == 'Outside India' && ($request['purpose_of_transfer'] == 'Surrogacy' || $request['purpose_of_transfer'] == 'Invitro Fertilization' || $request['purpose_of_transfer'] == 'Future Cryopreservation') && (!empty($Sperms) == 'Sperms' || !empty($Embryos) == 'Embryos' || !empty($Oocytes) == 'Oocytes')){
                                        if ($year < 11 || $year > 99) {
                                            $fail("Age of applicant should be Valid");
                                            
                                        }
                                    }else if($request['gender'] == 'Man' && $request['m_status'] == 'Married'  && $request['nationality_applicant'] == 'Foreigner' && $request['nationality_spouse'] == 'Indian' && $request['transfer'] == 'Outside India' && ($request['purpose_of_transfer'] == 'Surrogacy' || $request['purpose_of_transfer'] == 'Invitro Fertilization' || $request['purpose_of_transfer'] == 'Future Cryopreservation') && (!empty($Sperms) == 'Sperms' || !empty($Embryos) == 'Embryos' || !empty($Oocytes) == 'Oocytes')){
                                        if ($year < 11 || $year > 99) {
                                            $fail("Age of applicant should be Valid");
                                            
                                        }
                                    }else if($request['gender'] == 'Man' && $request['m_status'] == 'Married'  && $request['nationality_applicant'] == 'Foreigner' && $request['nationality_spouse'] == 'Foreigner' && $request['transfer'] == 'Outside India' && ($request['purpose_of_transfer'] == 'Surrogacy' || $request['purpose_of_transfer'] == 'Invitro Fertilization' || $request['purpose_of_transfer'] == 'Future Cryopreservation') && (!empty($Sperms) == 'Sperms' || !empty($Embryos) == 'Embryos' || !empty($Oocytes) == 'Oocytes')){
                                        if ($year < 11 || $year > 99) {
                                            $fail("Age of applicant should be Valid");
                                            
                                        }
                                    }else if($request['gender'] == 'Woman' && $request['m_status'] == 'Unmarried'  && $request['nationality_applicant'] == 'Foreigner' && $request['transfer'] == 'Outside India' && ($request['purpose_of_transfer'] == 'Surrogacy' || $request['purpose_of_transfer'] == 'Invitro Fertilization' || $request['purpose_of_transfer'] == 'Future Cryopreservation') && (!empty($Embryos) == 'Embryos' || !empty($Oocytes) == 'Oocytes')){
                                        if ($year < 11 || $year > 99) {
                                            $fail("Age of applicant should be Valid");  
                                        }
                                    }else if($request['gender'] == 'Woman' && ($request['m_status'] == 'Widow' || $request['m_status'] == 'Divorced' )  && $request['nationality_applicant'] == 'Foreigner' && $request['transfer'] == 'Outside India' && ($request['purpose_of_transfer'] == 'Surrogacy' || $request['purpose_of_transfer'] == 'Invitro Fertilization' || $request['purpose_of_transfer'] == 'Future Cryopreservation') && (!empty($Sperms) == 'Sperms' || !empty($Embryos) == 'Embryos' || !empty($Oocytes) == 'Oocytes')){
                                        if ($year < 11 || $year > 99) {
                                            $fail("Age of applicant should be Valid");
                                            
                                        }
                                    }else if($request['gender'] == 'Woman' && $request['m_status'] == 'Married'  && $request['nationality_applicant'] == 'Indian' && $request['nationality_spouse'] == 'Foreigner' && $request['transfer'] == 'Outside India' && ($request['purpose_of_transfer'] == 'Surrogacy' || $request['purpose_of_transfer'] == 'Invitro Fertilization' || $request['purpose_of_transfer'] == 'Future Cryopreservation') && (!empty($Sperms) == 'Sperms' || !empty($Embryos) == 'Embryos' || !empty($Oocytes) == 'Oocytes')){
                                        if ($year < 11 || $year > 99){
                                            $fail("Age of applicant should be Valid");
                                        }
                                    }else if($request['gender'] == 'Woman' && $request['m_status'] == 'Married'  && $request['nationality_applicant'] == 'Foreigner' && $request['nationality_spouse'] == 'Indian' && $request['transfer_val'] == 'Outside India' && ($request['purpose_of_transfer'] == 'Surrogacy' || $request['purpose_of_transfer'] == 'Invitro Fertilization' || $request['purpose_of_transfer'] == 'Future Cryopreservation') && (!empty($Sperms) == 'Sperms' || !empty($Embryos) == 'Embryos' || !empty($Oocytes) == 'Oocytes')){
                                        if ($year < 11 || $year > 99) {
                                            $fail("Age of applicant should be Valid");
                                            
                                        }
                                    }else if($request['gender'] == 'Woman' && $request['m_status'] == 'Married'  && $request['nationality_applicant'] == 'Foreigner' && $request['nationality_spouse'] == 'Foreigner' && $request['transfer'] == 'Outside India' && ($request['purpose_of_transfer'] == 'Surrogacy' || $request['purpose_of_transfer'] == 'Invitro Fertilization' || $request['purpose_of_transfer'] == 'Future Cryopreservation') && (!empty($Sperms) == 'Sperms' || !empty($Embryos) == 'Embryos' || !empty($Oocytes) == 'Oocytes')){
                                        if ($year < 11 || $year > 99) {
                                            $fail("Age of applicant should be Valid");
                                            
                                        }
                                    }else{
                                            if (empty($value)){
                                            $fail('Date of birth of applicant is required.');
                                            }
                                    } 
                           }
                 }         
         ],

    'passport_applicant'                   => '',
    'voterid_applicant'                    => '',
    'pan_applicant'                        => '',
    'aadhar_applicant'                     => '',
    'oci_applicant'                        => '',
    'oci_applicant_file'                   => '',
    'oci_applicant_spouse'                 => '',
    'country'                              => '',
    
    'status_clinic'                        => '',
    'status_from_clinic'                   => '',
    'to_status_clinic'                     => '',
    'from_name_clinic'                     => '',
    'from_name_clinic1'                    => '',

    'from_doctor'                          => '',
    'to_doctor'                            => '',
    'from_name_clinic2'                    => '',
    'from_address'                         => '',
    'f_pincode'                            => '',
    'f_state'                              => '',
    'f_district'                           => '',
    'f_contact'                            => '',
    'f_email'                              => '', 
    'to_address'                           => '',
    't_pincode'                            => '',
    't_state'                              => '',
    't_district'                           => '',
    't_contact'                            => '',
    't_email'                              => '',
    'identity_proof_applicant'             => '',

    // 'from_doctor'                          => 'required|string',
    // 'to_doctor'                            => 'required|string',
    // 'from_name_clinic2'                    => 'required_if:status_from_clinic,Not Registered|nullable',
    // 'from_address'                         => 'required_if:status_from_clinic,Not Registered|nullable',
    // 'f_pincode'                            => 'required_if:status_from_clinic,Not Registered|nullable',
    // 'f_state'                              => 'required_if:status_from_clinic,Not Registered|nullable',
    // 'f_district'                           => 'required_if:status_from_clinic,Not Registered|nullable',
    // 'f_contact'                            => 'required_if:status_from_clinic,Not Registered|nullable',
    // 'f_email'                              => 'required_if:status_from_clinic,Not Registered|nullable', 
    // 'to_address'                           => 'required_if:transfer,Outside India|nullable',
    // 't_pincode'                            => 'required_if:transfer,Within India|nullable',
    // 't_state'                              => 'required_if:transfer,Within India|nullable',
    // 't_district'                           => 'required_if:transfer,Within India|nullable',
    // 't_contact'                            => 'required_if:transfer,Outside India|nullable',
    // 't_email'                              => 'required_if:transfer,Outside India|nullable',
    // 'identity_proof_applicant'             => '',
    
    'affidavit_embryos_outside'            => [ 
                                                function ($attribute, $value, $fail) use ($request) {
                                                    if(!empty($request['transfer_of'][0]) == 'Embryos' && $request['transfer'] == 'Outside India'){
                                                        if(empty($value)){
                                                        $fail("Please upload this file affidavit_embryos_outside!");
                                                    }

                                                }
                                                }
                                            ],
    'affidavit_gametes_outside'            => [ 
                                                function ($attribute, $value, $fail) use ($request) {
                                                        if(!empty($request['transfer_of'][0]) == 'Sperms' && $request['transfer'] == 'Outside India'){
                                                            if(empty($value)){
                                                            $fail("Please upload this file affidavit_embryos_outside!");
                                                        }

                                                    }
                                                    }
                                                ],
    'affidavit_embryos_within'             => [ 
                                                function ($attribute, $value, $fail) use ($request) {
                                                        if(!empty($request['transfer_of'][0]) == 'Embryos' && $request['transfer'] == 'Within India'){
                                                            if(empty($value)){
                                                            $fail("Please upload this file affidavit_embryos_within!");
                                                        }

                                                    }
                                                    }
                                                ],
    'affidavit_gametes_within'             => [ 
                                                function ($attribute, $value, $fail) use ($request) {
                                                if((!empty($request['transfer_of'][1]) == 'Sperms' || !empty($request['transfer_of'][2]) == 'Oocytes') && $request['transfer'] == 'Within India'){
                                                    if(empty($value)){
                                                    $fail("Please upload this file affidavit_gametes_within!");
                                                }

                                            }
                                            }
                                        ],
    'affidavit_clinic_holding_embryos'     => [ 
                                                function ($attribute, $value, $fail) use ($request) {
                                                        if(!empty($request['transfer_of'][0]) == 'Embryos' && ($request['transfer'] == 'Within India' || $request['transfer'] == 'Outside India')){
                                                                if(empty($value)){
                                                                $fail("Please upload this file affidavit_clinic_holding_embryos!");
                                                            }

                                                        }
                                                }
                                                ],
    'affidavit_clinic_holding_gametes'     => [ 
                                                function ($attribute, $value, $fail) use ($request) {
                                                    if((!empty($request['transfer_of'][1]) == 'Sperms' || !empty($request['transfer_of'][2]) == 'Oocytes')  && ($request['transfer'] == 'Within India' || $request['transfer'] == 'Outside India')){
                                                            if(empty($value)){
                                                            $fail("Please upload this file affidavit_clinic_holding_gametes!");
                                                        }

                                                    }
                                                }
                                            ],
    'affidavit_clinic_receiving_embryos'   => [ 
                                                function ($attribute, $value, $fail) use ($request) {
                                                    if(!empty($request['transfer_of'][0]) == 'Embryos' && ($request['transfer'] == 'Within India' || $request['transfer'] == 'Outside India')){
                                                        if(empty($value)){
                                                        $fail("Please upload this file affidavit_clinic_receiving_embryos!");
                                                    }

                                                }
                                                }
                                            ],
    'affidavit_clinic_receiving_gametes'   => [ 
                                                function ($attribute, $value, $fail) use ($request) {
                                                    if((!empty($request['transfer_of'][1]) == 'Sperms' || !empty($request['transfer_of'][2]) == 'Oocytes')  && ($request['transfer'] == 'Within India' || $request['transfer'] == 'Outside India')){
                                                        if(empty($value)){
                                                        $fail("Please upload this file affidavit_clinic_receiving_gametes!");
                                                    }

                                                }
                                                }
                                            ],
    'copy_passport'                        => '', 
    'ssn'                                  => '',
    
    'sign_applicant'                       => 'required',
    'dob_proof_applicant'                  => 'required',
    'dob_proof_ap'                         => 'required',
    'copy_of_identity_proof_applicant'     => 'required_if:m_status,married|nullable'

]);

 

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }



        // Start the transaction
        DB::beginTransaction();

        try {
          DB::enableQueryLog();
            $User = $this->getUserdata();
            $data = $request->all();
            // Generate the application number first
            $latestForm = Nocforeigner::orderBy('created_at', 'desc')->first(); // Retrieve the latest record

            $transfer = $request->transfer; // "Within India" or "Outside India"
            $transferOf = $request->transfer_of; // Array e.g., ["Embryos", "Sperms"]
            $purposeOfTransfer = $request->purpose_of_transfer; // Purpose like "Surrogacy", etc.
            // Generate the application number
            $application_no = $this->generateApplicationNo($latestForm, $transfer, $transferOf, $purposeOfTransfer);
            // Prepare the data for insertion            
            $data['transfer_of'] = implode(',', $request->transfer_of);
            $data['application_no'] = $application_no;  // Assign the generated application number

            $data['noc_userid'] = $User->id;  // Assign the generated application number         

            $emailDetails = [
                'name_applicant' => $data['name_applicant'],
                //'transfer_type' => $transfer,
                'application_no' => $application_no,
            ];

            Mail::to($data['email'])->send(new NOCFormMail($emailDetails));
            $latestForm = new Nocforeigner($data); // Create a new instance with the data
            $latestForm->save(); 

            $this->handleFileUploads($request, $latestForm);

            $appId = $latestForm->id;
            $service_id = 6;
            $level_id = 1;
            $action_taken_by = 'Submitted By User';
            $is_active = 'Yes';
            $remarks = 'user application submitted';
            $get_userid = nextActor($level_id, $appId, $service_id);
  
            DB::table('work_flow_table')->insert([
                'application_id'   => $latestForm->id,
                'service_id'       => $service_id,
                'level_id'         => $level_id,
                'user_id'          => $get_userid,
                'remarks'          => $remarks,
                'is_active'        => $is_active,
                'action_taken_by'  => $action_taken_by,
                'submission_date'  => Carbon::now()->format('Y-m-d H:i:s'),
            ]);


            DB::commit();

            return redirect()->route('noc.nocForm_list')
                ->with('success', 'Application No: ' . $application_no . ' Your Application has been successfully Submitted !');
            return redirect()->route('noc.nocForm_list')->with('success', $application_no);
        } catch (\Exception $e){
            // In case of an error, rollback the transaction
            DB::rollBack();
            dd($e->getMessage());
            // Optionally log the error
            log::error("Error inserting data: " . $e->getMessage());

            return redirect()->route('noc.add_noc_foreigner_app_form')->with('error', 'Failed to insert data!');
        }
    }


    public function nocForm_list_foriener()
    {

        $url = url('/');
        $parsed_url = parse_url($url);
        $newUrl = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        $baseUrl = "$newUrl/noc_documents/";
        if (empty(Session::has('id'))) {
            return redirect()->route('noc.loginnocform');
        }

        $userId = Session::get('id');

        $data = new UserNoc();
        $nocformList = $data->myapplication_foreigner($userId);
       

        return view('layouts.noc.noc_form_foreigner_list', compact('nocformList', 'baseUrl'));
    }


    public function nocFormnocFormForeigner_view($id)
    {
         ;

        if (empty(Session::has('id'))) {
            return redirect()->route('noc.loginnocform');
        }

        try {

            $decryptedId = Crypt::decrypt($id);
            $application = Nocforeigner::findOrFail($decryptedId);
            $app_id = $application->id;


            $clinicIds = [$application->from_name_clinic, $application->from_name_clinic1, $application->to_name_clinic2];
            $clinicNames = DB::table('signup')
                ->whereIn('id', $clinicIds)
                ->pluck('clinicname', 'id');
                
            $fromClinicName  = $clinicNames[$application->from_name_clinic] ?? null;
            $fromClinicName1 = $clinicNames[$application->from_name_clinic1] ?? null;
            $fromClinicName2 = $application->from_name_clinic2 ?? null;
            $toClinicName    = $clinicNames[$application->to_name_clinic]   ?? null;
            $toClinicName1   = $clinicNames[$application->to_name_clinic1]  ?? null;
            $toClinicName2   = $application->to_name_clinic2  ?? null;
          

            $countryIds = [$application->country]; // IDs to fetch
            $countryNames = DB::table('apps_countries')
                ->where('id', $countryIds)
                ->pluck('country_name', 'id'); // Retrieve clinic names with IDs as keys

            $CountryName = $countryNames[$application->country] ?? null;

            $dataDocMaster = DB::table('doc_masters')
                ->select('doc_masters.*')
                ->whereIn('doc_type', [
                    'upload_comp_institute_denied_export',
                    'sending_bg_comp_inst',
                    'receiving_bg_comp_inst',
                    'details_planned_analysis',
                    'biomaterial_micro_organisms_approval_file',
                    'ibsc_rcgm_approval_applicable_file',
                    'certified_copy_proforma',
                    'declaration_letter'
                ])
                ->where('status', 1)
                ->get();

            if ($dataDocMaster->isNotEmpty()) {

                foreach ($dataDocMaster as $doc){
                    $doc_type = $doc->doc_type;
                    $doc_id = $doc->id;
                }
            }
          

            $get_docfileData = DB::table('doc_file_uploads_foreigner')
                ->where('doc_file_uploads_foreigner.app_id', $app_id)
                ->orderBy('doc_master_id_ref','ASC')
                ->get();
           // dd($get_docfileData);
            
            return view('layouts.noc.noc_form_foreigner', compact('application', 'get_docfileData', 'fromClinicName', 'fromClinicName1', 'fromClinicName2', 'toClinicName', 'toClinicName1', 'toClinicName2','CountryName'));
        } catch (DecryptException $e){
            abort(404, 'Invalid ID');
        }
    }

}