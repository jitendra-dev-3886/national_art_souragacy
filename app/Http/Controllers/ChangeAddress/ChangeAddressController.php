<?php

namespace App\Http\Controllers\ChangeAddress;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\clinic\signup;
use App\Models\clinic\clinicStaffModel;
use App\Models\clinic\clinicDirectorModel;
use App\Models\clinic\ClinicEquipmentModel;
use App\Models\clinic\ClinicRegistrationModel;
use App\Models\ChangeAddress\ChangeAddressApplication;
use App\Models\ChangeAddress\ChangeAddressDirector;
use App\Models\ChangeAddress\ChangeAddressStaff;
use App\Models\ChangeAddress\ChangeAddressEquipment;
use App\Http\Requests\ChangeAddressRequest;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

use App\Models\clinic\SurrogacyClinicModel;
use App\Models\clinic\SurrogacyClinicOtherStaffModel;
use App\Models\clinic\BankModel;
use App\Models\clinic\ArtClinicModel;

use App\Models\clinic\ArtClinicOtherStaffModel;
use App\Models\clinic\BankOtherStaffModel;



class ChangeAddressController extends Controller
{
    public function changeAddressForm(Request $request, $encryptedClinicId)
    {
      
        try {
            $clinic_id = Crypt::decryptString($encryptedClinicId);
        } catch (\Exception $e) {
            return redirect()->route('clinic.loginclinicform')->with('error', 'Invalid or expired link.');        
        }

        if (!Session::has('id')) {
            return redirect()
                ->route('clinic.loginclinicform')
                ->with('error', 'Invalid or expired link.');
        }

        $userId = Session::get('id');
        $email = $request->session()->get('email');
        $check_user = signup::where('email', $email)->first();

        $clinic_data = ClinicRegistrationModel::where('clinic_id', $clinic_id)
            ->where('userid_applicant', $userId)
            ->where('status', 1)
            ->first();

        if (!$clinic_data) {
            return redirect()->back()->with('error', 'Clinic data not found.');
        }
 
        $draft_data = ChangeAddressApplication::where('userid', $userId)
            ->where('clinic_id', $clinic_id)
            ->where('status', 0)
            ->orderBy('id', 'desc')
            ->first();
        $existing_data = ChangeAddressApplication::where('userid', $userId)
            ->where('clinic_id', $clinic_id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->first();
        if ($draft_data) {
            $directors = ChangeAddressDirector::where('clinic_id', $clinic_id)
                ->where('application_id', $draft_data->id)
                ->get();
            $staff = ChangeAddressStaff::where('clinic_id', $clinic_id)
                ->where('application_id', $draft_data->id)
                ->get()
                ->toArray();

            $equipment = ChangeAddressEquipment::where('clinic_id', $clinic_id)
                ->where('application_id', $draft_data->id)
                ->get();

            if ($directors->isEmpty() && empty($staff) && $equipment->isEmpty()) {
                Log::info('First-time draft Change Address — loading data from main clinic tables.');
                $directors = clinicDirectorModel::where('clinic_id', $clinic_id)->get();
                $staff = clinicStaffModel::where('clinic_id', $clinic_id)->get();
                $equipment = ClinicEquipmentModel::where('clinic_id', $clinic_id)->get();
            }
            $view = match (strtoupper($clinic_data->clinic_type)) {
                'ARTCLINIC' => 'change_address.artclinic_application_form',
                'ARTSURROGACY' => 'change_address.surrogacy_application_form',
                'ARTBANK' => 'change_address.artbank_application_form',
            };
            $encryptedAppId = !empty($existing_data) ? Crypt::encryptString($existing_data->id) : NULL ;
            $fees = $existing_data->fee_amount ?? '';
            $reject = $existing_data->appstatus ?? ''; 
            return view($view, compact(
                'clinic_data',
                'directors',
                'staff',
                'equipment',
                'encryptedAppId',
                'fees',
                'reject',
                'draft_data'
            ));
        }

        if (!$draft_data && (!$existing_data || $existing_data->appstatus == 'Approved' || $existing_data->appstatus == 'Rejected')) {

            // Step 6: First-time Change Address → load from main clinic tables
            $directors = clinicDirectorModel::where('clinic_id', $clinic_id)->where('status', 1)->get();
            // $staff = clinicStaffModel::where('clinic_id', $clinic_id)->where('status', 1)->get();
            $staff = $this->getClinicStaff($clinic_id,$clinic_data->clinic_type,$clinic_data->application_no);
            $equipment = ClinicEquipmentModel::where('clinic_id', $clinic_id)->where('status', 1)->get();
            $view = match (strtoupper($clinic_data->clinic_type)) {
                'ARTCLINIC' => 'change_address.artclinic_application_form',
                'ARTSURROGACY' => 'change_address.surrogacy_application_form',
                'ARTBANK' => 'change_address.artbank_application_form',
            };
            if (!$existing_data) {
                
                return view($view, compact(
                    'clinic_data',
                    'directors',
                    'draft_data',
                    'staff',
                    'equipment'
                ));
            } else {

                $encryptedAppId = Crypt::encryptString($existing_data->id);
                $fees = $existing_data->fee_amount ?? '';
                $reject = $existing_data->appstatus ?? ''; 
                return view($view, compact(
                    'clinic_data',
                    'draft_data',
                    'directors',
                    'staff',
                    'equipment',
                    'encryptedAppId',
                    'fees',
                    'reject'
                ));
            }
        }
        if ($existing_data->clinic_type ) {
            // encrypt the application ID for viewing
            $encryptedAppId = Crypt::encryptString($existing_data->id);
            return $this->changeAddressFormView($encryptedAppId);
        }

        $view = match (strtoupper($clinic_data->clinic_type)) {
            'ARTCLINIC' => 'change_address.artclinic_application_form',
            'ARTBANK' => 'change_address.artbank_application_form',
            'ARTSURROGACY' => 'change_address.surrogacy_application_form',
        };
        return view($view, compact(
            'clinic_data',
            'draft_data',
            'directors',
            'staff',
            'equipment'
        ));
    }

    // start submit application
    public function submitChangeAddressForm(ChangeAddressRequest $request)
    {
        $user = signup::where('email', session('email'))->first();

        if (!$user) {
            return redirect()->route('clinic.loginnocform');
        }

        $userId = $user->id;
        $clinicId = $request->clinic_id;
        $submitType = $request->submit_type;

        $clinic = ClinicRegistrationModel::where('clinic_id', $clinicId)->where('status', 1)->first();

        // dd($clinic);
        if (!$clinic) {
            return redirect()
                ->route('change_address.application_form', Crypt::encryptString($clinicId))
                ->with('failure', 'Clinic not found.');
        }

        $normalize = fn ($value) => strtolower(
            preg_replace('/\s*,\s*/', ',', trim($value))
        );

        $oldAddress = $normalize($request->input('old_address', ''));

        $dbAddress = $normalize(implode(',', [
            $clinic->address,
            $clinic->district,
            $clinic->state,
            $clinic->pincode,
        ]));

        $requestDateEstab = $request->date('dateestab');
        $requestRegDate   = $request->date('current_registration_date');

        $clinicDateEstab = Carbon::parse($clinic->date_of_establishment);
        $clinicRegDate   = Carbon::parse($clinic->rgistration_date);

        $valid =
            trim($request->clinicname) === trim($clinic->name) &&
            trim($request->nature) === trim($clinic->nature) &&
            $oldAddress === $dbAddress &&
            $requestDateEstab?->isSameDay($clinicDateEstab) &&
            $requestRegDate?->isSameDay($clinicRegDate);

            if ($clinic->clinic_type === 'ARTCLINIC') {
                $valid = $valid &&
                    trim($request->input('cliniclevel', '')) === trim($clinic->level);
            }

        if (!$valid) {
            return redirect()
                ->route(
                    'change_address.application_form',
                    Crypt::encryptString($clinicId)
                )
                ->with('failure', 'Clinic details do not match.');
        }

        $status = $submitType === 'draft' ? 0 : 1;

        try {

            DB::beginTransaction();

            $reject_data = null;

            if (!empty($request->r_id)) {

                $r_id = Crypt::decryptString($request->r_id);

                $reject_data = ChangeAddressApplication::find($r_id);
            }

            $fieldMapping = [
                'personname'    => 'contact_person_name',
                'mobilecontact' => 'contact_person_mobile',
                'emailcontact'  => 'contact_person_email',
                'email_clinic'  => 'email',
            ];

            $reverseMapping = array_flip($fieldMapping);

            $application = ChangeAddressApplication::where('clinic_id', $clinicId)
                ->where('application_type', 3)
                ->where('status', 0)
                ->first();


                $lastApplication = ChangeAddressApplication::where('status', 1)->latest()->first();

                $stateCode = DB::table('state')
                    ->where('state_name', $clinic->state)
                    ->value('state_abb');


                $clinicTypeCode = match ($clinic->clinic_type) {
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
                    '%s/%s/CA/%s/%05d',
                    $stateCode,
                    $clinicTypeCode,
                    $year,
                    $nextNumber
                );


            if (
                !$application ||
                (
                    !empty($reject_data) &&
                    isset($reject_data->appstatus) &&
                    $reject_data->appstatus === 'Rejected'
                )
            ) {
                $application = new ChangeAddressApplication();
            }

            $dataToSave = [];

            foreach ($application->getFillable() as $field) {
                $requestField = $reverseMapping[$field] ?? $field;
                $dataToSave[$field] = $request->input($requestField, null);
            }

            $application->fill($dataToSave);

            $application->status = $status;
            $application->userid = $userId;
            $application->clinic_id = $clinicId;
            $application->cliniclevel = $clinic->level;
            $application->application_type = 3;
            $application->application_datetime_submission = now();

            $srClinic = $application;

            // Final submission only
            if ($status == 1) {

                // Generate application number
                $srClinic->applicationno = $applicationNo;
                $srClinic->application_datetime_submission = now();
                $srClinic->appstatus = 'Pending';

                // Rejected application resubmission
                if (!empty($reject_data) && $reject_data->appstatus === 'Rejected') {

                    $revision = 1;

                    if (preg_match('/\/R(\d+)$/', $reject_data->applicationno, $matches)) {
                        $revision = (int) $matches[1] + 1;
                    }

                    $srClinic->applicationno .= "/R{$revision}";

                    $srClinic->app_date_payment = $reject_data->app_date_payment;
                    $srClinic->mode_payment = $reject_data->mode_payment;
                    $srClinic->transaction_id = $reject_data->transaction_id;
                    $srClinic->fee_amount = $reject_data->fee_amount;

                    // Original application number without revision
                    $srClinic->fees_via_application_no = preg_replace(
                        '/\/R\d+$/',
                        '',
                        $reject_data->applicationno
                    );

                    $srClinic->is_resubmission = 1;

                } else {

                    $srClinic->is_resubmission = 0;
                }
            }
            $srClinic->save();

            $this->saveDirectors($request, $application, $userId);
            $this->saveStaff($request, $application, $userId);
            $this->saveEquipment($request, $application, $userId);
            DB::commit();

            $encryptedId = Crypt::encryptString($application->id);

            return $submitType === 'draft'
                ? redirect()->back()->with('success', 'Draft saved successfully.')
                : redirect()
                    ->route('change_address.application.success', $encryptedId)
                    ->with('success', 'Change Address Application Submitted Successfully!');

        } catch (ValidationException $e) {

            DB::rollBack();
            throw $e;

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Change Address submission failed: ' . $e->getMessage());

          return redirect()
            ->route(
                'change_address.application_form',
                Crypt::encryptString($clinicId)
            )
            ->with('failure', 'Unable to process your request. Please try again.');

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Change Address submission failed: ' . $e->getMessage());

           return redirect()
                ->route(
                    'change_address.application_form',
                    Crypt::encryptString($clinicId)
                )
                ->with(
                    'failure',
                    'Unable to process your request. Please try again.'
                );
        }
    }
    private function saveDirectors($request, $application, $userId)
    {
        $application->directors()->delete();
        $request->input('director');

        if ($request->input('director') !== 'Yes') return;
        
        if (!is_array($request->input('name_director'))) return;

        $data = [];

        foreach ($request->input('name_director') as $i => $name) {
            if (empty($name)) continue; // Skip empty director entries
            
            $data[] = [
                'name_director'  => $name,
                'quali_director' => $request->input("quali_director.$i"),
                'reg_director'   => $request->input("reg_director.$i"),
                'userid'         => $userId,
                'application_no' => $application->applicationno,
                'clinic_id'      => $application->clinic_id,
            ];
        }

        if (!empty($data)) {
            $application->directors()->createMany($data);
        }
    }

    private function saveStaff($request, $application, $userId)
    {
        $posts          = $request->input('post', []);
        $names          = $request->input('name_otherstaff', []);
        $qualifications = $request->input('quali_otherstaff', []);
        $regNumbers     = $request->input('regno', []);
        $anyotherpost   = $request->input('anyotherpost', []);
        $anyotherdegree = $request->input('anyotherdegree', []);

        // Delete existing staff
        $application->staff()->delete();

        if (!is_array($posts)) {
            return;
        }

        $data = [];

        foreach ($posts as $i => $post) {

            // Skip completely empty rows
            if (empty($post) && empty($names[$i])) {
                continue;
            }

            $postValue = $post === 'Any Other'
                ? ($anyotherpost[$i] ?? '')
                : ($post ?: '');

            $qualification = $qualifications[$i] ?? null;

            $qualificationValue = $qualification === 'Any Other'
                ? ($anyotherdegree[$i] ?? null)
                : ($qualification ?: null);

            $data[] = [
                'post'          => $postValue,
                'name'          => $names[$i] ?? '',
                'qualification' => $qualificationValue,
                'regno'         => $regNumbers[$i] ?? null,

                'userid'        => $userId,
                'application_no'=> $application->applicationno,
                'clinic_id'     => $application->clinic_id,
                'clinic_type'   => $application->clinic_type,
                'application_id'=> $application->id,
            ];
        }

        if (!empty($data)) {
            $application->staff()->createMany($data);
        }
    }

    private function saveEquipment($request, $application, $userId)
    {

        // dd($application->clinic_id);
        $application->equipment()->delete();

        $equipmentNames = $request->input('equipmentname', []);
        
        if (!is_array($equipmentNames) || empty($equipmentNames)) return;

        $data = [];

        foreach ($equipmentNames as $name) {
            if (empty($name)) continue; // Skip empty equipment entries
            
            $data[] = [
                'equipmentname' => $name,
                'userid'        => $userId,
                'application_no' => $application->applicationno,
                'clinic_type' => $application->clinic_type,
                'clinic_id'     => $application->clinic_id,
            ];
        }

        if (!empty($data)) {
            $application->equipment()->createMany($data);
        }
    }

    // end submit application
    public function changeAddressSuccess(Request $request, $encryptedId)
    {
        $ses_id = Session::get('id');
        
        try {
            $applicationId = Crypt::decryptString($encryptedId);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid or expired link.');
        }

        $application = ChangeAddressApplication::where('id', $applicationId)
            ->where('userid', $ses_id)
            ->where('status', 1)
            ->first();

        if (!$application) {
            return redirect()->back()->with('error', 'Application not found or not submitted yet.');
        }

        $appNo = $application->applicationno;
        $clinicType = strtoupper($application->clinic_type);

        return view('change_address.changes_success', compact('appNo', 'application', 'clinicType'))
            ->with('success', "{$clinicType} Change Address Application Submitted Successfully!");
    }

    public function changeAddressFormView($encryptedId)
    {
        // Step 1: Check session
        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }
        try {
            $applicationId = Crypt::decryptString($encryptedId);
        } catch (\Exception $e) {

            abort(404, 'Invalid or expired link.');
        }
        // dd(Session::all(),Crypt::decryptString($encryptedId));
        $ssaId = false;
        if (Session::get('user_type') < 4) {
            $ses_id = Session::get('id');
        } elseif (Session::get('user_type') == 5) {

            $ssaId = Session::get('id');
            $ses_id = ChangeAddressApplication::where('id', $applicationId)
                ->where('state', Session::get('state_name'))
                ->where('status', 1)
                ->value('userid');
            // dd($ses_id);
            // $ses_id = Session::get('id');
        }

        // Step 2: Decrypt the application ID
        
        $application = ChangeAddressApplication::with('clinic')->where('id', $applicationId)
            ->where('userid', $ses_id)
            ->where('status', 1)
            ->first();
        // dd('sfadf',$applicationId,$ses_id,$application);
        if (!$application) {
            abort(404, 'Application not found.');
        }

        // Step 4: Fetch related sub-tables
        $directors = ChangeAddressDirector::where('clinic_id', $application->clinic_id)
            ->where('application_id', $applicationId)
            ->get();

        $staff = ChangeAddressStaff::where('clinic_id', $application->clinic_id)
            ->where('application_id', $applicationId)
            ->get();

        $equipment = ChangeAddressEquipment::where('clinic_id', $application->clinic_id)
            ->where('application_id', $applicationId)
            ->get();

        if ($ssaId) {
            // Step 6: Choose the correct blade view based on clinic type
            $bladeView = match (strtoupper($application->clinic_type)) {
                'ARTSURROGACY' => 'change_address.surrogacy_application_view_ssa',
                'ARTBANK'      => 'change_address.artbank_application_view_ssa',
                'ARTCLINIC'    => 'change_address.artclinic_application_view_ssa',
                // default        => 'change_address.surrogacy_application_view', // fallback
            };
        } else {
            // dd($application->clinic_type);
            // Step 6: Choose the correct blade view based on clinic type
            $bladeView = match (strtoupper($application->clinic_type)) {
                'ARTSURROGACY' => 'change_address.surrogacy_application_view',
                'ARTBANK'      => 'change_address.artbank_application_view',
                'ARTCLINIC'    => 'change_address.artclinic_application_view',
                // default        => 'change_address.surrogacy_application_view', // fallback
            };
        }
        // Step 7: Return the selected view
        return view($bladeView, compact(
            'application',
            'directors',
            'staff',
            'equipment'
        ));
    }

