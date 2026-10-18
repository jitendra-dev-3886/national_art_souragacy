<?php

namespace App\Http\Controllers\Clinic;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Admin\user;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\clinic\signup;
use App\Models\clinic\BankModel;
use App\Models\clinic\BankApplicationNo;
use App\Models\clinic\BankEquipmentModel;
use App\Models\clinic\BankOtherStaffModel;
use App\Http\Requests\BankApplicationFormRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;

class BankApplicationController extends Controller
{
    public function bankapplicationform(Request $request)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        } 

        // $countries = countrytable::all();
        // Fetch records from requesttable for the logged-in user
        $userId = Session::get('id');
        $email = $request->session()->get('email');
        $check_user = signup::where('email', $email)->first();

        $clinic_details = BankModel::where('userid', $userId)->first();
        // dd($clinic_details);
        if($clinic_details){
            if($clinic_details->applicationno !== NULL && $clinic_details->status == 1){
                return redirect()->route('clinic.bankForm_view', ['id' => encrypt($clinic_details->id)]);

            }elseif($clinic_details->applicationno == NULL && $clinic_details->status == 0){

                $draft = BankModel::where('status',0)->where('applicationno',NULL)->where('userid', $userId)->where('id', $clinic_details->id)->first();
                $staff = BankOtherStaffModel::where('artbank_id', $clinic_details->id)->get();
                $equipment = BankEquipmentModel::where('artbank_id', $clinic_details->id)->get();

                return view('layouts/clinic/add_bank_application_form', ['tab' => $request->input('tab', 1), 'draft' => $draft, 'staff' => $staff, 'equipment' => $equipment]);
            }
        }elseif($check_user){
            $user = signup::where('email', $email)->where('id',$userId)->first();
            return view('layouts/clinic/add_bank_application_form', ['tab' => $request->input('tab', 1), 'signup' => $user]);
        }
       
    }


    public function bankapplicationformSubmit(BankApplicationFormRequest $request)
    {
        $user = signup::where('email', session('email'))->first();
        if (!$user) {
            return redirect()->route('clinic.loginclinicform');
        }
        $u_id = $user->id;
        $id = $request->input('id');
        try {
            DB::beginTransaction();
            if (!empty($id)) {
                $artBank = BankModel::where('id', $id)->first();
            } else {
                $artBank = BankModel::where('userid', $u_id)->first();
            }

            if ($artBank) {
                $bank_id = $artBank->id;

                // delete old related records
                BankOtherStaffModel::where('artbank_id', $bank_id)->delete();
                BankEquipmentModel::where('artbank_id', $bank_id)->delete();

                $artBank->fill($request->all());
            } else {
                // New Bank record
                $artBank = new BankModel();
                $artBank->userid = $u_id;
                $artBank->fill($request->all());
            }

            // Status set
            if ($request->input('common') == 'submit') {
                $artBank->status = 1;
            } elseif ($request->input('common') == 'draft') {
                $artBank->status = 0;
            }

            // Extra fields
            $artBank->email = $request->input('email_bank');
            $artBank->contact_person_name = $request->input('personname');
            $artBank->contact_person_mobile = $request->input('mobilecontact');
            $artBank->contact_person_email = $request->input('emailcontact');
            $artBank->save();

            $bank_id = $artBank->id;  // correct variable

            // Save Other Staff
            $postData = $request->name_otherstaff;
            $anyOtherPostData = $request->anyotherpost;
            $anyOtherDegreeData = $request->anyotherdegree;

            if (is_array($postData)) {
                $staffData = [];
                foreach ($postData as $k => $staff) {
                    $postValue = ($request->designation_otherstaff[$k] === 'Any Other') 
                        ? $anyOtherPostData[$k] 
                        : $request->designation_otherstaff[$k];

                    $qualiValue = ($request->quali_otherstaff[$k] === 'Any Other') 
                        ? $anyOtherDegreeData[$k] 
                        : $request->quali_otherstaff[$k];

                    $staffData[] = [
                        'artbank_id' => $bank_id,
                        'name_otherstaff' => $request->name_otherstaff[$k],
                        'designation_otherstaff' => $postValue,
                        'quali_otherstaff' => $qualiValue,
                        'userid' => $u_id,
                    ];
                }
                BankOtherStaffModel::insert($staffData);
            }

            // Save Equipments
            $equipmentData = $request->equipmentname;
            if (is_array($equipmentData)) {
                $equipData = [];
                foreach ($equipmentData as $e => $equipment) {
                    $equipData[] = [
                        'equipmentname' => $equipment,
                        'artbank_id' => $bank_id,
                        'userid' => $u_id,
                    ];
                }
                BankEquipmentModel::insert($equipData);
            }

            // If form is submitted
            if ($request->input('common') == 'submit') {
                $year = Carbon::now()->year;
                $state = $request->input('state');
                $su_id = DB::table('state')
                    ->where('state_name', $state)
                    ->orderBy('state_name')
                    ->value('state_abb');

                // Generate Application Number
                $latestApplication = BankApplicationNo::orderBy('id', 'desc')->first();
                if ($latestApplication) {
                    $ano = $latestApplication->applicationno;
                    $ano_sub = substr($ano, -5);
                    $getnumbers = str_replace("/", "", $ano_sub);
                    $no_increase = $getnumbers + 1;
                    $get_string = str_pad($no_increase, 5, '0', STR_PAD_LEFT);
                    $enumber = $su_id . '/AB/' . $year . '/' . $get_string;
                } else {
                    $enumber = $su_id . '/AB/' . $year . '/10001';
                }

                $bApplicationNo = new BankApplicationNo();
                $bApplicationNo->applicationno = $enumber;
                $bApplicationNo->bank_id =  $bank_id;
                $bApplicationNo->save();

                BankModel::where('id', $bank_id)
                    ->update([
                        'applicationno' => $enumber,
                        'applicationno_datetime_submission' => now()
                    ]);

                DB::commit();
                return redirect()->route('clinic.application.bank_success')
                    ->with('success', 'ART Bank Application Submitted Successfully!');
            } else {
                DB::commit();
                return redirect()->route('clinic.clinicForm_list')
                    ->with('success', 'ART Bank Application Saved as Draft Successfully!');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
            return response()->view('errors.500', [], 500);
        }
    }

    public function bshowSuccessPage(Request $request)
    {
        // $ses_id = Session::get('id');
        // $ses_UID = Session::get('userid');
        // dd($ses_id);

        $ses_id = Session::get('id');
        // ID from session
        //dd($ses_id);
        $signup = signup::find($ses_id);
        // Fetch Signup record

        //dd($ses_id);

        // $artclinicIds = $signup->artclinics->pluck('id'); // Fetch related Artclinic IDs
        $bclinicIds = $signup->bankclinics->id;
        // dd($bclinicIds);
        //dd($ses_id);
        // $applicationNo = $request->input('applicationNo');
        // dd($applicationNo);
        // $successMessage = session('success'); // Retrieve the success message from the session

        // if (!$applicationNo) {
        //     return redirect()->route('clinic.application.form')->with('error', 'Invalid application submission!');
        // }
        $applications = BankModel::with('bapp_no')->where('id', $bclinicIds)->first();
        // dd($applications);
        // $appNo = $applications->pluck('app_no')->flatten()->pluck('id');
        $appNo = $applications->bapp_no->applicationno;
        // dd($appNo);
        $app_bclinic_id = $applications->bapp_no->bank_id;
        //dd($app_bclinic_id);
        return view('layouts.clinic.bank_success', compact('appNo', 'applications', 'app_bclinic_id'))->with('success', 'ART Bank Application Submitted Successfully!');
    }
    public function bankForm_view($id, $view = null)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }

        $bclinicIds = Crypt::decrypt($id);
        $application = BankModel::with('bapp_no')->where('id', $bclinicIds)->get();
        if (!$application) {
            abort(404, 'Application not fousnd.');
        }
        $staff = BankOtherStaffModel::where('artbank_id', $bclinicIds)->get();
        $equipment = BankEquipmentModel::where('artbank_id', $bclinicIds)->get();

        $user = signup::where('email', session('email'))->first();
        $adminuser = user::where('email',session('email'))->first();
        if (!$user && !$adminuser) {
            abort(404, 'User not found.');
        }

        if ($view == 'view') {
            return ['application' => $application, 'staff' => $staff, 'equipment' => $equipment];
        }
        if($user){
            return view('layouts.clinic.bank_form_view', compact('application', 'staff', 'equipment'));
        }
        if($adminuser)
        {
            return view('layouts.admin.bank_form_view', compact('application', 'staff', 'equipment'));
        }
        
    }
    public function bankgeneratePdf($id)
    {

        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $bclinicIds = Crypt::decrypt($id);
        
        $application = BankModel::with('bapp_no')->where('id', $bclinicIds)->get();
        if (!$application) {
            abort(404, 'Application not found.');
        }

        $staff = BankOtherStaffModel::where('artbank_id', $bclinicIds)->get();
        $equipment = BankEquipmentModel::where('artbank_id', $bclinicIds)->get();
        $user = signup::where('email', session('email'))->first();
        $adminuser = user::where('email',session('email'))->first();
        if (!$user && !$adminuser) {
            abort(404, 'User not found.');
        }
        // Load the view and pass data
        $pdf = Pdf::loadView('layouts.clinic.bapplication_pdf', compact('application', 'staff', 'equipment'));
        //dd($pdf);
        // Optionally, stream or download the PDF
        return $pdf->stream('application_pdf.pdf');
        // For download: return $pdf->download('application_details.pdf');
    }
}
