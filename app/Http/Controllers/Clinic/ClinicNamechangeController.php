<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\clinic\ClinicNameChangeApplication;
use App\Models\clinic\ClinicRegistrationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\clinic\ClinicNameChangeDocument;

class ClinicNamechangeController extends Controller
{

    public function change_name($encryptedClinicId)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = session('id');

        $clinic_id = Crypt::decryptString($encryptedClinicId);

        $clinic = ClinicRegistrationModel::where('clinic_id', $clinic_id)
            ->where('userid_applicant', $userId)
            ->where('status', 1)
            ->first();

        $application = ClinicNameChangeApplication::where('clinic_id', $clinic_id)->where('clinic_type', $clinic->clinic_type)->where('status', 0)->first();
        $pending_application = ClinicNameChangeApplication::where('clinic_id', $clinic_id)->where('clinic_type', $clinic->clinic_type)->where('status', 1)->where('appstatus', 'Pending')->first();


        $applicationDocuments = [];
        $isSubmitted = false;

        if ($application) {
            $application->declaration_date = now()->format('Y-m-d');
            $applicationDocuments = ClinicNameChangeDocument::where(
                'application_id',
                $application->id
            )
                ->orderBy('id')
                ->get();

            $resolution = $applicationDocuments
                ->where('document_type', 'mandatory_resolution')
                ->first();

            $gazette = $applicationDocuments
                ->where('document_type', 'mandatory_gazette')
                ->first();

            $otherDocuments = $applicationDocuments
                ->where('document_type', 'Other');
            // if ($application->status == 1) {

            //     $application = $clinic;

            //     $application->proposed_clinic_name = '';
            //     $application->name_change_effective_date = '';
            //     $application->reason_for_name_change = '';

            //     $applicationDocuments = [];
            // }

            $view = match (strtoupper($clinic->clinic_type)) {
                'ARTCLINIC' => 'layouts.clinic.change_name_form_artclinic',
                'ARTBANK' => 'layouts.clinic.change_name_form_artbank',
                'ARTSURROGACY' => 'layouts.clinic.change_name_form_artsurrogacy',
            };
            // $compact = compact('application', 'applicationDocuments', 'isSubmitted');
            $compact = compact(
                'application',
                'applicationDocuments',
                'resolution',
                'gazette',
                'otherDocuments',
                'isSubmitted'
            );
        } elseif ($pending_application) {
            $application = $pending_application;
            // $bladeView = match (strtoupper($application->clinic_type)) {
            //     'ARTSURROGACY' => 'layouts.clinic.change_name.surrogacy_application_view',
            //     'ARTBANK'      => 'layouts.clinic.change_name.artbank_application_view',
            //     'ARTCLINIC'    => 'layouts.clinic.change_name.artclinic_application_view',
            // };
            $bladeView = ('layouts.clinic.change_name.artclinic_application_view');


            return view($bladeView, compact(
                'application',
                'clinic'
            ));


            $compact = compact(
                'pending_application',
                'applicationDocuments',
                'isSubmitted'
            );
        } else {

            $application = $clinic;
            $applicationDocuments = collect();

            $resolution = null;
            $gazette = null;
            $otherDocuments = collect();
            $view = match (strtoupper($clinic->clinic_type)) {
                'ARTCLINIC' => 'layouts.clinic.change_name_form_artclinic',
                'ARTBANK' => 'layouts.clinic.change_name_form_artbank',
                'ARTSURROGACY' => 'layouts.clinic.change_name_form_artsurrogacy',
            };
            // $compact = compact('application',  'applicationDocuments');
            $compact = compact(
                'application',
                'applicationDocuments',
                'resolution',
                'gazette',
                'otherDocuments'
            );
        }
        return view('layouts.clinic.change_name_form_artclinic', $compact);
    }





    // private function handleFileUploads_clinicchange(Request $request, $appid)
    // {
    //     $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];


    //     if ($request->hasFile('documents')) {

    //         foreach ($request->file('documents') as $key => $file) {

    //             if ($file && $file->isValid()) {

    //                 $extension = strtolower($file->getClientOriginalExtension());


    //                 if (in_array($extension, $allowedExtensions)) {

    //                     $originalName = $file->getClientOriginalName();


    //                     $applicationNo = str_replace(
    //                         ['/', '\\', ' '],
    //                         '_',
    //                         $appid->application_no
    //                     );

    //                     $filename = $applicationNo .
    //                         '_document_' .
    //                         time() .
    //                         '-' . $key .
    //                         '.' . $extension;
    //                     $foldername = 'clinic_application';
    //                     $baseDir = folderpath($foldername);
    //                     $destinationPath = $baseDir . $applicationNo;

    //                     if (!File::exists($destinationPath)) {

    //                         File::makeDirectory($destinationPath, 0755, true);
    //                     }


    //                     $file->move($destinationPath, $filename);

    //                     $dbPath =  $filename;

    //                     DB::table('clinic_name_change_documents')->updateOrInsert(
    //                         [
    //                             'application_id' => $appid->id,
    //                             'document_type'  => $request->document_name[$key] ?? 'supporting_document',
    //                         ],
    //                         [
    //                             'file_path'          => $dbPath,
    //                             'original_file_name' => $originalName,
    //                             'created_at'         => now(),
    //                             'updated_at'         => now(),
    //                         ]
    //                     );
    //                     Log::info('File uploaded successfully', [
    //                         'file_name' => $filename
    //                     ]);
    //                 } else {

    //                     Log::warning('Invalid file extension', [
    //                         'extension' => $extension
    //                     ]);
    //                 }
    //             }
    //         }
    //     }
    // }


    private function handleFileUploads_clinicchange(Request $request, $appid)
    {
        $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
 
        if (!$request->hasFile('documents')) {
            return;
        }

        $applicationNo = str_replace(
            ['/', '\\', ' '],
            '_',
            $appid->application_no
        );

        $foldername = 'clinic_application';
        $baseDir = folderpath($foldername);
        $destinationPath = $baseDir . $applicationNo;

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        $files = $request->file('documents');

        foreach ($request->document_type as $key => $documentType) {

            $file = $files[$key] ?? null;

            // No new file selected -> do nothing
            if (!$file || !$file->isValid()) {
                continue;
            }

            $extension = strtolower($file->getClientOriginalExtension());

            if (!in_array($extension, $allowedExtensions)) {
                continue;
            }

            $documentTitle = $request->document_name[$key] ?? '';
            $originalName  = $file->getClientOriginalName();

            $filename = $applicationNo . '_' . $documentType . '_' . time() . '_' . $key . '.' . $extension;

            $file->move($destinationPath, $filename);

            $query = ClinicNameChangeDocument::where(
                'application_id',
                $appid->id
            );

            if ($documentType == 'Other') {
                $query->where('document_title', $documentTitle);
            } else {
                $query->where('document_type', $documentType);
            }

            $document = $query->first();

            if ($document) {

                $document->update([
                    'document_title'     => $documentTitle,
                    'file_path'          => $filename,
                    'original_file_name' => $originalName
                ]);
            } else {

                ClinicNameChangeDocument::create([
                    'application_id'     => $appid->id,
                    'document_type'      => $documentType,
                    'document_title'     => $documentTitle,
                    'file_path'          => $filename,
                    'original_file_name' => $originalName
                ]);
            }

            Log::info('File uploaded successfully', [
                'application_id' => $appid->id,
                'document_type'  => $documentType,
                'file_name'      => $filename,
            ]);
        }
    }

    public function submitChangeName(Request $request)
    {
        try {

            $action = $request->submit_type;
            $userId = Session::get('id');
            $draftRules = [
                'proposed_name' => ['nullable', 'string', 'max:255', 'different:clinic_name', 'regex:/^[A-Za-z0-9\s\'",.$()\[\]&-]+$/'],
                //'effective_date' => ['nullable', 'date', 'after_or_equal:today'],
                'reason' => ['nullable', 'string', 'max:500', 'regex:/^[A-Za-z0-9\s\'",.$()\[\]&\-\/:\r\n]+$/'],
                'document_name' => ['nullable', 'array'],
                'document_name.*' => ['nullable', 'string', 'max:150', 'regex:/^[A-Za-z0-9()\/&,\-.\s]+$/'],
                'documents.*' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:250'],
                'authorized_signatory_name' => ['nullable', 'string', 'max:150', 'regex:/^[A-Za-z\s\'",.$()\[\]&-]+$/'],
                'designation' => ['nullable', 'string', 'max:150', 'regex:/^[A-Za-z0-9\s\'",.$()\[\]&-]+$/'],
                'contact_number' => ['nullable', 'digits:10'],
                'declaration_date' => ['nullable', 'date'],
                'declaration' => ['nullable'],
            ];
            $submitRules = $draftRules;
            $submitRules['proposed_name'][0] = 'required';
            $submitRules['effective_date'][0] = 'required';
            $submitRules['reason'][0] = 'required';
            $submitRules['document_name'] = ['required', 'array', 'min:2'];
            $submitRules['document_name.*'][0] = 'required';
            

            if ($action == 'submit') {

                foreach ($request->document_name as $i => $name) {

                    $exists = ClinicNameChangeDocument::where('application_id', $request->application_id)
                        ->where('document_type', $request->document_type[$i] ?? null)
                        ->where('file_path', $request->document_path[$i] ?? null)
                        ->exists();
                     

                    // If old file doesn't exist and no new file uploaded for this row
                    if (!$exists && !$request->hasFile("documents.$i")) {
                        $submitRules["documents.$i"] = [
                            'required',
                            'file',
                            'mimes:pdf,jpg,jpeg,png',
                            'max:250',
                        ];
                    }
                }
                $submitRules['declaration'] = ['required', 'accepted'];
                $submitRules['effective_date'] = [
                    'required',
                    'date',
                    'after_or_equal:today',
                ];
            }

            $submitRules['authorized_signatory_name'][0] = 'required';
            $submitRules['designation'][0] = 'required';
            $submitRules['contact_number'][0] = 'required';
            $submitRules['declaration_date'][0] = 'required';
            $submitRules['declaration'][0] = ['accepted'];

            $messages = [
                'proposed_name.regex' => 'Proposed clinic name contains invalid characters.',
                'reason.regex' => 'Reason contains invalid characters.',
                'document_name.*.regex' => 'Document name contains invalid characters.',
                'authorized_signatory_name.regex' => 'Authorized Signatory Name contains invalid characters.',
                'designation.regex' => 'Designation contains invalid characters.',
                'declaration.accepted' => 'The declaration field must be accepted.',
            ];

            $request->validate(
                $action == 'submit' ? $submitRules : $draftRules,
                $messages
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error in name change module', [
                'error' => $e->validator->errors()->all(),
            ]);
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        }
        DB::beginTransaction();
        try {

            $clinic = ClinicRegistrationModel::where('clinic_id', $request->clinic_id)
                ->where('status', 1)
                ->first();

            $encryptedClinicId = Crypt::encryptString($request->clinic_id);

            if (!$clinic) {

                return redirect()
                    ->route('clinic.change-name', $encryptedClinicId)
                    ->with('error', 'Clinic not found.');
            }
            $changes = [];

            /*
            |--------------------------------------------------------------------------
            | String fields
            |--------------------------------------------------------------------------
            */
            $stringFields = [
                'registration_no',
                'name',
                'nature',
                'email',
                'address',
                'clinic_type',
                'state',
                'district',
            ];

            foreach ($stringFields as $field) {
                $oldValue = trim((string) ($clinic->$field ?? ''));
                $newValue = trim((string) ($request->$field ?? ''));

                if ($oldValue !== $newValue) {
                    $changes[$field] = [
                        'old' => $oldValue,
                        'new' => $newValue,
                    ];
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Integer fields
            |--------------------------------------------------------------------------
            */
            $integerFields = [
                'contact_number_clinic',
                'pincode',
            ];

            foreach ($integerFields as $field) {
                $oldValue = (int) ($clinic->$field ?? 0);
                $newValue = (int) ($request->$field ?? 0);

                if ($oldValue !== $newValue) {
                    $changes[$field] = [
                        'old' => $oldValue,
                        'new' => $newValue,
                    ];
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Date field
            |--------------------------------------------------------------------------
            */
            $oldDate = !empty($clinic->rgistration_date)
                ? Carbon::parse($clinic->rgistration_date)->format('Y-m-d')
                : null;

            $newDate = !empty($request->rgistration_date)
                ? Carbon::parse($request->rgistration_date)->format('Y-m-d')
                : null;

            if ($oldDate !== $newDate) {
                $changes['rgistration_date'] = [
                    'old' => $oldDate,
                    'new' => $newDate,
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | Check for modifications
            |--------------------------------------------------------------------------
            */
            if (!empty($changes)) {

                Log::warning('Clinic details modified.', [
                    'clinic_id' => $clinic->id,
                    'changes' => $changes,
                ]);

                return redirect()
                    ->route('clinic.change-name', $encryptedClinicId)
                    ->withInput()
                    ->with('error', 'Clinic details have been modified. Please refresh the page and try again.');
            }

            $lastApplication = ClinicNameChangeApplication::latest()->first();
            $su_id = DB::table('state')
                ->where('state_name', $clinic->state)
                ->orderBy('state_name')
                ->value('state_abb');
            $year = Carbon::now()->year;
            $clinic_type_abbr = $clinic->clinic_type == 'ARTSURROGACY' ? 'SC' : ($clinic->clinic_type == 'ARTBANK' ? 'AB' : 'AC');
            if ($lastApplication) {
                $ano = $lastApplication->application_no;
                $ano_sub = substr($ano, -5);
                $getnumbers = str_replace("/", "", $ano_sub);
                $no_increase = $getnumbers + 1;
                $get_string = str_pad($no_increase, 5, '0', STR_PAD_LEFT);
                $enumber = $su_id . '/' . $clinic_type_abbr . '/CN/' . $year . '/' . $get_string;
            } else {
                $enumber = $su_id . '/' . $clinic_type_abbr . '/CN/' . $year . '/10001';
            }




            $applicationData = [

                'clinic_id'                  => $request->clinic_id,
                'application_no'             => $enumber,

                'registration_no'            => $request->registration_no ?? '',
                'name'                       => $request->name ?? '',
                'clinic_type'                => $request->clinic_type ?? '',
                'nature'                     => $request->nature ?? '',
                'email'                      => $request->email ?? '',
                'contact_number_clinic'      => $request->contact_number_clinic ?? '',
                'rgistration_date'           => $request->rgistration_date ?? null,

                'address'                    => $request->address ?? '',
                'pincode'                    => $request->pincode ?? '',
                'state'                      => $request->state ?? '',
                'district'                   => $request->district ?? '',
                'level'                      => $request->level ?? '',

                'proposed_clinic_name'       => $request->proposed_name ?? '',
                'name_change_effective_date' => $request->effective_date ?? null,
                'reason_for_name_change'     => $request->reason ?? '',

                'authorized_signatory_name'  => $request->authorized_signatory_name ?? '',
                'designation'                => $request->designation ?? '',
                'contact_number'             => $request->contact_number ?? '',

                'declaration_accepted'       => $request->has('declaration') ? 1 : 0,
                'declaration_date'           =>  $request->declaration_date,


                'status'                     => ($action == 'submit') ? 1 : 0,
                'userid'                    =>  $userId,
            ];
            $updateData = [

                'application_no'             => $enumber,
                'proposed_clinic_name'       => $request->proposed_name ?? '',
                'name_change_effective_date' => $request->effective_date ?? null,
                'reason_for_name_change'     => $request->reason ?? '',
                'authorized_signatory_name'  => $request->authorized_signatory_name ?? '',
                'designation'                => $request->designation ?? '',
                'contact_number'             => $request->contact_number ?? '',
                'declaration_accepted'       => $request->has('declaration') ? 1 : 0,
                'declaration_date'           => $request->declaration_date ?? null,
                'status'                     => ($action == 'draft') ? 0 : 1,
                'updated_at'                 => now(),
            ];

            $draftRecord = ClinicNameChangeApplication::where('clinic_id', $request->clinic_id)
                ->where('clinic_type', $request->clinic_type)
                ->where('status', 0)
                ->first();
           // dd($draftRecord);



            if ($action == 'draft') {

                if ($draftRecord) {


                    $draftRecord->update($updateData);

                    $appData = $draftRecord;
                } else {


                    $appData = ClinicNameChangeApplication::create($applicationData);
                }
            } elseif ($action == 'submit') {

                if ($draftRecord) {

                    // Draft -> Submit
                    // $applicationData['application_no'] = $enumber;
                    // $applicationData['status'] = 1;
                    // $applicationData['declaration_accepted'] = 0;
                    // $applicationData['declaration_date'] = $request->declaration_date;

                    $draftRecord->update($applicationData);

                    $appData = $draftRecord;
                } else {


                    // $applicationData['application_no'] = $enumber;
                    // $applicationData['status'] = 1;
                    // $applicationData['declaration_accepted'] = 0;
                    // $applicationData['declaration_date'] = $request->declaration_date;

                    $appData = ClinicNameChangeApplication::create($applicationData);
                }
            }

            // File Upload
            if ($appData) {
               
                $this->handleFileUploads_clinicchange($request, $appData);
            }
            DB::commit();

            $encryptedClinicId = Crypt::encryptString($request->clinic_id);

            if ($action == 'draft') {
                return redirect()
                    ->route('clinic.change-name', $encryptedClinicId)
                    ->with('success', 'Draft saved successfully.');
            } else {
                return redirect()
                    ->route('clinic.clinicForm_list')
                    ->with('success', 'Application submitted successfully.');
            }
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Submit Change Name Error', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ]);

            $encryptedClinicId = Crypt::encryptString($request->clinic_id);

            return redirect()
                ->route('clinic.change-name', $encryptedClinicId)
                ->with('error', $e->getMessage());
        }
    }


    public function changeNameFormView($encryptedId)
    {

        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }
        try {
            $applicationId = Crypt::decryptString($encryptedId);
        } catch (\Exception $e) {

            abort(404, 'Invalid or expired link.');
        }

        $ssaId = false;
        if (Session::get('user_type') < 4) {
            $ses_id = Session::get('id');
        } elseif (Session::get('user_type') == 5) {

            $ssaId = Session::get('id');

            $ses_id = ClinicNameChangeApplication::where('id', $applicationId)
                ->where('state', Session::get('state_name'))
                ->where('status', 1);
        }



        $application = ClinicNameChangeApplication::where('id', $applicationId)
            ->where('status', 1)
            ->first();
        $clinic = ClinicRegistrationModel::where('clinic_id', $application->clinic_id)
            ->where('status', 1)
            ->first();

        // dd($clinic);
        if (!$application) {
            abort(404, 'Application not found.');
        }


        if ($ssaId) {

            $bladeView = ('layouts.clinic.change_name.artclinic_application_view_ssa');
        } else {

            $bladeView = ('layouts.clinic.change_name.artclinic_application_view');
        }

        return view($bladeView, compact(
            'application',
            'clinic'
        ));
    }
    public function deleteDocument(Request $request)
    {
        ClinicNameChangeDocument::where('id', $request->document_id)
            ->where('application_id', $request->application_id)
            ->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
