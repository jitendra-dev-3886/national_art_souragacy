<?php

use App\Http\Controllers\SignupUser;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NOCController;
use App\Http\Controllers\NocForiegnerController; 
use App\Http\Controllers\Clinic\ClinicApplicationController;
use App\Http\Controllers\Clinic\BankApplicationController;
use App\Http\Controllers\Clinic\SurrogacyClinicController;
use App\Http\Controllers\SignupNocUser;
use App\Http\Controllers\SSAController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\AdminServiceController; 
use App\Http\Controllers\patientController;
use App\Http\Controllers\PatientSurrogacyClinicController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ssa\ReportController;
use App\Http\Controllers\ssa\AccessChangeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\UserTableController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\DashboardDataNocController;
use App\Http\Controllers\SignupUserProfileController;
use App\Http\Controllers\SignupChangePasswordController; 
use App\Http\Controllers\NocServiceController; 
use App\Http\Controllers\Reports\ApplicationReportController;
use App\Http\Controllers\Reports\ComprehensiveQuarterlyReportController;
use App\Http\Controllers\IdleTimeoutController;
use Illuminate\Http\Request;
use App\Http\Controllers\ssa\ClinicAdminController;
use App\Http\Controllers\ssa\BankAdminController; 
use App\Http\Controllers\ssa\SurrogacyAdminController;

use App\Http\Controllers\renewal\renewalApplicationController;
use App\Http\Controllers\renewal\renewalssaController;

use App\Http\Controllers\ChangeAddress\ChangeAddressController;
use App\Http\Controllers\ChangeAddress\ChangeAddressSSAController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Reports\PatientReportController;
use App\Http\Controllers\Clinic\ClinicNamechangeController;
use App\Http\Controllers\ssa\ClinicAdminChangeNameController;
use App\Http\Controllers\Manpowers\ChangeManpowerController;
use App\Http\Controllers\Withdrawal\ClinicWithdrawalController;
use App\Http\Controllers\Withdrawal\ClinicWithdrawalSAController;
use App\Http\Controllers\Manpowers\ChangeManpowerSSAController;
use App\Http\Controllers\ssa\ClinicSuspensionSAController;
use App\Http\Controllers\ssa\ClinicRevocationSAController;
use App\Http\Controllers\patientreportdashboards\DynamicReportingController;
use App\Http\Controllers\Reports\DailySnapshotController;

use App\Http\Controllers\Reports\DailyReportController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

if (app()->environment('local')) {
    Route::get('/routes-list', function () {
        $routes = collect(Route::getRoutes())->map(function ($route) {
            return [
                'uri' => $route->uri(),
                'name' => $route->getName(),
                'method' => implode('|', $route->methods()),
                'action' => $route->getActionName(),
                'middleware' => $route->gatherMiddleware(),
            ];
        });

        return response()->json($routes->values());
    });
}

use App\Http\Controllers\DateCorrectionController;

Route::get('/convert-establishment-dates/{type}', [DateCorrectionController::class, 'convertDates']);
Route::get('/', [SignupUser::class, 'index2'])->name('clinic.dashboardsgs');
Route::get('clinic/list', [DashboardController::class, 'clinicData'])->name('clinic.list');
 

Route::get('/signup-form', [SignupUser::class, 'requestclinicSignUp'])->name('clinic.request_clinic_signup');
//request form for signup to save the clinic/bank user details
Route::Post('/signup-form-data', [SignupUser::class, 'requestSignUpData'])->name('clinic.request_signup_data');
//check email from database in request from
Route::post('/check-email', [SignupUser::class, 'checkEmail'])->name('clinic.checkEmail');

//get the data from signup table
Route::Post('/signup-verified-form-data', [SignupUser::class, 'verifiedSignUpdata'])->name('clinic.verified_clinic_signup_data');
Route::get('/signup-verified-form', [SignupUser::class, 'verifiedSignUp'])->name('clinic.verified_clinic_signup');

//resend verification link for clinic signup
Route::get('/resend-verification-link', [SignupUser::class, 'resend_verification_link'])->name('clinic.resendLink');
Route::post('/resend-verification-email', [SignupUser::class, 'resend_verification_email'])->name('clinic.resendVerificationEmail')->middleware('throttle:2,1');
//create the password and save the password in signup table

//capacha implement on signup form
Route::get('/reload-captcha-verified', [SignupUser::class, 'verifiedreloadCaptcha'])->name('clinic.verifiedreloadCaptcha');
//create the password and save the password in signup table
Route::get('/password-submitted-message', [SignupUser::class, 'create_password_clinic_msg'])->name('clinic.create_password_clinic_msg');
// get the data from request table
Route::get('/verified-form', [SignupNocUser::class, 'verifiedNocSignUp'])->name('noc.verified_noc_signup');

//create the password and save the password in verified table
Route::Post('/verified-form-data', [SignupNocUser::class, 'verifiedNocSignUpdata'])->name('noc.verified_noc_signup_data');

