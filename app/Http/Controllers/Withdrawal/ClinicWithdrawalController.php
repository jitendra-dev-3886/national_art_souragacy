<?php

namespace App\Http\Controllers\Withdrawal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\clinic\signup;
use App\Models\clinic\ClinicRegistrationModel;
use App\Models\clinic\ClinicWithdrawal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;


class ClinicWithdrawalController extends Controller
{
    
    public function withdrawalClinicForm(Request $request, $encryptedClinicId)
    {

        try {
            $clinicId = Crypt::decryptString($encryptedClinicId);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid or expired link.');
        }

        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');

        $todayDate = Carbon::today()->toDateString();

        $clinicData = ClinicRegistrationModel::where([
            'clinic_id' => $clinicId,
            'userid_applicant' => $userId,
            'status' => 1
        ])->first();

        $draftData = ClinicWithdrawal::with('withdrawalDocuments')->where('clinic_id', $clinicId)
            ->where('userid', Session::get('id'))
            ->where('status', 0)
            ->where('appstatus', "Pending")
            ->latest('id')
            ->first();


        $existingData = ClinicWithdrawal::with('withdrawalDocuments')->where([
            'userid' => $userId,
            'clinic_id' => $clinicId,
            'appstatus' => 'Pending',
            'status' => 1
        ])->latest('id')->first();

        if ($existingData) {
            return redirect()->route('withdrawal.application_view', Crypt::encryptString($existingData->id));
        }

        // Draft exists - open editable form
        if ($draftData) {

            $encryptedAppId =  Crypt::encryptString($draftData->id);
               
            return view('clinic_withdrawal.withdrawal_application_form', [
                'clinic' => $clinicData,
                'draftData' => $draftData,
                'encryptedAppId' => $encryptedAppId,
                'encryptedClinicId' => $encryptedClinicId,
                'todayDate' => $todayDate
            ]);
        }
        
        return view('clinic_withdrawal.withdrawal_application_form', 
            ['clinic' => $clinicData, 
            'encryptedClinicId' => $encryptedClinicId,
            'todayDate' => $todayDate
        ]);
    }

