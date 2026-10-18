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
use App\Models\ChangeAddress\DocFilereceivedUploadChangeAddress;
use App\Helpers\dashboardHelper;




class ClinicWithdrawalSAController extends Controller
{
    
    public function showClinicList($encryptedClinicType)
    {

        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }
        try {
            $clinicTypeValue = Crypt::decryptString($encryptedClinicType);
        } catch (\Exception $e) {
            abort(404, 'Invalid clinic type');
        }
        $clinicTypeValueaname =[
                'ARTSURROGACY' => 'Surrogacy Clinic Withdrawal Applications',
                'ARTCLINIC'    => 'ART Clinic Withdrawal Applications',
                'ARTBANK'      => 'ART Bank Withdrawal Applications',
        ];
        $userId = Session::get('id');
        $stateName = Session::get('state_name');
        // $surrogacy_data = ClinicWithdrawal::where('state', $stateName)->where('status', 1)->get();
        $applications = ClinicWithdrawal::where('clinic_type', $clinicTypeValue)->where('state', $stateName)->where('status', 1)->get();

        return view('clinic_withdrawal.clinic_ssa_list_reg', compact('applications', 'clinicTypeValue','clinicTypeValueaname'));
    }

    public function applicationSearch(Request $request, $clinicType)
    {
        if (!Session::has('id')) {
            return response()->json(['errorMessage' => 'Unauthorized access'], 403);
        }

        $applicationNo = $request->input('application_no');
        $stateName = Session::get('state_name');

        if (empty($applicationNo)) {
            return response()->json(['errorMessage' => 'Please enter application No.']);
        }

        $clinicTypeMap = [
            'artsurrogacy' => 'ARTSURROGACY',
            'artclinic' => 'ARTCLINIC',
            'artbank' => 'ARTBANK',
        ];

        $clinicTypeValue = $clinicTypeMap[strtolower($clinicType)] ?? null;

        if (!$clinicTypeValue) {
            return response()->json(['errorMessage' => 'Invalid clinic type']);
        }

        $results = ClinicWithdrawal::with('clinic')
            ->where('applicationno', 'like', "%{$applicationNo}%")
            ->where('state', $stateName)
            ->where('status', 1)
            ->get()
            ->map(function ($item) {

                $clinic = $item->clinic;
                return [
                    'id' => $item->id,
                    'applicationno' => $item->applicationno,
                    'status' => (int) $item->status,

                    'clinic_name' => $clinic->name ?? '',
                    'appstatus' => $item->appstatus ?? '',
                    'nature' => $clinic->nature ?? '',
                    'email' => $clinic->email ?? '',
                    'contactno' => $clinic->mobile ?? '',

                    'address' => $clinic->address ?? '',
                    'state' => $item->state,
                    'district' => $item->district,

                    'app_received_date' => $item->app_received_date,
                    'application_date' => $item->application_date,

                    'encrypted_id' => Crypt::encryptString($item->id),
                    'encrypted_clinic_id' => Crypt::encryptString($item->clinic_id),
                ];
            });             

        return response()->json($results);
    }

    public function withdrawalReg($encryptedClinicType, $encryptedId)
    {

        try {
            $id = Crypt::decryptString($encryptedId);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid or expired link.');
        }
       
        $application = ClinicWithdrawal::with('withdrawalDocuments')
            ->where('id', $id)
            ->first();

        if (!$application) {
            return redirect()
                ->route('clinic.clinicForm_list')
                ->with('error', 'Application not found.');
        }
        $data = [
            'application' => $application,
            'uploadDocs'  => $application->withdrawalDocuments, 
        ];

        $data['encryptedId'] = $encryptedId;
        return view('clinic_withdrawal.viewclinic_reg', $data);
    }
     
    public function submitWithdrawalReg(Request $request)
    {

        try {

            DB::beginTransaction();

            $status = trim($request->input('status'));

            $wdAppId = $request->input('id');
            $receivedForm = ClinicWithdrawal::findOrFail($wdAppId);

            $clinicType = strtoupper($receivedForm->clinic_type);

            // FILE MAP
            $fileMap = [
                'Approve' => 'approve_order_file',
                'Reject'  => 'rejection_order_file',
            ];

            $inputName = $fileMap[$status] ?? null;

            if (!$inputName) {
                return back()->with('success', 'Invalid status selected');
            }

            // VALIDATION
            $request->validate([
                'status' => 'required|in:Approve,Reject',

                'application_date' => 'required|date',

                'registration_no' => 'required_if:status,Approve',

                'app_received_date' => 'required|date',

                'date_rej' => 'nullable|required_if:status,Reject|date',

                // 'rejection_no' => 'required_if:status,Reject',

                $inputName => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            //UPDATE WITHDRAWAL
            ClinicWithdrawal::where('id', $wdAppId)->update([
                'appstatus' => $status === 'Approve' ? 'Approved' : 'Rejected',
                'registration_date' => $request->date_reg,
                'registration_no' => $request->registration_no,
                'app_received_date' => $request->app_received_date,
                'date_rej' => $request->date_rej,
                'rejection_no' => $request->rejection_no,
                'final_action_taken_by' => Session::get('id'),
                'final_action_takan_datetime' => now(),
                'approved_reject_ip' => request()->ip(),
                'final_action_taken_by' => Session::get('id'),
            ]);

            // FILE UPLOAD
            $this->handleFileUploads($request, $wdAppId);

            // CLINIC UPDATE (ONLY APPROVE)
            $this->insertWithdrawalData($request, $receivedForm);

            DB::commit();

            $message = ($status === 'Approve')
                ? 'Application approved successfully.'
                : 'Application rejected successfully.';

            return redirect()->route('withdrawal.sa.clinic_list', [
                'clinicType' => Crypt::encryptString($clinicType)
            ])->with('success', $message);

        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error('Validation error: ' . $e->getMessage() . ' @ ' . $e->getFile() . ':' . $e->getLine() . ':' . $wdAppId);
            throw $e;
        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('Withdrawal failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    private function handleFileUploads(Request $request, $sclinicId)
    {
        $application = ClinicWithdrawal::findOrFail($sclinicId);

        $statusMap = [
            'Approve' => 'approve_order',
            'Reject'  => 'rejection_order',
        ];

        $status = $statusMap[$request->status] ?? null;

        if (!$status) {
            return;
        }

        $inputName = $request->status === 'Approve'
            ? 'approve_order_file'
            : 'rejection_order_file';

        $file = $request->file($inputName);

        if (!$file || !$file->isValid()) {
            return;
        }

        $clinicType = strtolower(str_replace(' ', '_', $application->clinic_type));

        // Use existing folderpath helper
        $folder = folderpath('application_sa')
            . str_replace('/', '_', $application->applicationno);

        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0777, true);
        }

        $fileName = 'target_file_' .
            $status . '_' .
            $clinicType . '_withdrawal_' .
            now()->format('Y-m-d_His') . '.' .
            $file->getClientOriginalExtension();

        $file->move($folder, $fileName);

        $application->withdrawalDocuments()->updateOrCreate(
            [
                'document_type' => ucwords(str_replace('_', ' ', $inputName)),
            ],
            [
                'file_name'   => $fileName,
                'file_path'   => $folder . '/',
                'uploaded_by' => Session::get('id'),
            ]
        );
    }

    public function applicationViewAndPDF(Request $request, $encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid or expired link.');
        }
       
        $application = ClinicWithdrawal::with('withdrawalDocuments')
            ->where('id', $id)
            ->first();

        if (!$application) {
            return redirect()
                ->route('withdrawal.application_form', ['encryptedClinicId' => Crypt::encryptString($id)]);
        }

        $mode = $request->get('mode', '');
        $data = [
            'application' => $application,
            'uploadDocs'  => $application->withdrawalDocuments, 
            'mode'        => $mode
        ];

        if ($mode === 'pdf') {

            $pdf = PDF::loadView('clinic_withdrawal.application_view_pdf', $data)
                ->setPaper('a4', 'portrait');
           $filename = 'withdrawal_application_' . $application->clinic_id . '_' . date('d-m-Y') . '_' . time() . '.pdf';

            return $pdf->download($filename);
        }
        return view('clinic_withdrawal.sa_application_view', $data);
    }

    private function insertWithdrawalData($request, $receivedForm)
    {

        if (strtolower(trim($request->status)) !== 'approve') {
            return;
        }

       $clinic = ClinicRegistrationModel::where('clinic_id', $receivedForm->clinic_id)
            ->where('userid_applicant', $receivedForm->userid)
            ->where('status', 1)
            ->where('clinic_type', $receivedForm->clinic_type)
            ->latest('id')
            ->first();

        if (!$clinic) {
            throw new \Exception('Active clinic record not found.');
        }

        // deactivate old record
        $clinic->update([
            'status' => 0,
            'last_updated_by' => Session::get('id')
        ]);

        // replicate new record
        $newClinic = $clinic->replicate();

        $newClinic->application_no = $request->applicationno;
        $newClinic->application_type = 5;
        $newClinic->status = 2;

        $newClinic->timestamps = false;

        $newClinic->save();
    }
} 