//get the data from request table
Route::get('/verified-form', [SignupNocUser::class, 'verifiedNocSignUp'])->name('noc.verified_noc_signup');
//create the password and save the password in verified table
Route::Post('/verified-form-data', [SignupNocUser::class, 'verifiedNocSignUpdata'])->name('noc.verified_noc_signup_data');
Route::get('/clinic_verify_form', [AccessChangeController::class, 'clinicverify'])->name('clinic.verify_access')->middleware('signed');
Route::get('/clinic_stop_access', [AccessChangeController::class, 'stopemailrequest'])->name('clinic.stop_access')->middleware('signed');
Route::post('/clinic_verify_form', [AccessChangeController::class, 'clinicverifysubmit'])->name('clinic.verify_access');
Route::get('/clinic_verify_thank', [AccessChangeController::class, 'clinicverifythank'])->name('clinic.verify_accessthank');
Route::post('/check-email-access', [AccessChangeController::class, 'checkEmailaccess'])->name('clinic.checkEmailaccess');
Route::get('/invalid-link', function () {return view('errors.invalid_link');})->name('error.accesschange');
Route::middleware(['VerifySingleSession'])->group(function () {

    //for access change 
        Route::get('/clinic-email-change', [AccessChangeController::class, 'create'])->name('clinic.email_change');
        Route::post('/clinic-email-change', [AccessChangeController::class, 'store'])->name('clinic.email_change');
        Route::get('/check-application-no', [AccessChangeController::class, 'applicaion_no'])->name('check.applicaion_no');
        Route::get('/access/list', [AccessChangeController::class, 'emailchangelist'])->name('clinic.access.changelist');
        Route::post('/access-change/update-status', [AccessChangeController::class, 'updateStatus'])->name('access_change.update_status');
        Route::post('/access-change/resend-mail',[AccessChangeController::class, 'resendMail'])->name('access_change.resend_mail');
        Route::get('admin/accesschange_list', [AccessChangeController::class, 'accesschangelist'])->name('admin.accesschangelist');
    /*  Wasim Gour starting new code  start*/

        //  Report Route starts

            Route::get('report/patient_detail_consolidated', [ReportController::class, 'patient_detail_consolidated'])->name('admin.patient_detail_consolidated');
        // level One
            Route::get('report/clinic-report-level-one-form', [ReportController::class, 'clinic_report_one_form'])->name('report.clinicReportOneForm');
            Route::post('report/clinic-report-level-one-gd', [ReportController::class, 'clinic_report_level_one'])->name('report.clinicReportOneGD');
        // level Two
            Route::get('report/clinic-report-level-two-form', [ReportController::class, 'clinic_report_level_two_form'])->name('report.clinicReportLevelTwoForm');
            Route::post('report/clinic-report-level-two', [ReportController::class, 'clinic_report_level_two'])->name('report.clinicReportLevelTwo');

        // Surrogacy clinic
            Route::get('report/surrogacy-clinic-report', [ReportController::class, 'surrogacy_clinic_report'])->name('report.surrogacyClinicReport');
            Route::post('report/surrogacy-clinic-report-gd', [ReportController::class, 'surrogacy_clinic_report_gd'])->name('report.surrogacyClinicReportGD');

        // Surrogacy clinic
            Route::get('report/bank-clinic-report', [ReportController::class, 'bank_clinic_report'])->name('report.bankClinicReport');
            Route::post('report/bank-clinic-report-ajax', [ReportController::class, 'bank_clinic_report_ajax'])->name('report.bankClinicReportAjax');

        //  Report Route ends



        /*  ClinicAdminController Route start*/
            Route::get('admin/monthly_report', [DataTableController::class, 'monthly_report'])->name('admin.monthly_report');
            Route::get('admin/monthly_report_list', [DataTableController::class, 'monthly_report_list'])->name('admin.monthly_report_list');
            Route::get('admin/monthly_report_detail', [DataTableController::class, 'monthlyReportList'])->name('admin.monthly_report_detail');
            Route::get('admin/state_wise_report', [DataTableController::class, 'state_wise_report'])->name('admin.state_wise_report');
            Route::get('admin/state_clinic_report_list', [DataTableController::class, 'state_clinic_report_list'])->name('admin.state_clinic_report_list');
            //reset password for ssa by admin
            Route::get('admin/reset-passwords', [AdminController::class, 'ssaresetpwd'])->name('admin.resetpassword');
            Route::get('/admin/get-emails-by-state', [AdminController::class, 'getEmailsByState'])->name('ssa.users.by.state');
            Route::post('admin/reset-passwords', [AdminController::class, 'ssaresetpwdsubmit'])->name('admin.resetpassword.submit');
            
            //list of submitted ART aplication form
            Route::get('admin/clinic-ssa-form-list', [ClinicAdminController::class, 'ssaForm_list'])->name('admin.ssaForm_list'); 
            //search facility for ART Clinic by SSA
            Route::get('/admin/searchApplication', [ClinicAdminController::class, 'searchApplication'])->name('admin.searchApplication');
            // clinic form view for admin
            // Route::get('admin/clinic-form-view/{id}', [ClinicAdminController::class, 'clinicForm_view'])->name('admin.clinicForm_view');
            //list of submitted ART aplication form action
            Route::get('admin/received-clinic-ssa-form-list/{id}', [ClinicAdminController::class, 'receivedssaForm_list'])->name('admin.receivedssaForm_list');
            //submitted route of received fee
            Route::post('admin/receive_clinic_submit', [ClinicAdminController::class, 'receive_clinic_submitForm'])->name('admin.receive_clinic_submit');
            
            //list of submitted ART aplication form for upload registration certificate
            Route::get('admin/reg-clinic-ssa-form-list', [ClinicAdminController::class, 'reg_ssaForm_list'])->name('admin.reg_ssaForm_list');

            //search facility for ART Clinic by SSA
            Route::get('/admin/regsearchApplication', [ClinicAdminController::class, 'regsearchApplication'])->name('admin.regsearchApplication');
            // certificate upload form
            Route::get('admin/reg-received-clinic-ssa-form-list/{id}', [ClinicAdminController::class, 'reg_receivedssaForm_list'])->name('admin.reg_receivedssaForm_list');
            // certificate upload Submit route
            Route::post('admin/reg-receive-clinic-form', [ClinicAdminController::class, 'reg_receive_clinic_submitForm'])->name('admin.reg_receive_clinic_submit');
        
        /*  ClinicAdminController Route End*/


        /*  BankAdminController Route start*/

            //list of submitted surrogacy aplication form
            Route::get('admin/bank-ssa-form-list', [BankAdminController::class, 'bankssaForm_list'])->name('admin.bank_ssaForm_list');
                //search facility for fees receiving ART Clinic by SSA
            Route::get('/admin/banksearchApplication', [BankAdminController::class, 'banksearchApplication'])->name('admin.banksearchApplication');
            //list of submitted bank aplication for fee reciving
            Route::get('admin/received-bank-ssa-form-list/{id}', [BankAdminController::class, 'receivedbankssaForm_list'])->name('admin.receivedbankssaForm_list');
            //submit art bank for fee update receiving facility
            Route::post('admin/receive-bank-form', [BankAdminController::class, 'receive_bank_submitForm'])->name('admin.receive_bank_submit');


            //list of submitted ART aplication form for upload registration certificate
            Route::get('admin/reg-bank-ssa-form-list', [BankAdminController::class, 'reg_bank_ssaForm_list'])->name('admin.bank_reg_ssaForm_list');
            
            //search facility for Bank by SSA
            Route::get('/admin/regbanksearchApplication', [BankAdminController::class, 'regbanksearchApplication'])->name('admin.regbanksearchApplication');
            
            //list of submitted bank aplication form action of registration certifacte upload
            Route::get('admin/reg-received-bank-ssa-form-list/{id}', [BankAdminController::class, 'reg_receivedbankssaForm_list'])->name('admin.reg_receivedbankssaForm_list');
            //submit art bank form to upload the registration certificate
            Route::post('admin/registration-receive-bank-form', [BankAdminController::class, 'reg_receive_bank_submitForm'])->name('admin.reg_receive_bank_submit');
    

        /*  BankAdminController Route End*/

        /*  SurrogacyAdminController Route start*/

            //list of submitted surrogacy aplication form
            Route::get('admin/surrogacy-ssa-form-list', [SurrogacyAdminController::class, 'surrogacyssaForm_list'])->name('admin.surrogacy_ssaForm_list');
            //search facility for fees reciving ART Clinic by SSA
            Route::get('/admin/regsurrogacysearchApplication', [SurrogacyAdminController::class, 'regsurrogacysearchApplication'])->name('admin.regsurrogacysearchApplication');
            //list of submitted ART aplication form action
            Route::get('admin/received-surrogacy-ssa-form-list/{id}', [SurrogacyAdminController::class, 'receivedsurrogacyssaForm_list'])->name('admin.receivedsurrogacyssaForm_list');
            Route::post('admin/receive_surrogacy_clinic_submit', [SurrogacyAdminController::class, 'receive_surrogacy_clinic_submitForm'])->name('admin.surrogacy_receive_clinic_submit');

            //list of submitted ART surrogacy clinic form for upload registration certificate
            Route::get('admin/reg-surrogacy-ssa-form-list', [SurrogacyAdminController::class, 'reg_surrogacy_ssaForm_list'])->name('admin.surrogacy_reg_ssaForm_list');
            //list of submitted surrogacy aplication form action of registration certifacte upload 
            Route::get('admin/reg-received-surrogacy-ssa-form-list/{id}', [SurrogacyAdminController::class, 'reg_receivedsurrogacyssaForm_list'])->name('admin.reg_receivedsurrogacyssaForm_list');
            //submit art bank form to upload the registration certificate
            Route::post('admin/registration-receive-surrogacy-form', [SurrogacyAdminController::class, 'reg_receive_surrogacy_submitForm'])->name('admin.reg_receive_surrogacy_submit');

        /*  SurrogacyAdminController Route end*/
            /*  upload excel/csv routes starts*/
            Route::get('/patient/upload', [PatientUploadController::class, 'showUpload']);
            Route::post('/patient/upload', [PatientUploadController::class, 'upload'])->name('patient.upload');
            Route::get('/patient/template', [PatientUploadController::class, 'downloadTemplate'])->name('patient.template');

          
            /*  upload excel/csv routes ends*/

        /*  Admin Route of all clnic patient list start*/
            Route::get('admin/clinic-patient-list/{type}', [PatientReportController::class, 'clinic_patient_list'])->name('admin.clinic_patient_list');
            Route::post('admin/clinic-patient-report', [PatientReportController::class, 'clinic_patient_report'])->name('admin.clinicPatientReport'); 
            Route::get('admin/clinic-patient-full-details', [PatientReportController::class, 'clinic_patient_details'])->name('admin.clinicPatientFullDetails');
 
             
        /*  Admin Route of all clnic patient list end*/

                
            // Renewal applications
            Route::prefix('renewal')->group(function() {
            Route::get('application-form/{encryptedClinicId}',[renewalApplicationController::class, 'surrogacyRenewalApplicationform'])->name('renewal.surrogacy_renewal_applicationform');
            });
            Route::post('/renewal/submit-sc-application', [renewalApplicationController::class, 'submit_surrogacyRenewalApplicationform'])->name('renewal.submit_sc_application');
            Route::get('/renewal-success/{encryptedId}', [renewalApplicationController::class, 'renewal_sc_success'])->name('renewal.application.success');
            Route::get('renewal/surrogacy-renewal-form-view/{encryptedId}',[renewalApplicationController::class, 'sc_renewalform_view'])->name('renewal.sc_renewalform_view');



            Route::get('renewal/{clinicType}-ssa-renewal-list', [renewalssaController::class, 'clinicssarenewal_list'])->name('renewal.clinic_ssarenewal_list');
            Route::get('/renewal/{clinicType}-ssa-search-application', [renewalssaController::class, 'renewalsearchApplication'])->name('renewal.ssa_search_application');
            Route::get('/renewal/{clinicType}-application-rec/{id}', [renewalssaController::class, 'renewalApplicationRec'])->name('renewal.ssa_application_rec');
            Route::post('/renewal/get-cash-amount-date-application', [renewalssaController::class, 'getAmountDate'])->name('renewal.ssa_application.get.cashamount');
            // Dynamic submit route for any clinic type
            Route::post('/renewal/{encryptedClinicType}-receive-clinic-submit', [renewalssaController::class, 'receiveClinicSubmit'])->name('renewal.receive_clinic_submit');

            Route::prefix('registration')->group(function () {Route::get('/list/{encryptedClinicType}', [renewalssaController::class, 'showClinicList'])->name('registration.clinic-list');});
            // Route::get('renewal/ssa-application-view/{encryptedClinicId}',[renewalssaController::class, 'showClinicView'])->name('renewal.ssa_aplication_view');
            // Route for the Action button sidebar
            Route::get('/renewal/{encryptedClinicType}-ssa-application-reg/{encryptedId}', [renewalssaController::class, 'renewalApplicationReg'])->name('renewal.ssa_application_reg');
            // Route for the View button 
            Route::get('/renewal/application-view/{id}', [renewalssaController::class, 'applicationView'])->name('renewal.application_view');
            Route::get('/renewal/application-pdf/{id}', [renewalssaController::class, 'renewalclinicgeneratePdf'])->name('renewal.clinicgeneratePdf');
            Route::post('/renewal/clinic-submit', [renewalssaController::class, 'reg_receive_clinic_submit'])->name('renewal.reg_receive_clinic_submit');
            // Route::get('/renewal/{clinicType}/list/{clinic_id}', [RenewalSSAController::class, 'clinicRenewalList'])
            //     ->name('renewal.clinic_ssarenewal_list');
            //  Route::get('/renewal/application_view/{id}', [renewalsurrogacyssaController::class, 'view_application'])->name('renewal.application_view');


            // Summary set period applications
            Route::get('clinic/set-quarter-for-patient-summary/{clinic_type}', [patientController::class, 'quarter_set_for_patient_summary'])->name('clinic.quarter_set_for_patient_summary');
            //save the Summary set period applications form
            Route::post('clinic/set-quarter-for-patient-summary-submit', [patientController::class, 'quarter_set_for_patient_summary_submit'])->name('clinic.quarter_set_for_patient_summary_submit');
           
            //save the art clinic form
            Route::post('clinic/patient-summary-detail-form/{clinic_type}', [patientController::class, 'patient_summary_detail_form'])->name('clinic.patient_summary_detail_form');
             Route::get('clinic/patient-summary-detail-form/{clinic_type}', [patientController::class, 'patient_summary_detail_form'])->name('clinic.patient_summary_detail_form');

            // open the art clinic patient form
            
            Route::post('clinic/summary-patient-application-form-new', [patientController::class, 'patient_summary_detail_form_new'])->name('clinic.add_summary_patient_clinic_application_form');
            
            Route::get('view-clinic-summary/{clinic_type}/{summary_id}',[patientController::class, 'summary_view'])->name('view.clinicSummary');
            /*  Wasim Gour starting new code  End*/

            

        //clinic dashboard route
    
        Route::get('clinic/signup-password-change', [SignupChangePasswordController::class, 'signupshowChangePasswordForm'])->name('clinic.signup_password.change');
        Route::post('clinic/signup-password-changes', [SignupChangePasswordController::class, 'signupchangePassword'])->name('clinic.signup_password.change.post');
        Route::get('clinic/signup-user-profile', [SignupUserProfileController::class, 'signupshowProfile'])->name('clinic.signupprofile');
    
        Route::post('clinic/application-form-submit', [ClinicApplicationController::class, 'clinicapplicationformSubmit'])->name('clinic.save_clinic_application_form');
        Route::post('clinic/surrogacy-application-form-submit', [SurrogacyClinicController::class, 'sclinicapplicationformSubmit'])->name('clinic.save_sclinic_application_form');

        Route::get('clinic/bank-application-form', [BankApplicationController::class, 'bankapplicationform'])->name('clinic.add_bank_application_form');
        Route::post('clinic/bank-application-form-submit', [BankApplicationController::class, 'bankapplicationformSubmit'])->name('clinic.save_bank_application_form');
        Route::get('clinic/clinic-form-view/{id}', [ClinicApplicationController::class, 'clinicForm_view'])->name('clinic.clinicForm_view');
        Route::get('clinic/surrogacy-clinic-form-view/{id}', [SurrogacyClinicController::class, 'sclinicForm_view'])->name('clinic.sclinicForm_view');
        Route::get('clinic/bank-form-view/{id}', [BankApplicationController::class, 'bankForm_view'])->name('clinic.bankForm_view');
        Route::get('/clinic-application/success', [ClinicApplicationController::class, 'showSuccessPage'])->name('clinic.application.success');
        Route::get('/surrogacy-clinic-application/success', [SurrogacyClinicController::class, 'sshowSuccessPage'])->name('clinic.application.surrogacy_success');
        Route::get('/bank-application/success', [BankApplicationController::class, 'bshowSuccessPage'])->name('clinic.application.bank_success');
        Route::get('clinic/application-form', [ClinicApplicationController::class, 'clinicapplicationform'])->name('clinic.add_clinic_application_form');
        Route::get('clinic/surrogacy-application-form', [SurrogacyClinicController::class, 'surrogacyapplicationform'])->name('clinic.add_surrogacy_application_form');
        Route::get('clinic/surrogacy-renewal-application-form', [SurrogacyClinicController::class, 'surrogacyrenewalapplicationform'])->name('clinic.add_surrogacy_renewal_application_form');
        Route::get('clinic/application-pdf/{id}', [ClinicApplicationController::class, 'clinicgeneratePdf'])->name('clinic.clinicgeneratePdf');
        //make pdf of surrogacy application form
        Route::get('clinic/surrogacy-application-pdf/{id}', [SurrogacyClinicController::class, 'sclinicgeneratePdf'])->name('clinic.sclinicgeneratePdf');
        //make pdf of bank application form
        Route::get('clinic/bank-application-pdf/{id}', [BankApplicationController::class, 'bankgeneratePdf'])->name('clinic.bankgeneratePdf');
        //list of submitted aplication form
        Route::get('clinic/clinic-form-list', [ClinicApplicationController::class, 'clinicForm_list'])->name('clinic.clinicForm_list');
        // logout the clinic from session
        Route::post('clinic/clinic-logout', [NOCController::class, 'cliniclogout'])->name('clinic.logout');
        
        Route::get('/ssa-dashboard', [SSAController::class, 'ssa_dashboard'])->name('ssa.dashboard');

        //change Admin password
        Route::get('admin/ssa-password-change', [ChangePasswordController::class, 'ssaadminChangePasswordForm'])->name('admin.ssapassword.change');
        Route::post('admin/ssa-password-changes', [ChangePasswordController::class, 'ssaadminchangePassword'])->name('admin.ssapassword.change.post');

        //check email from database in request from
        Route::post('clinic/surrogacy-check-uhid', [PatientSurrogacyClinicController::class, 'surrogacycheckuhid'])->name('clinic.surrogacycheckuhid'); 
        // list of surrogacy clinic patient form
        Route::get('admin/list-surrogacyclinic-patient', [PatientSurrogacyClinicController::class, 'list_surrogacyclinic_patient'])->name('clinic.list_surrogacyclinic_patient');
        
        // open the surrogacy clinic patient form
        Route::get('clinic/surrogacy-patient-application-form', [PatientSurrogacyClinicController::class, 'patientsurrogacyapplicationform'])->name('clinic.add_patient_surrogacy_application_form');

        //search facility for Surrogacy by SSA
        Route::get('/admin/list-surrogacy-patientsearch-Application', [PatientSurrogacyClinicController::class, 'list_surrogacy_patientsearchApplication'])->name('admin.list_surrogacy_patientsearchApplication');
        //view the patient surrogacy clinic application form
        Route::get('clinic/patient-surrogacy-form-view/{id}', [PatientSurrogacyClinicController::class, 'patientsurrogacyForm_view'])->name('clinic.patientsurrogacyForm_view');

        //save the patient surrogacy clinic form
        Route::post('clinic/patient-surrogacy-application-form-submit', [PatientSurrogacyClinicController::class, 'patientsurrogacyapplicationformSubmit'])->name('clinic.patient_save_surrogacy_application_form');

        // open the surrogacy clinic patient form
        Route::get('clinic/summary-patient-application-form', [PatientSurrogacyClinicController::class, 'summarypatientsurrogacyapplicationform'])->name('clinic.summary_add_patient_surrogacy_application_form'); 

        // open the art clinic level 1 patient form
        Route::get('clinic/summary-artone-patient-application-form', [patientController::class, 'summarypatientartapplicationform'])->name('clinic.summary_add_patient_art_application_form'); 

        //save the art clinic (level-I) form
        Route::post('clinic/summary-patient-artone-application-form-submit', [patientController::class, 'summarypatientartapplicationformSubmit'])->name('clinic.summary_patient_save_art_application_form');
        // open the art clinic level 2 patient form
        Route::get('clinic/summary-arttwopatient-application-form', [patientController::class, 'summarypatientarttwoapplicationform'])->name('clinic.summary_add_patient_art_two_application_form'); 

        //save the art clinic (level-2) form
        Route::post('clinic/summary-patient-art-application-form-submit', [patientController::class, 'summarypatientarttwoapplicationformSubmit'])->name('clinic.summary_patient_save_art_two_application_form');


        // //edit the art clinic (level-2) form
        // Route::get('clinic/summary-patient-art-application-form-submit-edit', [patientController::class, 'summarypatientarttwoapplicationformSubmitedit'])->name('clinic.summary_patient_save_art_two_application_form_edit');
        // open the art bank patient form
        Route::get('clinic/summary-bankpatient-application-form', [patientController::class, 'summarypatientbankapplicationform'])->name('clinic.summary_add_patient_bank_application_form'); 

        //save the art bank form
        Route::post('clinic/summary-patient-bank-application-form-submit', [patientController::class, 'summarypatientbankapplicationformSubmit'])->name('clinic.summary_patient_save_bank_application_form');

        //save the surrogacy clinic form
        Route::post('clinic/summary-patient-surrogacy-application-form-submit', [PatientSurrogacyClinicController::class, 'summarypatientsurrogacyapplicationformSubmit'])->name('clinic.summary_patient_save_surrogacy_application_form');


        // open the art clinic patient form
        Route::get('clinic/patient-application-form', [patientController::class, 'patientclinicapplicationform'])->name('clinic.add_patient_clinic_application_form');

        //search facility for ART Clinic by SSA
        Route::get('/admin/list-artclinic-patientsearch-Application', [patientController::class, 'list_artclinic_patientsearchApplication'])->name('admin.list_artclinic_patientsearchApplication');

        //view the patient art Clinic application form
        Route::get('clinic/patient-clinic-form-view/{id}', [patientController::class, 'patientclinicForm_view'])->name('clinic.patientclinicForm_view');

        //save the patient clinic form
        Route::post('clinic/patient-clinic-application-form-submit', [patientController::class, 'patientclinicapplicationformSubmit'])->name('clinic.save_patientclinic_application_form');

        //list of archive application for SSA
        Route::get('admin/archived_applications', [DataTableController::class, 'ssa_archived_apps_list'])->name('admin.archived_apps');
        //check email from database in request from
        Route::post('clinic/check-uhid', [patientController::class, 'checkuhid'])->name('clinic.checkuhid');
        // list of art clinic patient form
        Route::get('admin/list-artclinic-patient', [patientController::class, 'list_artclinic_patient'])->name('clinic.list_artclinic_patient');

        Route::get('admin/list-artclinic-patient-view-patient', [patientController::class, 'list_artclinic_patient_quarter_view_patient'])->name('clinic.list_artclinic_patient_quarter_view_patient');

        Route::get('admin/list-artbank-patient-view-patient', [patientController::class, 'list_artbank_patient_quarter_view_patient'])->name('clinic.list_artbank_patient_quarter_view_patient');

        Route::get('admin/list-surrogacy-patient-view-patient', [PatientSurrogacyClinicController::class, 'list_surrogacy_patient_quarter_view_patient'])->name('clinic.list_surrogacy_patient_quarter_view_patient');

        // patient outcome 
        Route::get('admin/list-surrogacy-patient-view-outcome', [PatientSurrogacyClinicController::class, 'list_surrogacy_patient_outcome_view'])->name('clinic.list_surrogacy_patient_outcome_view');
        Route::get('admin/list-artclinic-patient-view-outcome', [patientController::class, 'list_artclinic_patient_view_outcome'])->name('clinic.list_artclinic_patient_view_outcome');
        Route::get('/clinic/outcome/uhids/{encrypted}', [patientController::class, 'showUHIDs_artclinic_outcome'])->name('clinic.outcome.uhids_artclinic');
        Route::get('/clinic/uhid/editPatientArtclinicOutcome/{uhid}', [patientController::class, 'editPatientArtclinicOutcome'])->name('uhid.editPatientArtclinicOutcome');
        Route::post('/clinic/parttwo-artclinic-patient', [patientController::class, 'patientartparttwoapplicationformSubmitpatient'])->name('clinic.patient_save_part_two_application_form_patient');
        Route::post('clinic/patient-part2-detail-form', [patientController::class, 'patient_part2_detail_form'])->name('clinic.patient_part2_detail_form');
        Route::get('clinic/patient-part2-detail-form', [patientController::class, 'patient_part2_detail_form'])->name('clinic.patient_part2_detail_form');

        Route::get('clinic/part2-for-patient-outcome', [patientController::class, 'part2_for_patient_outcome'])->name('clinic.part2_for_patient_outcome');
            //save the Summary set period applications form
        Route::post('clinic/part2-for-patient-outcome-submit', [patientController::class, 'part2_for_patient_outcome_submit'])->name('clinic.part2_for_patient_outcome_submit');

        Route::post('/search-uhidform', [patientController::class, 'searchUhidform'])->name('search.uhid_form');
        Route::get('/search-uhid', [patientController::class, 'searchUhid'])->name('search.uhid');
        Route::post('/clinic/parttwo-artclinic-patientnew', [patientController::class, 'patientartparttwoapplicationformSubmitpatientnew'])->name('clinic.patient_save_part_two_application_form_patientnew');


        Route::get('admin/list-artclinic-patient-view', [patientController::class, 'list_artclinic_patient_quarter_view'])->name('clinic.list_artclinic_patient_quarter_view');

        Route::get('admin/list-artclinicone-patient-view', [patientController::class, 'list_artclinicone_patient_quarter_view'])->name('clinic.list_artclinicone_patient_quarter_view');

        Route::get('admin/list-artbank-patient-view', [patientController::class, 'list_artbank_patient_quarter_view'])->name('clinic.list_artbank_patient_quarter_view');

        Route::get('admin/list-surrogacyclinic-patient-view', [PatientSurrogacyClinicController::class, 'list_surrogacyclinic_patient_quarter_view'])->name('clinic.list_surrogacyclinic_patient_quarter_view');
        // Route::get('admin/list-surrogacyclinic-patient-view', [patientController::class, 'list_surrogacyclinic_patient_quarter_view'])->name('clinic.list_surrogacyclinic_patient_quarter_view');

        // part2 surrogacy routes here
        Route::get('clinic/part2-for-patientsurrogacy-outcome', [patientController::class, 'part2_for_patientsurrogacy_outcome'])->name('clinic.part2_for_patientsurrogacy_outcome');
        Route::post('clinic/part2-for-patientsurrogacy-outcome', [patientController::class, 'part2_for_patientsurrogacy_outcome'])->name('clinic.part2_for_patientsurrogacy_outcome');
        Route::post('/clinic/parttwo-surrogacy-patient-outcome', [patientController::class, 'patientartparttwoapplicationformSubmitpatientSurrogacynew'])->name('clinic.patientartparttwoapplicationformSubmitpatientSurrogacynew');
        Route::get('/clinic/surrogacyoutcome/uhids/{encrypted}', [patientController::class, 'showUHIDs_artsurrogacy_outcome'])->name('clinic.outcome.uhids_surrogacyclinic');
        Route::get('/clinic/uhid/editPatientSurrogacyOutcome/{uhid}', [patientController::class, 'editPatientSurrogacyOutcome'])->name('uhid.editPatientSurrogacyOutcome');
        Route::post('/clinic/parttwo-surrogacy-patient', [patientController::class, 'patientartparttwoapplicationformSubmitpatientsurrogacyoutcome'])->name('clinic.patient_save_part_two_application_form_patientSurrogacy');
        Route::post('clinic/patientsurrogacy-part2-detail-form', [patientController::class, 'patientsurrogacy_part2_detail_form'])->name('clinic.patientsurrogacy_part2_detail_form');
        Route::get('clinic/patientsurrogacy-part2-detail-form', [patientController::class, 'patientsurrogacy_part2_detail_form'])->name('clinic.patientsurrogacy_part2_detail_form');
        Route::get('/search-uhidsurrogacy', [patientController::class, 'searchUhidsurrogacy'])->name('search.uhidsurro');
        Route::post('/search-uhidformsurrogacy', [patientController::class, 'searchUhidSurrogacyform'])->name('search.uhid_formsurrogacy');

        // Show the edit form view for a specific ART clinic report
        Route::get('/clinic/edit-quarter/{id}', [patientController::class, 'editSummaryPatientArtTwo'])->name('edit.quarter');

        Route::get('/clinic/view-quarter/{id}', [patientController::class, 'viewSummaryPatientArtTwo'])->name('view.quarter');

        // Show the edit form view for a specific ART clinic report
        Route::get('/clinic/edit-quarter-one/{id}', [patientController::class, 'editSummaryPatientArtOne'])->name('edit.quarterone');

        Route::get('/clinic/view-quarter-one/{id}', [patientController::class, 'viewSummaryPatientArtOne'])->name('view.quarterone');

        Route::get('/clinic/edit-quarter-bank/{id}', [patientController::class, 'editSummaryPatientbank'])->name('edit.quarterbank');

        Route::get('/clinic/view-quarter-bank/{id}', [patientController::class, 'viewSummaryPatientbank'])->name('view.quarterbank');

        Route::get('/clinic/view-quarter-surrogacy/{id}', [PatientSurrogacyClinicController::class, 'viewSummaryPatientsurrogacy'])->name('view.quartersurrogacy');

        Route::get('/clinic/edit-quarter-surrogacy/{id}', [PatientSurrogacyClinicController::class, 'editSummaryPatientsurrogacy'])->name('edit.quartersurrogacy');
        // POST route for submitting the form and updating
        Route::post('/clinic/update-quarter', [patientController::class, 'summarypatientarttwoapplicationformSubmitedit'])->name('clinic.summary_patient_save_art_two_application_form_edit');

        // POST route for submitting the form and updating
        Route::post('/clinic/update-quarter-one', [patientController::class, 'summarypatientartoneapplicationformSubmitedit'])->name('clinic.summary_patient_save_art_one_application_form_edit');
        // POST route for submitting the form and updating
        Route::post('/clinic/update-quarter-bank', [patientController::class, 'summarypatientbankapplicationformSubmitedit'])->name('clinic.summary_patient_save_bank_application_form_edit');

        // POST route for submitting the form and updating
        Route::post('/clinic/update-quarter-surrogacy', [PatientSurrogacyClinicController::class, 'summarypatientsurrogacyapplicationformSubmitedit'])->name('clinic.summary_patient_save_surrogacy_application_form_edit');


        Route::get('/clinic/quarter/uhids/{encrypted}', [patientController::class, 'showUHIDs_artclinic'])->name('clinic.quarter.uhids_artclinic');

        Route::get('/clinic/quarter-bank/uhids/{encrypted}', [patientController::class, 'showUHIDs_artbank'])->name('clinic.quarter.uhids_artbank');

        Route::get('/clinic/quarter-surrogacy/uhids/{encrypted}', [PatientSurrogacyClinicController::class, 'showUHIDs_surrogacy'])->name('clinic.quarter.uhids_surrogacy');

        Route::get('/clinic/uhid/editPatientArtclinic/{uhid}', [patientController::class, 'editPatientArtclinic'])->name('uhid.editPatientArtclinic');
        Route::get('/clinic/uhid/viewPatientArtclinic/{uhid}', [patientController::class, 'viewPatientArtclinic'])->name('uhid.viewPatientArtclinic');

        Route::get('/clinic/uhid/editPatientArtbank/{uhid}', [patientController::class, 'editPatientArtbank'])->name('uhid.editPatientArtbank');
        Route::get('/clinic/uhid/viewPatientArtbank/{uhid}', [patientController::class, 'viewPatientArtBank'])->name('uhid.viewPatientArtbank');

        Route::get('/clinic/uhid/editPatientsurrogacy/{uhid}', [PatientSurrogacyClinicController::class, 'editPatientsurrogacy'])->name('uhid.editPatientsurrogacy');
        Route::get('/clinic/uhid/viewPatientSurrogacy/{uhid}', [PatientSurrogacyClinicController::class, 'viewPatientSurrogacy'])->name('uhid.viewPatientSurrogacy');

        Route::post('/clinic/update-artclinic-patient', [patientController::class, 'patientartapplicationformSubmiteditpatient'])->name('clinic.patient_save_art_two_application_form_edit_patient');

        Route::post('/clinic/update-surrogacyclinic-patient', [PatientSurrogacyClinicController::class, 'patientsurrogacyapplicationformSubmiteditpatient'])->name('clinic.patient_save_surrogacy_application_form_edit_patient');

        Route::post('/clinic/update-artbank-patient', [patientController::class, 'patientartbankapplicationformSubmiteditpatient'])->name('clinic.patient_save_art_bank_application_form_edit_patient');
        // unlock patient report
        Route::get('/clinic/unlock-patient-report', [patientController::class, 'unlockPatientReport'])->name('clinic.unlock.patient.report');
        Route::post('/clinic/ajax-unlock-patient-report', [patientController::class, 'ajaxUnlockPatientReport'])->name('clinic.ajax.unlock.patient.report');
        Route::post('/clinic/unlock-patient-report-submit', [patientController::class, 'unlockPatientReportSubmit'])->name('clinic.unlock.patient.report.submit');
        // // Update the edited quarter (and possibly other fields)
        // Route::post('/clinic/update-quarter', [patientController::class, 'updateQuarter'])->name('update.quarter');

        // // Save updated quarter
        // Route::post('/clinic/update-quarter', [patientController::class, 'updateQuarter'])
        //     ->name('update.quarter');
        //list of submitted ART aplication form action of registration certifacte upload
        
                //  start 14-05-2026 name change  suman

                Route::get('/clinic/change-name/{encryptedClinicId}',[ClinicNamechangeController::class,'change_name'])->name('clinic.change-name');
                Route::post('/clinic/change-name/delete-document',[ClinicNamechangeController::class, 'deleteDocument'])->name('clinic.change-name.document.delete');
                Route::post('/clinic/change-name-submit',[ClinicNamechangeController::class,'submitChangeName'])->name('clinic.change.name.submit');
                 Route::get('/clinic/change-name-submit',[ClinicNamechangeController::class,'submitChangeName'])->name('clinic.change.name.submit');
                // Route::get('application-view/{encryptedId}',[ClinicNamechangeController::class, 'changeNameFormView'])->name('application.viewcn');

                Route::get('application-view-cn/{encryptedId}', [ClinicNamechangeController::class,  'changeNameFormView'])->name('cn.application.view');

                Route::get('/change-name/{type}', [ClinicAdminChangeNameController::class, 'changeName'])->name('admin.change_name');
                Route::get('/application/{encryptedId}/pdf', [ClinicAdminChangeNameController::class, 'generatePdf'])->name('change_name.ssa.application.pdf');
         
                Route::get('search-change-name/{type}',[ClinicAdminChangeNameController::class, 'searchChangeName']);


                 Route::get('admin/changename_artclinic-ssa-form-list/{id}', [ClinicAdminChangeNameController::class, 'reg_changename_list'])->name('admin.reg_artclinicchange_list');
                   Route::post('admin/changename_artclinic-form', [ClinicAdminChangeNameController::class, 'changename_artclinic_submitForm'])->name('admin.changename_artclinic_submit');

                //  end 14-05-2026 name change 

        

        //check email from database in request from
        Route::post('clinic/bank-check-uhid', [patientController::class, 'bankcheckuhid'])->name('clinic.bankcheckuhid');
        //save the bank form
        Route::post('clinic/patient-bank-application-form-submit', [patientController::class, 'patientbankapplicationformSubmit'])->name('clinic.patient_save_bank_application_form');
        // open the art bank patient form
        Route::get('clinic/bank-patient-application-form', [patientController::class, 'patientbankapplicationform'])->name('clinic.add_patient_bank_application_form');

        // open the art bank patient form
        Route::get('clinic/bank-reporting-patient-application-form', [patientController::class, 'patientreportingbankapplicationform'])->name('clinic.add_reporting_period_patient_bank_application_form');


        // open the art bank patient form
        Route::get('clinic/bank-already-live-reporting-patient-application-form', [patientController::class, 'patientalreadylivereportingbankapplicationform'])->name('clinic.add_reporting_already_live_period_patient_bank_application_form');


        // open the art bank patient form
        Route::get('clinic/surrogacy-already-live-reporting-patient-application-form', [PatientSurrogacyClinicController::class, 'patientalreadylivereportingsurrogacyapplicationform'])->name('clinic.add_reporting_already_live_period_patient_surrogacy_application_form');



        // open the surrogacy patient form
        Route::get('clinic/surrogacy-reporting-patient-application-form', [PatientSurrogacyClinicController::class, 'patientreportingsurrogacyapplicationform'])->name('clinic.add_reporting_period_patient_surrogacy_application_form');


        //save the bank form
        Route::post('clinic/patient-reporting-bank-application-form-submit', [patientController::class, 'patientreportingbankapplicationformSubmit'])->name('clinic.reporting_period_patient_save_bank_application_form');


        //save the bank form
        Route::post('clinic/patient-reporting-surrogacy-application-form-submit', [PatientSurrogacyClinicController::class, 'patientreportingsurrogacyapplicationformSubmit'])->name('clinic.reporting_period_patient_save_surrogacy_application_form');


        //save the bank form
        Route::post('clinic/patient-already-live-reporting-bank-application-form-submit', [patientController::class, 'patientalreadylivereportingreportingbankapplicationformSubmit'])->name('clinic.reporting_already_live_period_patient_save_bank_application_form');

        //save the bank form
        Route::post('clinic/patient-already-live-reporting-surrogacy-application-form-submit', [PatientSurrogacyClinicController::class, 'patientalreadylivereportingreportingsurrogacyapplicationformSubmit'])->name('clinic.reporting_already_live_period_patient_save_surrogacy_application_form');
        // open the art clinic patient form
        Route::get('clinic/clinic-reporting-patient-application-form', [patientController::class, 'patientreportingclinicapplicationform'])->name('clinic.add_reporting_period_patient_clinic_application_form');

        //save the art clinic form
        Route::post('clinic/patient-already-live-reporting-clinic-application-form-submit', [patientController::class, 'patientalreadylivereportingreportingclinicapplicationformSubmit'])->name('clinic.reporting_already_live_period_patient_save_clinic_application_form');

        // open the art bank patient form
        Route::get('clinic/clinic-already-live-reporting-patient-application-form', [patientController::class, 'patientalreadylivereportingclinicapplicationform'])->name('clinic.add_reporting_already_live_period_patient_clinic_application_form');

        //save the clinic form
        Route::post('clinic/patient-reporting-clinic-application-form-submit', [patientController::class, 'patientreportingclinicapplicationformSubmit'])->name('clinic.reporting_period_patient_save_clinic_application_form');


        //view the patient art Bank application form   
        Route::get('clinic/patient-bank-form-view/{id}', [patientController::class, 'patientbankForm_view'])->name('clinic.patientbankForm_view');
        //Report routes- CONSOLIDATED REPORTING art-clinic 1,2 | Surrogacy clinic | Art Bank coded ny manoj
        Route::get('clinic/level-one-art-clinic-report', [ApplicationReportController::class, 'artClinicReport'])->name('clinic.patientart_report');
        Route::post('clinic/level-one-art-clinic-report-filter', [ApplicationReportController::class, 'artClinicReportFilter'])->name('report.artClinicReportFilter');
        
        Route::get('clinic/level-two-art-clinic-report', [ApplicationReportController::class, 'artClinicReportLeveltwo'])->name('clinic.patientart_reportLeveltwo');
        Route::post('clinic/level-two-art-clinic-report-filter', [ApplicationReportController::class, 'artClinicReportLeveltwoFilter'])->name('report.artClinicReporLeveltwotFilter');
        // Surrogacy clinic   
        Route::get('clinic/surrogacy-clinic-report', [ApplicationReportController::class, 'surrogacyClinicReport'])->name('clinic.patiensurrogacyclinic_report');
        Route::post('clinic/surrogacy-clinic-report-filter', [ApplicationReportController::class, 'surrogacyClinicReportFilter'])->name('report.surrogacyClinicReportFilter');
        // Art Bank Report
        Route::get('clinic/artbank-report', [ApplicationReportController::class, 'artbankClinicReport'])->name('clinic.patienartbank_report');
        Route::post('clinic/artbank-clinic-report-filter', [ApplicationReportController::class, 'artbankClinicReportFilter'])->name('report.artbankClinicReportFilter');
        //Format for Quarterly report to be submitted by the State /UT - WORK by manoj
        Route::get('Quarterly-report', [ComprehensiveQuarterlyReportController::class, 'quarterlyReport'])->name('report.Quarterlyreport');       
        Route::post('Quarterly-report-form', [ComprehensiveQuarterlyReportController::class, 'quarterlyReportForm'])->name('report.Quarterlyreportform');
        Route::post('quarterly-report-form-create', [ComprehensiveQuarterlyReportController::class, 'quarterlyReportFormCreate'])->name('report.quarterlyreportformCreate');
        //Format for Quarterly report list - WORK by manoj
        Route::get('Quarterly-report-list/{flagid}', [ComprehensiveQuarterlyReportController::class, 'quarterlyReportList'])->name('report.QuarterlyreportList');  
        Route::get('Quarterly-report-view-ssa/{report_id}', [ComprehensiveQuarterlyReportController::class, 'quarterlyReportViewSsa'])->name('report.Quarterlyreportview');
        Route::get('Quarterly-report-view/{report_id}', [ComprehensiveQuarterlyReportController::class, 'quarterlyReportViewAdmin'])->name('report.QuarterlyreportviewAdmin');
        Route::get('Quarterly-report-pdf/{report_id}', [ComprehensiveQuarterlyReportController::class, 'quarterlyReportPdf'])->name('report.QuarterlyreportPdf');
        Route::get('Upload-Sign-pdf/{report_id}', [ComprehensiveQuarterlyReportController::class, 'quarterlyReportUploadSignpdf'])->name('report.quarterlyReportUploadSignpdf');
       
        Route::post('Quarterly-report-filter', [ComprehensiveQuarterlyReportController::class, 'quarterlyReportFilter'])->name('report.quarterlyreportFilter');
        Route::get('consolidated-Quarterly-report', [ComprehensiveQuarterlyReportController::class, 'ConsolidatedQuarterlyReport'])->name('report.ConsolidatedQuarterlyReport');
     
      Route::post('consolidated-Quarterly-report-filter', [ComprehensiveQuarterlyReportController::class, 'ConsolidatedQuarterlyReportFilter'])->name('report.ConsolidatedQuarterlyReportFilter');
      Route::get('consolidated-Quarterly-Annexure-report/{report}/{type}', [ComprehensiveQuarterlyReportController::class, 'ConsolidatedQuarterlyAnnexureReport'])->name('report.ConsolidatedQuarterlyAnnexureReport');
      Route::get('surrogacy-artclinic-report', [ApplicationReportController::class, 'surrogacyArtClinic'])->name('report.surrogacyArtClinic');
      Route::post('/surrogacy-artclinic-report-filter', [ApplicationReportController::class, 'surrogacyArtClinicFilter'])->name('report.surrogacyArtClinicFilter');
       
      Route::get('/download-patient-details-reports', [PatientReportController::class, 'downloadPatientDetailsReport'])->name('patientreport.downloadPatientReport');
         //search facility for ART Bank by SSA
        Route::get('/admin/list-artbank-patientsearch-Application', [patientController::class, 'list_artbank_patientsearchApplication'])->name('admin.list_artbank_patientsearchApplication');
        // list of art bank patient form
        Route::get('admin/list-artbank-patient', [patientController::class, 'list_artbank_patient'])->name('clinic.list_artbank_patient');
        
        // /search facility for ART Bank by SSA
        //Route::get('/admin/banksearchApplication', [patientController::class, 'banksearchApplication'])->name('admin.banksearchApplication');    



        
       
        
      
        Route::get('admin/artimportdata', [SSAController::class, 'artimportdata'])->name('admin.artimportdata');

        Route::get('admin/surrogacyimportdata', [SSAController::class, 'surrogacyimportdata'])->name('admin.surrogacyimportdata');
       
        // Route::get('admin/artimportdata', [SSAController::class, 'artimportdata'])->name('admin.artimportdata');

        Route::get('admin/artbankimportdata', [SSAController::class, 'artbankimportdata'])->name('admin.artbankimportdata');
       
        //request form for NOC to save the noc user details

        //change password noc user form
        Route::get('noc/password-change', [ChangePasswordController::class, 'showChangePasswordForm'])->name('noc.password.change');
        Route::post('noc/password-changes', [ChangePasswordController::class, 'changePassword'])->name('noc.password.change.post');
        //Route::post('noc/password-change', [ChangePasswordController::class, 'changePassword'])->name('noc.password.change.post');

        //user profile
        Route::get('noc/user-profile', [UserProfileController::class, 'showProfile'])->name('noc.profile');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        //************patient reporting dashboards starts*/
        Route::get('/dashboard/live-clinics/{status}/{type}', [ReportController::class, 'liveClinics'])->name('dashboard.live.clinics');
        Route::post('/dashboard/ajax-mail-live-clinics', [ReportController::class, 'ajaxLiveClinics'])->name('dashboard.ajax.live.clinics');

        Route::get('/dynamic-reporting', [DynamicReportingController::class, 'dashboard'])->name('admin.dynamic.reporting');

        Route::get('/reports/daily-snapshot', [DailySnapshotController::class, 'index'])->name('reports.daily.snapshot');
        // Route::get('/reports/generate-daily-snapshot', [DailySnapshotController::class, 'runDailySnapshot'])->name('reports.generate-daily-snapshot');
        //************patient reporting dashboards ends*/
        // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('check.session');

        //Users Route
        //open the view of add user
        Route::get('admin/add-new', [UserTableController::class, 'add_new'])->name('admin.add_user');
        //add the user data into database
        Route::Post('admin/add-user', [UserTableController::class, 'add_user_store'])->name('admin.add_user_store');



        Route::get('admin/list-user', [UserTableController::class, 'user_list'])->name('admin.user_list');


        //add user role
        Route::get('admin/add-user-role', [UserTableController::class, 'add_user_role'])->name('admin.add_user_role');
        Route::Post('admin/add-user-role-store', [UserTableController::class, 'add_user_role_store'])->name('admin.add_user_role_store');

        //assign the role to the user
        Route::get('admin/add-user-role-access', [UserTableController::class, 'add_user_role_access'])->name('admin.add_user_role_access');
        Route::Post('admin/add-user-role-access-store', [UserTableController::class, 'add_user_role_access_store'])->name('admin.add_user_role_access_store');

        //list of the user with role
        Route::get('admin/user-list-role', [UserTableController::class, 'user_list_noc_role'])->name('admin.user_list_noc_role');

        //add service view form
        Route::get('admin/add-service', [UserTableController::class, 'add_service'])->name('admin.add_service');

        Route::post('admin/add_service_data', [UserTableController::class, 'add_service_data'])->name('admin.add_service_data');

        //assign service to the user view page
        Route::get('admin/assign-service', [UserTableController::class, 'assign_service'])->name('admin.assign_service');

        //add service entered into the database
        Route::post('admin/assign-service-data', [UserTableController::class, 'assign_service_data'])->name('admin.assign_service_data');

        //send the user with service for approval (view)
        Route::get('admin/list-user-service', [UserTableController::class, 'list_service_approval'])->name('admin.list_service_approval');


        //send the user with service for approval
        Route::get('admin/send-approval/{id}', [UserTableController::class, 'service_approval'])->name('admin.service_approval');

        //send the user with service for approval
        Route::post('admin/logout', [UserTableController::class, 'logout'])->name('logout');

        //send the user with service for approval (view)- accept the approval
        Route::get('admin/list-accept-user', [UserTableController::class, 'list_accept_approval'])->name('admin.list_accept_approval');

        Route::get('/admin/accept-approval/{id}', [UserTableController::class, 'accept_approval'])->name('admin.accept_approval');

        Route::get('/admin/reject-approval/{id}', [UserTableController::class, 'reject_approval'])->name('admin.reject_approval');


        //Admin profile


        //change Admin password
        Route::get('admin/password-change', [ChangePasswordController::class, 'adminChangePasswordForm'])->name('admin.password.change');
        Route::post('admin/password-changes', [ChangePasswordController::class, 'adminchangePassword'])->name('admin.password.change.post');
        Route::get('admin/surrogacy_list', [DataTableController::class, 'surrogacy_list'])->name('admin.surrogacy_list');
        
              Route::middleware(['checkuser.session'])->group(function () {

            Route::get('/noc/front_user_attachment/{id}/{level_id}', [NOCController::class, 'front_user_attachment'])->name('front_user_attachment');

            Route::get('/noc/front_user_attachment_foreigner/{id}/{level_id}', [NocServiceController::class, 'front_user_attachment_foreigner'])->name('front_user_attachment_foreigner');
            
            Route::get('noc/myapplication', [NOCController::class, 'myapplication'])->name('noc.myapplication');

            Route::get('noc/myapplication_foreigner', [NocServiceController::class, 'myapplication_foreigner'])->name('noc.myapplication_foreigner');

            Route::get('noc/noc_genrate_list_user', [NOCController::class, 'noc_genrate_list_user'])->name('noc.noc_genrate_list_user');

            Route::get('/noc/view_user_form/{application_id}/{level_id}', [NOCController::class, 'view_user_form'])->name('view_user_form');

            // Route::get('/noc/view_user_form_foreigner/{application_id}/{level_id}', [NOCController::class, 'view_user_form_foreigner'])->name('view_user_form');

            Route::get('/noc/view_user_form_foreigner/{application_id}/{level_id}', [NocServiceController::class, 'view_user_form_foreigner'])->name('view_user_form_foreigner');

            Route::get('/noc/back_user_attachment/{id}/{level_id}', [NOCController::class, 'back_user_attachment'])->name('back_user_attachment');

            Route::post('/noc/add_user_remarks/', [NOCController::class, 'add_user_remarks'])->name('add_user_remarks')->middleware('xss');


            Route::post('/noc/add_user_remarks_foreigner/', [NocServiceController::class, 'add_user_remarks_foreigner'])->name('add_user_remarks_foreigner')->middleware('xss');

            Route::get('/noc/view_user_application/{id}/{level_id}', [NOCController::class, 'view_user_application'])->name('view_user_application');

            Route::get('/noc/view_user_application_foreigner/{id}/{level_id}', [NocServiceController::class, 'view_user_application_foreigner'])->name('view_user_application_foreigner');

            Route::get('/noc/view_user_remarks/{id}/{level_id}', [NOCController::class, 'view_user_remarks'])->name('view_user_remarks');

            Route::get('/noc/view_user_remarks_foreigner/{id}/{level_id}', [NocServiceController::class, 'view_user_remarks_foreigner'])->name('view_user_remarks_foreigner');

        
            
            Route::post('noc/logout', [NOCController::class, 'logout'])->name('noc.logout');

            //after login open the noc user dashboard
            // Route::get('noc/noc-dashboard', [NOCController::class, 'nocdashboard'])->name('noc.dashboard');
            Route::get('noc/noc-dashboard', [DashboardDataNocController::class, 'nocdashboard'])->name('noc.dashboard');


            // Route to show the profile update form
            Route::get('/profile/update', [NOCController::class, 'showUpdateForm'])->name('noc.profile.update');

            // Route to handle the profile update form submission
            Route::post('/profile/update', [NOCController::class, 'updateProfile'])->name('noc.profile.update.submit');



            //after login click on application form and open the application form
            Route::get('noc/application-form', [NOCController::class, 'nocapplicationform'])->name('noc.add_noc_application_form');

            Route::get('noc/application-form-foreigner', [NocForiegnerController::class, 'nocforeignerapplicationform'])->name('noc.add_noc_foreigner_app_form');

            //fetch pincode in the noc form through pincode table
            Route::post('noc/pincode', [NOCController::class, 'checkPincode'])->name('pincode.check');

            //fetch pincode in the noc form through pincode table

            //Route::post('clinic/pincodeclinic', [NOCController::class, 'checkPincodesignup'])->name('pincodesignup.check');


            Route::post('noc/fetch-clinic-data', [NOCController::class, 'fetchClinicData'])->name('noc.fetchClinicData');
            Route::post('noc/fetch-clinic-data-from', [NOCController::class, 'fetchClinicDataFrom'])->name('noc.fetchClinicDataFrom');;

            //save the noc form
            Route::Post('noc/application-form-data', [NOCController::class, 'nocapplicationformData'])->name('noc.add_noc_application_form_data');

            // fetch the clinic data to clinic
            Route::post('/noc-clinic-fetch', [NOCController::class, 'fetchClinicDetails'])->name('noc.fetchClinicDetails');
            Route::post('/noc-clinic-fetch-app', [NOCController::class, 'fetchClinicApplicationDetails'])->name('noc.fetchClinicApplicationDetails');

            // fetch the clinic data from clinic
            Route::post('/fetch-clinic-data-fromm', [NOCController::class, 'fetchClinicDataFromm'])->name('noc.fetchClinicDataFromm');
            Route::post('/noc-clinic-fetch-app-from', [NOCController::class, 'nocClinicFetchAppFrom'])->name('noc.nocClinicFetchAppFrom');

            //submit noc form
            Route::post('noc/noc-form', [NOCController::class, 'submitForm'])->name('noc.nocsubmit');

            Route::post('noc/noc-foreigner-form', [NocForiegnerController::class, 'submitForm'])->name('noc.nocforeignersubmit');

            //list of submitted aplication form
            Route::get('noc/noc-form-list', [NOCController::class, 'nocForm_list'])->name('noc.nocForm_list');

            Route::get('noc/noc-form-list-foreigner', [NocServiceController::class, 'nocForm_list_foreigner'])->name('noc.nocForm_list_foreigner');

            Route::get('noc/noc-form-foreigner-list', [NocForiegnerController::class, 'nocForm_list_foriener'])->name('noc.nocForm_foreigner_list');

            //view the noc form
            Route::get('noc/noc-form-view/{id}', [NOCController::class, 'nocForm_view'])->name('noc.nocForm_view');

            Route::get('noc/noc-form-foreigner-view/{id}', [NocForiegnerController::class, 'nocFormnocFormForeigner_view'])->name('noc.nocFormnocFormForeigner_view');
            
            Route::get('/files/{filename}', [NOCController::class, 'getFile']);

            //make pdf of noc application form
            Route::get('/download-pdf/{filename}', [NOCController::class, 'downloadPDF'])->name('download-pdf');

            Route::get('noc/application-pdf/{id}', [NOCController::class, 'nocgeneratePdf'])->name('noc.nocgeneratePdf');

            // 30-07-2025---Route::get('noc/application-pdf /{id}', [AdminController::class, 'nocgeneratePdf'])->name('noc.nocgeneratePdf');
            Route::get('admin/application-pdf/{id}', [AdminController::class, 'nocgeneratePdf'])->name('noc.nocgeneratePdf');

            Route::get('noc/application-foreigner-pdf/{id}', [NocServiceController::class, 'nocgenerate_foreigner_Pdf'])->name('noc.nocgenerate_foreigner_Pdf');
            
        });
        Route::middleware(['check.session'])->group(function () {

            Route::get('admin/admin-profile', [UserProfileController::class, 'adminshowProfile'])->name('admin.adminprofile');
            Route::get('ssa/ssa-profile', [UserProfileController::class, 'ssashowProfile'])->name('ssa.ssaprofile');

            Route::get('admin/noc_page', [AdminController::class, 'noc_page'])->name('admin.noc_details');

            Route::get('admin/pendency_report_view', [AdminController::class, 'pendency_report_view'])->name('admin.pendency_report');

            Route::get('admin/noc_page_foreigner', [AdminServiceController::class, 'noc_page_foreigner'])->name('admin.noc_details_foreigner');

            Route::post('/ajax-request', [AjaxController::class, 'handleRequest'])->middleware('xss');

            Route::post('/ajax-request-foreigner', [AjaxController::class, 'handleRequestForeigner'])->middleware('xss');

            Route::post('/ajax-request-archive', [AjaxController::class, 'ArchivehandleRequest'])->middleware('xss');

            Route::post('/ajax-request-approve', [AjaxController::class, 'ArchivehandleApprove'])->middleware('xss');

            Route::get('/admin/view_noc_page/{application_id}/{level_id}', [AdminController::class, 'view_noc_page'])->name('view_noc_page');

            Route::get('/admin/view_noc_page_foreigner/{application_id}/{level_id}', [AdminServiceController::class, 'view_noc_page_foreigner'])->name('view_noc_page');

            Route::post('/admin/add_remarks/', [AdminController::class, 'add_remarks'])->name('add_remarks')->middleware('xss');

            Route::post('/admin/add_remarks_foreigner/', [AdminServiceController::class, 'add_remarks_foreigner'])->name('add_remarks_foreigner')->middleware('xss');

            Route::get('/admin/view_application/{id}', [AdminController::class, 'view_application'])->name('view_application');

            Route::get('/admin/view_application_foreigner/{id}', [AdminServiceController::class, 'view_application_foreigner'])->name('view_application_foreigner');

            Route::get('/admin/front_attachment/{id}', [AdminController::class, 'front_attachment'])->name('front_attachment');

            Route::get('/admin/front_attachment_foreigner/{id}', [AdminServiceController::class, 'front_attachment_foreigner'])->name('front_attachment_foreigner');

            Route::get('/admin/back_attachment/{id}', [AdminController::class, 'back_attachment'])->name('back_attachment');

            Route::get('/admin/back_attachment_foreigner/{id}', [AdminServiceController::class, 'back_attachment_foreigner'])->name('back_attachment_foreigner');

            Route::get('/admin/view_remarks/{id}', [AdminController::class, 'view_remarks'])->name('view_remarks');

            Route::get('/admin/view_remarks_foreigner/{id}', [AdminServiceController::class, 'view_remarks_foreigner'])->name('view_remarks_foreigner');

            Route::post('/admin/back_attach/', [AdminController::class, 'back_attach'])->name('back_attach')->middleware('xss');

            Route::get('noc/noc_page', [AdminController::class, 'noc_page'])->name('noc.noc_details');

            Route::post('/admin/nocgenrate/', [AdminController::class, 'nocgenrate'])->name('nocgenrate')->middleware('xss');

            Route::post('/admin/nocgenrate_foreigner/', [AdminServiceController::class, 'nocgenrate_foreigner'])->name('nocgenrate_foreigner')->middleware('xss');

            //generate NOC pdf
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::post('/fetch-applications', [DataTableController::class, 'fetchApplications'])->name('fetch.applications');
            Route::post('/unfetch-applications', [DataTableController::class, 'unfetchApplications'])->name('unfetch.applications');
            // archive section//
            Route::get('admin/art_clinic', [DataTableController::class, 'art_clinic'])->name('admin.art_clinic');
            Route::get('admin/art_clinic_ajax', [DataTableController::class, 'art_clinic_ajax'])->name('admin.art_clinic_ajax');
            
            Route::get('admin/art_bank', [DataTableController::class, 'art_bank'])->name('admin.art_bank');
            Route::get('admin/art_bank_ajax', [DataTableController::class, 'art_bank_ajax'])->name('admin.art_bank_ajax');


            //approval //
            Route::get('admin/surrogacy_request', [DataTableController::class, 'surrogacy_request'])->name('admin.surrogacy_request');
            Route::get('admin/unsurrogacy_request', [DataTableController::class, 'unsurrogacy_request'])->name('admin.unsurrogacy_request');
            Route::post('admin/surrogacy_request', [DataTableController::class, 'surrogacy_remark'])->name('admin.surrogacy_remark');
            Route::post('admin/unsurrogacy_request', [DataTableController::class, 'unsurrogacy_remark'])->name('admin.unsurrogacy_remark');

            Route::get('admin/surrogacy_request_ajax', [DataTableController::class, 'surrogacy_request_ajax'])->name('admin.surrogacy_request_ajax');
            Route::get('admin/archive_work_request/{id}', [DataTableController::class, 'archive_work_request'])->name('admin.archive_work_request');
            Route::post('/admin/add_archive_approve', [DataTableController::class, 'add_archive_approve'])->name('add_archive_approve');

            Route::get('admin/list_archive', [DataTableController::class, 'list_archive'])->name('admin.list_archive');
            Route::get('admin/doe-correction', [DataTableController::class, 'doe_correction'])->name('admin.doe_correction');

            Route::get('admin/doe_estb', [DataTableController::class, 'doe_estb'])->name('admin.doe_estb');
            Route::post('/admin/update-estb-dates', [DataTableController::class, 'updateEstbDates'])->name('admin.updateEstbDates');
            Route::post('/admin/update-dates', [DataTableController::class, 'updateDates'])->name('admin.updateDates');
            //end approval//
            
            Route::get('admin/surrogacy_details_view', [DataTableController::class, 'index'])->name('admin.surrogacy_details_view');
            Route::get('admin/surrogacy_details_ajax', [DataTableController::class, 'surrogacy_details_ajax'])->name('admin.surrogacy_details_ajax');

            Route::get('admin/art_clinic_detail_ajax', [DataTableController::class, 'art_clinic_detail_ajax'])->name('admin.art_clinic_detail_ajax');

            Route::get('admin/archive_work/{id}', [DataTableController::class, 'archive_work'])->name('admin.archive_work');

            Route::get('admin/unarchive_work', [DataTableController::class, 'unarchive_work'])->name('admin.unarchive_work');

            Route::get('admin/archive_work', [DataTableController::class, 'archive_work'])->name('admin.archive_work');
            Route::get('admin/fetchArchive', [DataTableController::class, 'fetchArchive'])->name('admin.fetchArchive');


            Route::get('admin/unfetchArchive', [DataTableController::class, 'unfetchArchive'])->name('admin.unfetchArchive');
            // Route::get('admin/unarchive_work/{id}', [DataTableController::class, 'unarchive_work'])->name('admin.unarchive_work');
            Route::post('/admin/add_unarchive', [DataTableController::class, 'add_unarchive'])->name('add_unarchive');
            Route::post('/admin/add_archive', [DataTableController::class, 'add_archive'])->name('add_archive');

            // Archive Section End//
            

            Route::get('admin/get_submit_application_ajax', [DataTableController::class, 'get_submit_application_ajax'])->name('admin.get_submit_application_ajax');

            Route::get('admin/get_total_query_raised', [DataTableController::class, 'get_total_query_raised'])->name('admin.get_total_query_raised'); 

            Route::get('admin/get_Query_Responce_ajax', [DataTableController::class, 'get_Query_Responce_ajax'])->name('admin.get_Query_Responce_ajax'); 

            Route::get('admin/get_noc_issue_ajax', [DataTableController::class, 'get_noc_issue_ajax'])->name('admin.get_noc_issue_ajax'); 

            //archive view section
            Route::get('/admin/view-applications', [DataTableController::class, 'viewApplications'])->name('admin.view_applications');
            Route::post('/admin/view-archive-application/show', [DataTableController::class, 'showApplication'])->name('admin.view_archive_application.show');

          

            Route::get('/application/pdf/{clinicType}/{applicationNo}', function ($encryptedClinicType, $encryptedApplicationNo) {
            try {
                $clinicType = Crypt::decrypt($encryptedClinicType);
                $applicationNo = Crypt::decrypt($encryptedApplicationNo);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                abort(404, 'Invalid or tampered link.');
            }

            $request = new Request([
                'clinic_type' => $clinicType,
                'application_no' => $applicationNo,
            ]);

            return app(\App\Http\Controllers\DataTableController::class)->showApplication($request, true);
        })->name('application.pdf');

            Route::get('admin/application-pdf/{id}', [AdminController::class, 'nocgeneratePdf'])->name('admin.nocgeneratePdf');

            Route::get('admin/application-foreigner-pdf/{id}', [AdminServiceController::class, 'nocgenerateforeignerPdf'])->name('admin.nocgenerateforeignerPdf');

            Route::get('noc/noc-pdf/{id}', [AdminController::class, 'nocPdf'])->name('noc.nocPdf');

            Route::get('admin/noc-foreigner-pdf/{id}', [AdminServiceController::class, 'nocforeignerPdf'])->name('admin.noc-foreigner-pdf');

        });
    });