    private function getClinicStaff($clinicId, $clinicType, $applicationNo)
    {
        $clinicModel = match ($clinicType) {
            'ARTSURROGACY' => SurrogacyClinicModel::class,
            'ARTBANK'      => BankModel::class,
            default        => ArtClinicModel::class,
        };

        $oldClinic = $clinicModel::where('status', 1)
            ->where('applicationno', $applicationNo)
            ->first();

        if ($oldClinic) {

            $staffModel = match ($clinicType) {
                'ARTSURROGACY' => SurrogacyClinicOtherStaffModel::class,
                'ARTBANK'      => BankOtherStaffModel::class,
                default        => ArtClinicOtherStaffModel::class,
            };

            $foreignKey = match ($clinicType) {
                'ARTSURROGACY' => 'surrogacyclinic_id',
                'ARTBANK'      => 'artbank_id',
                default        => 'artclinic_id',
            };

            $clinicStaff = $staffModel::where($foreignKey, $oldClinic->id)->get();

            foreach ($clinicStaff as $staff) {
                $staff->name = $staff->name_otherstaff;
                $staff->qualification = $staff->quali_otherstaff;
                $staff->post = $clinicType == 'ARTBANK'
                    ? $staff->designation_otherstaff
                    : $staff->post_otherstaff;
            }

            return $clinicStaff;
        }

        return clinicStaffModel::where([
            'clinic_id'   => $clinicId,
            'status'      => 1,
        ])->get();
    }
}