    public function submitWithdrawal(Request $request, $encryptedClinicId)
    {

        try {

            DB::beginTransaction();

            $clinicId = Crypt::decryptString($encryptedClinicId);
            $userId = Session::get('id');

            if (!$userId) {
                return redirect()->route('clinic.loginclinicform');
            }

            $clinicData = ClinicRegistrationModel::where([
                'clinic_id' => $clinicId,
                'userid_applicant' => $userId,
                'status' => 1
            ])->first();

            if (!$clinicData) {
                return redirect()
                    ->route('withdrawal.application_form', $encryptedClinicId)
                    ->with('error', 'Clinic not found.');
            }

            $submitType = $request->input('submit_type', 'draft');
            $isFinal = ($submitType === 'submit');

            // EXISTING DRAFT
            $existing = ClinicWithdrawal::where([
                'clinic_id' => $clinicData->clinic_id,
                'userid' => $userId,
                'status' => 0
            ])->latest('id')->first();

            // VALIDATION (FINAL ONLY)
            if ($isFinal) {

                $rules = [
                    'application_date' => 'required|date',
                    'withdrawal_date' => 'required|date|after_or_equal:application_date',
                    'withdrawal_reason' => 'required|string|max:255',
                    'withdrawal_description' => 'required|string|max:500',
                    'authorized_signatory' => 'required|string|max:255',
                    'designation' => 'required|string|max:255',
                    'contact_no' => 'required|string|max:20',
                    'declaration_date' => 'required|date',
                    'declaration' => 'accepted',
                    'uploadremarks.*' => 'nullable|string|max:500',
                    'other_document.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                ];

                $withdrawal = $existing ?? new ClinicWithdrawal();

                $docs = $withdrawal->withdrawalDocuments ?? collect();

                if ($docs->where('document_type', 'Withdrawal letter')->isEmpty()) {
                    $rules['withdrawal_letter'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
                }

                if ($docs->where('document_type', 'Records transfer document')->isEmpty()) {
                    $rules['records_transfer_document'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
                }

                $request->validate($rules);
            }

            // APPLICATION NUMBER
            $lastApplication = ClinicWithdrawal::where('status', 1)
                ->latest()
                ->first();

            $stateCode = DB::table('state')
                ->where('state_name', $clinicData->state)
                ->value('state_abb');

            $clinicTypeCode = match ($clinicData->clinic_type) {
                'ARTSURROGACY' => 'SC',
                'ARTBANK'      => 'AB',
                default        => 'AC',
            };

            $year = now()->year;

            $nextNumber = 10001;

            if ($lastApplication && !empty($lastApplication->applicationno)) {
                $nextNumber = ((int) substr($lastApplication->applicationno, -5)) + 1;
            }

            $applicationNo = sprintf(
                '%s/%s/WD/%s/%05d',
                $stateCode,
                $clinicTypeCode,
                $year,
                $nextNumber
            );

            // Append revision for rejected applications
            if ($existing && $existing->appstatus === 'Rejected') {

                $revision = preg_match('/\/R(\d+)$/', $existing->applicationno, $matches)
                    ? ((int) $matches[1] + 1)
                    : 1;

                $applicationNo .= "/R{$revision}";
            }

            // DATA ARRAY
            $data = [
                'clinic_id'               => $clinicData->clinic_id,
                'registration_no'         => $clinicData->registration_no,
                'applicationno'           => $applicationNo,
                'clinic_type'             => $clinicData->clinic_type,
                'registration_date'       => $clinicData->registration_date,
                'address'                 => $clinicData->address,
                'pincode'                 => $clinicData->pincode,
                'state'                   => $clinicData->state,
                'district'                => $clinicData->district,
                'clinic_name'             => $clinicData->name,
                'userid'                  => $userId,

                'contact_no'              => $request->contact_no,

                'application_date'        => $request->application_date,
                'withdrawal_date'         => $request->withdrawal_date,
                'withdrawal_reason'       => $request->withdrawal_reason,
                'withdrawal_description'  => $request->withdrawal_description,
                'authorized_signatory'    => $request->authorized_signatory,
                'designation'             => $request->designation,
                'declaration_date'        => $request->declaration_date,
                'declaration'             => $request->has('declaration') ? 1 : 0,

                'status'                  => $isFinal ? 1 : 0,
                'appstatus'               => 'Pending',

                'applied_by_ip'           => $request->ip(),
                'applied_by_id'           => $userId,

                'created_by'              => $userId,
                'updated_by'              => $userId,
            ];
           

            // SAVE LOGIC
            if ($existing) {

                // If previous application is rejected/withdrawn, create a fresh record
                if (in_array($existing->appstatus, ['Rejected', 'Withdrawal'])) {

                    $withdrawal = ClinicWithdrawal::create($data);

                } else {

                    // Update existing draft
                    $existing->update($data);
                    $withdrawal = $existing;
                }

            } else {

                // First-time save
                $withdrawal = ClinicWithdrawal::create($data);
            }

            // FILE UPLOADS
            $this->handleFileUploads($request, $withdrawal->id);

            DB::commit();

            return $isFinal
                ? redirect()->route('withdrawal.application_view', $encryptedClinicId)
                    ->with('success', 'Application submitted successfully.')
                : redirect()->route('withdrawal.application_form', $encryptedClinicId)
                    ->with('success', 'Draft saved successfully.');

        } catch (ValidationException $e) {
            Log::error('Withdrawal Error serverside validation failed', [
                'message' => $e->getMessage()
            ]);
            return back()->withErrors($e->errors())->withInput();

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Withdrawal Error', [
                'message' => $e->getMessage()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Something went wrong.');
        }
    }

    private function handleFileUploads(Request $request, $withdrawalId)
    {
        $withdrawal = ClinicWithdrawal::find($withdrawalId);

        // dd($withdrawal);

        if (!$withdrawal) {
            Log::error("Withdrawal not found. ID: {$withdrawalId}");
            return;
        }

        $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];

        $documentFields = [
            'withdrawal_letter',
            'records_transfer_document',
            'other_document',
        ];
        $applicationFolder = str_replace('/', '_', $withdrawal->applicationno);

        $basePath = rtrim(folderpath('clinic_application'), '/\\');
        $fullPath = $basePath . DIRECTORY_SEPARATOR . $applicationFolder;

        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }

        // DB relative path
        $relativePath = str_replace('\\', '/', $basePath);
        $relativePath = substr($relativePath, strpos($relativePath, 'webprodfiles'));
        $relativePath .= '/' . $applicationFolder . '/';

        $remarks = $request->input('uploadremarks', []);
        $documentIds = $request->input('document_id', []);

        foreach ($documentFields as $field) {

            if (!$request->hasFile($field)) {
                continue;
            }

            $files = $request->file($field);
            $files = is_array($files) ? $files : [$files];

            foreach ($files as $i => $file) {

                if (!$file->isValid()) {
                    continue;
                }

                $extension = strtolower($file->getClientOriginalExtension());

                if (!in_array($extension, $allowedExtensions)) {
                    continue;
                }

                $isOther = ($field === 'other_document');

                $documentType = ucfirst(str_replace('_', ' ', $field));
                if ($isOther) {
                    $documentType .= '_' . ($i + 1);
                }

                $fileName = "target_file_{$field}";

                if ($isOther) {
                    $fileName .= "_{$i}";
                }

                $fileName .= "_"
                    . strtolower($withdrawal->clinic_type)
                    . "_"
                    . now()->format('Ymd_His')
                    . ".{$extension}";

               try {

                    $file->move($fullPath, $fileName);

                    $data = [
                        'document_type' => $documentType,
                        'file_name'     => $fileName,
                        'file_path'     => $relativePath,
                        'remarks'       => ($field == 'other_document') ? ($remarks[$i] ?? null) : null,
                        'uploaded_by'   => Session::get('id'),
                    ];

                    $id = match ($field) {
                        'withdrawal_letter' => $request->withdrawal_letter_id ?? null,
                        'records_transfer_document' => $request->records_transfer_document_id ?? null,
                        default => $documentIds[$i] ?? null,
                    };

                    $oldRecord = $id
                        ? $withdrawal->withdrawalDocuments()->find($id)
                        : null;

                    $model = $withdrawal->withdrawalDocuments()->updateOrCreate(
                        ['id' => $id],
                        $data
                    );

                    if ($oldRecord && $oldRecord->file_name) {

                        $oldFilePath = $fullPath . '/' . $oldRecord->file_name;

                        if (File::exists($oldFilePath)) {
                            File::delete($oldFilePath);
                        }
                    }
                } catch (\Throwable $e) {

                    Log::error('Withdrawal file upload failed', [
                        'withdrawal_id' => $withdrawalId,
                        'field'         => $field,
                        'file_name'     => $fileName,
                        'error'         => $e->getMessage(),
                    ]);
                }
            }
        }
    }

    public function applicationViewAndPDF(Request $request, $encryptedClinicId)
    {
        try {
            $id = Crypt::decryptString($encryptedClinicId);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid or expired link.');
        }

        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');
        $mode = $request->get('mode');

        $application = ClinicWithdrawal::with('withdrawalDocuments')
            ->where('id', $id)
            ->where('userid', $userId)
            ->first();

        if (!$application) {
            return redirect()->back()->with('error', 'Application not found.');
        }

        // If not submitted, redirect to form
        if ($application->appstatus == 'Withdrawal' && $application->status == 0) {
            return redirect()->route(
                'withdrawal.application_form',
                ['encryptedClinicId' => Crypt::encryptString($id)]
            );
        }

        $data = [
            'application' => $application,
            'uploadDocs' => $application->withdrawalDocuments ?? collect(),
            'mode' => $mode,
            'encryptedClinicId' => $encryptedClinicId
        ];

        // PDF MODE
        if ($mode === 'pdf') {

            $pdf = PDF::loadView('clinic_withdrawal.application_view_pdf', $data)
                ->setPaper('a4', 'portrait');

            $filename = 'withdrawal_application_' .
                $application->clinic_id . '_' .
                now()->format('d-m-Y_H-i-s') . '.pdf';

            return $pdf->download($filename);
        }
        return view('clinic_withdrawal.application_view', $data);
    }

    public function cancelRequest(Request $request)
    {
        try {

            $request->validate([
                'cancel_remarks' => 'required|string|max:1000',
            ]);

            $userId = Session::get('id');
            if (!$userId) {
                return redirect()->route('clinic.loginclinicform');
            }

           $withdrawal = ClinicWithdrawal::where('id', $request->application_id)->first();

            if (!$withdrawal) {
                return back()->with('error', 'Record not found');
            }

            $withdrawal->update([
                'cancel_remarks' => $request->cancel_remarks,
                'applied_by_ip' => request()->ip(),
                'appstatus' => 'Withdrawal',
                'applied_by_id' => Session::get('id'),
                'status' => 0,
                'updated_by' => Session::get('id'),
            ]);

            // return back()->with('success', 'Cancellation request submitted successfully.');
            // dd($withdrawal);
            return redirect()
                    ->route('withdrawal.application_form', Crypt::encryptString($withdrawal->clinic_id))
                    ->with('success', 'Cancellation request submitted successfully.');

        } catch (\Exception $e) {

            \Log::error('Cancel Request Error: ' . $e->getMessage());

            return back()->with('error', 'Something went wrong.');
        }
    }
}