Route::Post('/request-form', [SignupNocUser::class, 'requestNocSignUpData'])->name('noc.request_noc_signup_data');
Route::get('/signup-send-otp', [SignupUser::class, 'showOtpForm_clinic'])->name('clinic.showOtpForm_clinic');
Route::post('/signup-veryfy-otp', [SignupUser::class, 'verifyclinicOtpLogin'])->name('clinic.verifyclinicOtpLogin');


//login form for Signup user
Route::get('/login-clinic', [SignupUser::class, 'showLoginForm_clinic'])->name('clinic.loginclinicform');

//capacha implement on login singup page
Route::get('/reload-captcha-clinic', [SignupUser::class, 'reloadCaptchaclinic'])->name('clinic.reloadCaptcha');
//clinic profile

//login form for noc user save the data into the database
Route::Post('/login-clinic-data', [SignupUser::class, 'showLoginForm_clinic_data'])->name('clinic.loginclinicformdata');

//forget the user passwordart/signup-reset-password
Route::get('/signup-forgot-password', [SignupUser::class, 'signupshowForgotPasswordForm'])->name('password.request_signup');
Route::post('/signup-forgot-password', [SignupUser::class, 'signupsendResetLinkEmail'])->name('password.email_signup');


//capacha implement on otp page
Route::get('/reload-captcha-forget', [SignupUser::class, 'forgetreloadCaptcha'])->name('noc.forgetreloadCaptcha');

//reset the clinic user password
Route::get('signup-reset-password', [SignupUser::class, 'signupshowResetForm'])->name('password.reset_signup');
Route::post('signup-reset-password', [SignupUser::class, 'signupresetPassword'])->name('password.update_signup');

Route::get('signup-reset-password_ssa', [SSAController::class, 'signupshowResetForm'])->name('password.reset_signup_ssa');
Route::post('signup-reset-password_ssa', [SSAController::class, 'signupresetPassword'])->name('password.update_signup_ssa');
// Route::post('')

//login form for State appropriate authority
Route::get('/login-ssa', [SSAController::class, 'showLoginForm_ssa'])->name('admin.loginssaform');

//login form for SSA user save the data into the database
Route::Post('/login-ssa-data', [SSAController::class, 'showLoginForm_ssa_data'])->name('admin.loginssaformdata');

//2 way Authentication
Route::get('/ssa-send-opt', [SSAController::class, 'showOtpForm_ssa'])->name('admin.showOtpForm_ssa');
Route::post('/ssa-veryfy-otp', [SSAController::class, 'verifyssaOtpLogin'])->name('admin.verifyssaOtpLogin');

//Route::get('/ssa-dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('admin/store-sha-password', [SSAController::class, 'storeShaPass'])->name('admin.storeShaPass');



Route::post('noc/store-sha-password', [SignupNocUser::class, 'storeShaPass'])->name('noc.storeShaPass');


// NOC part
//request form for NOC
 Route::get('/noc-signup', [SignupNocUser::class, 'requestNocSignUp'])->name('noc.request_noc_signup');

//capacha implement on request form
Route::get('/reload-captcha-request', [SignupNocUser::class, 'requestreloadCaptcha'])->name('noc.requestreloadCaptcha');



//check email from database in request from
Route::post('/check-email-noc', [SignupNocUser::class, 'checkEmailnoc'])->name('noc.checkEmail');



//capacha implement on verified form
Route::get('/reload-captcha-verified', [SignupNocUser::class, 'verifiedreloadCaptcha'])->name('noc.verifiedreloadCaptcha');



//login form for noc user
Route::get('/login-noc', [SignupNocUser::class, 'showLoginForm_noc'])->name('noc.loginnocform');

//capacha implement on login noc page
Route::get('/reload-captcha', [SignupNocUser::class, 'reloadCaptchanoc'])->name('noc.reloadCaptcha');


//2 way Authentication
Route::get('/send-otp', [SignupNocUser::class, 'showOtpForm_noc'])->name('noc.showOtpForm_noc');
Route::post('/veryfy-otp', [SignupNocUser::class, 'verifyNocOtpLogin'])->name('noc.verifyNocOtpLogin');
//capacha implement on otp page
Route::get('/reload-captcha-otp', [SignupNocUser::class, 'otpreloadCaptcha'])->name('noc.otpreloadCaptcha');

//login form for noc user save the data into the database
Route::Post('/login-noc-data', [SignupNocUser::class, 'showLoginForm_noc_data'])->name('noc.loginnocformdata');

//forget the user password
Route::get('/forgot-password', [SignupNocUser::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [SignupNocUser::class, 'sendResetLinkEmail'])->name('password.email');

// forget password for admin

Route::get('admin/forgot-password', [ChangePasswordController::class, 'adminforgetPasswordForm'])->name('admin_password.request');
Route::post('admin/forgot-password', [ChangePasswordController::class, 'adminforgetPassword'])->name('admin_password.email');
//reset the noc user password
Route::get('admin/forgot-password-request', [ChangePasswordController::class, 'adminforgetPasswordRequestForm'])->name('admin_password.reset');
Route::post('admin/forgot-password-request', [ChangePasswordController::class, 'adminforgetPasswordRequest'])->name('admin_password.update');

//capacha implement on otp page
Route::get('/reload-captcha-forget', [SignupNocUser::class, 'forgetreloadCaptcha'])->name('noc.forgetreloadCaptcha');

//reset the noc user password
Route::get('reset-password', [SignupNocUser::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [SignupNocUser::class, 'resetPassword'])->name('password.update');





//logout


//generate NOC pdf
// Route::get('noc/noc-pdf/{id}', [NOCController::class, 'nocPdf'])->name('noc.nocPdf');

Route::get('files/{filename}', function ($filename) {
    $path = 'D:/xampp/htdocs/noc_documents'.$filename;
    
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    return response($file, 200)->header("Content-Type", $type);
});


Route::get('/publickey', function () {
    return response(
        file_get_contents(storage_path('app/rsa/public.key')),
        200
    )->header('Content-Type', 'text/plain');
})->middleware('ajax.only');


// Admin part 
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login', [AuthController::class, 'login'])->name('post.login');

//capacha implement on admin login page
Route::get('/reload-captcha-admin', [AuthController::class, 'adminreloadCaptcha'])->name('admin.adminreloadCaptcha');

Route::get('/signup-submitted-message', [SignupUser::class, 'signup_submiited_msg'])->name('clinic.signup_submiited_msg');


Route::post('clinic_pincodeclinic', [NOCController::class, 'checkPincodesignup'])->name('pincode.signup');


Route::get('/view-file/{path}', function ($encryptedPath) {

    // $userId = Session::get('id');
    // $adminId = Session::get('userid');

    // if (empty($userId) || empty($adminId)) {
    //      Session::flush();
    //     return redirect('/');
    // }

    try {

        $relativePath = Crypt::decrypt($encryptedPath); 
        $parts = explode('/', $relativePath, 6); 
        //dd($parts);
        $application_no = $parts[3]; 
        $subFolder = $parts[4];    
        $fileName   = $parts[5] ?? ''; // Remaining part (e.g. myfile.pdf)
        $mainFolder = realpath(base_path('../webprodfiles/noc_application'));
        switch ($subFolder) {
            case 'applicant':
                // $baseDirectory = "D:/xampp/artprojfiles/htdocs/artprojfiles/noc_application/{$application_no}/applicant/";
                $baseDirectory = $mainFolder. '/' . $application_no. '/'. $subFolder;
                break;
            case 'registry':
                $baseDirectory = $mainFolder. '/' . $application_no. '/'. $subFolder;
                break;
            default:
                return redirect()->route('dashboard');
        }
 
        $fullPath = $baseDirectory . '/' . $fileName;
        // dd($fullPath);
        if (!$fullPath) {
        //   abort(403, 'Unauthorized file access.');
            dd('route1');
            //Session::flush();
             return redirect()->route('dashboard');
        }
    

        }catch(\Exception $e){
           // abort(403, 'Invalid file path.');
           dd('route2');
            // Session::flush();
             return redirect()->route('dashboard');
        }

        if(!file_exists($fullPath)){
     //   abort(404, 'File not found.');
            dd('route3');
            // Session::flush();
            return redirect()->route('dashboard');
        }
        
        $mimeType = mime_content_type($fullPath);
        $fileContent = file_get_contents($fullPath);
        $fileName = basename($fullPath);

        return Response::make($fileContent, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
        })->name('view.file');

//     Route::get('/proxy-check', function (\Illuminate\Http\Request $request) {
//     return [
//         'url' => $request->fullUrl(),
//         'scheme' => $request->getScheme(), // http or https
//         'host' => $request->getHost(),
//         'ip' => $request->ip(),
//         'server' => $_SERVER,
//     ];
// });

Route::get('/debug-back', function () {
    return [
        'referer_header' => request()->headers->get('referer'),
        'x_forwarded_proto' => request()->headers->get('x-forwarded-proto'),
        'x_forwarded_host' => request()->headers->get('x-forwarded-host'),
        'host' => request()->getHost(),
        'scheme' => request()->getScheme(),
        'previous_url' => url()->previous(),
    ];
});

 

// Change address routes @start(04-05-2026) // Jitendra Kumar
Route::prefix('change-address')->name('change_address.')->group(function () {
Route::controller(ChangeAddressController::class)->group(function () {
    Route::get('application/{encryptedClinicId}', 'changeAddressForm')->name('application_form');
    Route::post('application-form', 'submitChangeAddressForm')->name('submit_application');
    Route::get('success/{encryptedId}', 'changeAddressSuccess')->name('application.success');
    Route::get('application-view/{encryptedId}', 'changeAddressFormView')->name('application.view');
});
Route::controller(ChangeAddressSSAController::class)->group(function () {
    Route::get('{clinicType}/list', 'ChangeAddressClinicList')->name('clinic_list');
    Route::get('{clinicType}/search', 'changeAddressSearch')->name('ssa.search_application');

    // Receiving application (Dashboard)
    Route::get('{clinicType}/application-rec/{encryptedId}', 'changeAddressRec')->name('ssa_application_rec');
    Route::post('{encryptedClinicType}-receive-clinic-submit', 'receiveClinicSubmit')->name('receive_clinic_submit');
    Route::post('application/cash-details', 'getAmountdetails')->name('get_amount_details');

    Route::get('application/{encryptedId}/view', 'applicationView')->name('ssa.application.view');
    Route::get('application/{encryptedId}/pdf', 'generatePdf')->name('ssa.application.pdf');
    Route::get('application/{encryptedId}', 'showClinicView')->name('ssa.application.show');
    Route::get('{clinicType}/change_address/{clinic_id}', 'clinicChangeAddlList')->name('cliniList');
    
    // Decision for Approved/Reject (sidebar)
    Route::get('list/{clinicType}', 'showClinicList')->name('registration.clinic_list');
    Route::get('{encryptedClinicType}-ssa-application-reg/{encryptedId}', 'changeAddressReg')->name('ssa_application_reg');
    Route::post('submit', 'submitChangeAddressReg')->name('register.submit');

    });
});
// Change address routes @end(04-05-2026) // Jitendra Kumar
Route::prefix('manpower')->group(function() {
    Route::get('change-manpower-application-form/{encryptedClinicId}',[ChangeManpowerController::class, 'changeManpowerForm'])->name('manpower.change_manpower_form');
    Route::post('submit-change-manpower-application', [ChangeManpowerController::class, 'submitChangeManpowerApplication'])->name('manpower.submit_change_manpower_application');
    Route::get('change-manpower-application-pdf/{encryptedClinicId}',[ChangeManpowerController::class, 'pdfview'])->name('manpower.change_manpower_form.pdf');
    //ssa side route
    Route::get('change-manpower-clinic-list/{clinicType}', [ChangeManpowerSSAController::class, 'changeManpowerSSAForm'])->name('change_manpower.clinic_list');
    Route::get('art-change-manpower-form-view/{encryptedId}',[ChangeManpowerSSAController::class, 'ssaChangeManpowerView'])->name('manpower.ssaChangeManpowerView');
    Route::get('{clinicType}-ssa-search-application', [ChangeManpowerSSAController::class, 'changeManpowerSearchApplication'])->name('changemanpower.ssa_search_application');
    Route::get('{encryptedClinicType}-ssa-application-reg/{encryptedId}', [ChangeManpowerSSAController::class, 'changeManpowerApplicationReg'])->name('changemanpower.ssa_application_reg');
    Route::post('clinic-submit', [ChangeManpowerSSAController::class, 'applicationChangeManpowerSubmit'])->name('changemanpower.applicationChangeManpowerSubmit');

});
// Change address routes @start(04-06-2026) // Jitendra Kumar

Route::controller(ClinicWithdrawalController::class)->group(function () {
    Route::get('withdrawal-form/{encryptedClinicId}', 'withdrawalClinicForm')->name('withdrawal.application_form');
    Route::post('submit-withdrawal-form/{encryptedClinicId}', 'submitWithdrawal')->name('submit_withdrawal.application_form');
    Route::get('withdrawal-application-view/{encryptedClinicId}', 'applicationViewAndPDF')->name('withdrawal.application_view');
    // Route::get('withdrawal-application-pdf/{encryptedClinicId}', 'applicationViewPdf')->name('withdrawal.application_pdf');
    Route::post('/withdrawal/cancel-request', 'cancelRequest')->name('withdrawal.cancel.request');
});

Route::prefix('withdrawal')->name('withdrawal.')->controller(ClinicWithdrawalSAController::class)->group(function () {

    Route::get('{clinicType}/search', 'applicationSearch')->name('ssa.search_application');
    Route::get('list/{clinicType}', 'showClinicList')->name('sa.clinic_list');
    Route::get('{encryptedClinicType}-ssa-application-reg/{encryptedId}', 'withdrawalReg')->name('ssa.application_reg');
    Route::post('submit', 'submitWithdrawalReg')->name('sa.register.submit');
    Route::get('application-view/{encryptedId}', 'applicationViewAndPDF')->name('ssa.application.view');

});

Route::prefix('suspension')->name('suspension.')->controller(ClinicSuspensionSAController::class)->group(function () {

    Route::get('suspension-clinic-list/{encryptedClinicId}', 'clinicList')->name('sa.clinic_list');
    Route::get('suspension-form/{encryptedClinicId}', 'suspensionForm')->name('sa.application_form');

    Route::post('submit-suspension-form/{encryptedClinicId}', 'submitSuspension')->name('sa.submit_application');


});

Route::prefix('revocation')->name('revocation.')->controller(ClinicRevocationSAController::class)->group(function () {

    Route::get('revocation-clinic-list/{encryptedClinicId}', 'revocationClinicList')->name('sa.clinic_list');
    Route::get('revocation-form/{encryptedClinicId}', 'revocationForm')->name('sa.application_form');

    Route::post('submit-revocation-form/{encryptedClinicId}', 'submitRevocation')->name('sa.submit_application');

});

  Route::prefix('admin')->group(function () {
    Route::get('daily-report', [DailyReportController::class, 'dailyReport'])->name('admin.daily_report');
    Route::post('daily-report-preview', [DailyReportController::class, 'dailyPreview'])->name('admin.daily_report_preview');
    Route::get('daily-report-snapshot', [DailyReportController::class, 'dailyReportSnapshot'])->name('admin.daily_report_snapshot');

});
