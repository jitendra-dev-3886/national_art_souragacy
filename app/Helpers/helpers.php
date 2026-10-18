<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

if (!function_exists('generateRandomNumber')) {
    function generateRandomNumber($length = 9)
    {
        $min = (int)str_pad('1', $length, '0');
        $max = (int)str_pad('', $length, '9');
        return mt_rand($min, $max);
    }
}


if (!function_exists('getApplicationBaseUrl')) {
    function getApplicationBaseUrl()
    {
        $folderName = basename(base_path());
        $string  = url('/');
        $newUrl  = str_replace("/$folderName", "", $string);
        return "$newUrl/artprojfiles/application_sa/";
    }
}

function sanitizeFolderName($name)
{
    // Replace invalid characters with a dash
    return preg_replace('/[\/:*?"<>|]/', '-', trim($name));
}

   

function status_name($level_id){
    $action_code = DB::table('service_meta_work_flow_table')
                   ->where('level_id', $level_id)
                   ->where('service_id', 1)
                   ->value('flow_status');

    return $action_code ? $action_code : 'Not available';
}

function extractCountryCode($input)
{
    $input = '+91 India';

    // Option 1: Using explode
    $parts = explode(' ', $input);
    $code = $parts[0]; // "+91"

    return $code;
}


// function folderpath($foldername){

//     switch ($foldername) {
//         case 'clinic_registration_certificate':
//                 return base_path('../artprojfiles/clinic_registration_certificate');
//              break;

//         case "application_sa":
//                 return base_path('../artprojfiles/application_sa/');
//              break;
        
//         case "art_clinic_receipt_no":
//                 return base_path('../art_clinic_receipt_no');
//              break;

//         case "application_state_authorities":
//                 return base_path('../application_state_authorities');
//              break;
             
//     }
// }

function folderpath($foldername)
    {
        // Get htdocs path (one level up from Laravel project root)
        $htdocsPath = realpath(base_path('..'));

        switch ($foldername) {
            case 'clinic_registration_certificate':
                return $htdocsPath . '/webprodfiles/clinic_registration_certificate/'; //
                break;

            case "application_sa":
                return $htdocsPath . '/webprodfiles/application_sa/'; //
                break;
            case "clinic_application":
                return $htdocsPath . '/webprodfiles/clinic_application/'; //
                break; 
            case "art_clinic_receipt_no":
                return $htdocsPath . '/webprodfiles/art_clinic_receipt_no/';
                break;

            case "application_state_authorities":
                return $htdocsPath . '/webprodfiles/application_state_authorities/';
                break;
            case "clinicaccesschange":
                return $htdocsPath . '/webprodfiles/clinicaccesschange/'; //
                break;
            case "noc_application":
                return $htdocsPath . '/webprodfiles/noc_application/'; //
                break;
            
            case "noc_documents":
                return $htdocsPath . '/webprodfiles/noc_documents/'; 
                break;

            case "surrogacy_patient_medical_docs":
                return $htdocsPath . '/webprodfiles/surrogacy_patient_medical_docs/'; //
                break;
            case "comprehensive_quaterly_state_report":
                return $htdocsPath . '/webprodfiles/comprehensive_quaterly_state_report/'; //
                break;
            case "clinic_registration_certificate_blade":
                return '/webprodfiles/clinic_registration_certificate/';
                break;
            case "application_sa_blade":
                return '/webprodfiles/application_sa/'; //
                break;

            case "surrogacy_patient_medical_docs_blade":
                return '/webprodfiles/surrogacy_patient_medical_docs/';
                break;
            case "noc_application_blade":
                return '/webprodfiles/noc_application/'; //
                break;
            case "ssaresetpassword":
                return $htdocsPath . '/webprodfiles/ssaresetpassword';
            break;
            case "clinicaccesschange_blade":
                return '/webprodfiles/clinicaccesschange/';
            break;
            case "comprehensive_quaterly_state_report_blade":
                return '/webprodfiles/comprehensive_quaterly_state_report/'; //
                break;
            default:
                return '/webprodfiles/defaultfiles/';
        }
    }

function status_name_foreigner($level_id){
    $action_code = DB::table('service_meta_work_flow_table')
                   ->where('level_id', $level_id)
                   ->where('service_id', 6)
                   ->value('flow_status');

    return $action_code ? $action_code : 'Not available';
}

function status_level($level_id){
    $action_code = DB::table('service_meta_work_flow_table')
                   ->where('level_id', $level_id)
                   ->value('level_id');

    return $action_code ? $action_code : 'Not available';
}

function status_level_foreigner($level_id){
    $action_code = DB::table('service_meta_work_flow_table')
                   ->where('level_id', $level_id)
                   ->where('service_id', 6)
                   ->value('level_id');

    return $action_code ? $action_code : 'Not available';
}

function country($id){
    $action_code = DB::table('apps_countries')
                   ->where('id', $id)
                   ->value('country_name');

    return $action_code ? $action_code : 'Not available';
}

function state($val){
    $action_code = DB::table('state')
                   ->where('state_name', $val)
                   ->value('state_id');

    return $action_code ? $action_code : 'Not available';
}



function previoucs_date_wfd($appId,$pre_level){
    $action_code = DB::table('work_flow_table')
                   ->where('level_id', $pre_level)
                   ->where('service_id', 1)
                   ->where('application_id', $appId)
                   ->value('action_date');


    return $action_code ? $action_code : 'Not available';
}


function previoucs_date_wfd_foreigner($appId,$pre_level){
    $action_code = DB::table('work_flow_table')
                   ->where('level_id', $pre_level)
                   ->where('service_id', 6)
                   ->where('application_id', $appId)
                   ->value('action_date');


    return $action_code ? $action_code : 'Not available';
}


function get_doc_file_name($docid){
    $action_code = DB::table('doc_masters')
                   ->where('id', $docid)
                   ->value('doc_desc');

    return $action_code ? $action_code : 'Not available';
}

function get_noc_path($appId){
    $action_code = DB::table('noc_genrate_table')
                   ->where('app_id', $appId)
                   ->value('path');

    return $action_code ? $action_code : '';
}

function get_user_name($appId){
    $action_code = DB::table('user_request_table')
                   ->where('id', $appId)
                   ->value('user_name');
    // test
    return $action_code ? $action_code : '';
}

function get_noc_user_id_foreigner($appId){
    $action_code = DB::table('noc_form_foreigners')
                   ->where('id', $appId)
                   ->value('noc_userid');
    // test
    return $action_code ? $action_code : '';
}

function get_noc_user_id($appId){

    $action_code = DB::table('noc_form')
                   ->where('id', $appId)
                   ->value('noc_userid');

    return $action_code ? $action_code : '';
}

function UserMailGet($userid){

    $action_code = DB::table('user_request_table')
                   ->where('id', $userid)
                   ->value('email');

    return $action_code ? $action_code : '';
}


function clinicName($clinicid){

    $action_code = DB::table('signup')
                   ->where('id', $clinicid)
                   ->value('clinicname');

    return $action_code ? $action_code : '';
}

function username($userid){

    $action_code = DB::table('user_table')
                   ->where('userid', $userid)
                   ->value('username');

    return $action_code ? $action_code : '';
}

function username_request_table($userid){

    $action_code = DB::table('user_request_table')
                   ->where('id', $userid)
                   ->value('user_name');

    return $action_code ? $action_code : '';
}







function date_of_noc($appId){
    $action_code = DB::table('noc_genrate_table')
                   ->where('app_id', $appId)
                   ->value('created_at');

    return $action_code ? $action_code : '';
}


function doc_type($dcoId){
    $action_code = DB::table('doc_masters')
                   ->where('id', $dcoId)
                   ->value('doc_type');

    return $action_code ? $action_code : '';
}

function doc_desc($dcoId){
    $action_code = DB::table('doc_masters')
                    ->where('id', $dcoId)
                    ->orderBy('doc_master_id', 'asc') // or 'desc'
                    ->value('doc_desc');

    return $action_code ? $action_code : '';
}

function app_no($id){
    $action_code = DB::table('noc_form')
                   ->where('id', $id)
                   ->value('application_no');

    return $action_code ? $action_code : '';
}

function app_no_foreigner($id){
    $action_code = DB::table('noc_form_foreigners')
                   ->where('id', $id)
                   ->value('application_no');

    return $action_code ? $action_code : '';
}

function user_details($id,$level_id,$appId){
    $action_code = DB::table('work_flow_table')
                   ->leftjoin('user_table', 'user_table.userid', '=', 'work_flow_table.user_id')
                   ->leftjoin('noc_form', 'work_flow_table.user_id', '=', 'noc_form.noc_userid')
                   ->where('work_flow_table.application_id', $appId)
                   ->get();

    return $action_code ? $action_code : '';
}

function user_details_foreigner($id,$level_id,$appId){
    $action_code = DB::table('work_flow_table')
                   ->leftjoin('user_table', 'user_table.userid', '=', 'work_flow_table.user_id')
                   ->leftjoin('noc_form_foreigners', 'work_flow_table.user_id', '=', 'noc_form_foreigners.noc_userid')
                   ->where('work_flow_table.application_id', $appId)
                   ->get();

    return $action_code ? $action_code : '';
}

function getlevelid($level_id, $application_id, $service_id) {
    $action_code = DB::table('work_flow_table')
                        ->where('level_id', $level_id)
                        ->where('application_id', $application_id)
                        ->where('service_id', $service_id)
                        ->orderBy('id', 'desc') 
                        ->limit(1) 
                        ->first();

    return $action_code ? $action_code : 'Not available';
}




if (!function_exists('getActor')) {
    function getActor($appId) {
        // Define default values
        $levelId = 2;
        $serviceId = 1;
    
        // Assuming nextActor is a function that returns some actors based on levelId, appId, and serviceId
        $getData = nextActor($levelId, $appId, $serviceId);
    
        // Check if getData is an array
        if (is_array($getData) && count($getData) > 0) {
            // Implode the array into a comma-separated string
            $userIds = implode(',', $getData);
        } else {
            // If nextActor does not return an array or it's empty, return an empty array or handle accordingly
            return [];
        }
    
        // Fetch user data from the database using `whereIn` method
        try {
            //$userData = DB::table('user_table')->whereIn('user_id', explode(',', $userIds))->get();
            $userData = DB::table('user_table')
                ->whereIn('userid', explode(',', $userIds))
                ->get()
                ->toArray();
        } catch (\Exception $e) {
            // Handle potential database connection issues or query errors
            return ['error' => 'Failed to fetch user data: ' . $e->getMessage()];
        }
    
        // Generate the options HTML dynamically
         $html = ''; // Placeholder for dropdown
        foreach ($userData as $value) {
            // Assuming 'user_id' is the unique identifier for each user, and 'username' is the user name
            $html .= '<option value="' . $appId . '-' . $levelId . '-' . $value->userid . '-' . $serviceId . '">' . htmlspecialchars($value->username) . '</option>';
        }
    
        // Return the generated HTML options
        return $html;
    }
}

if (!function_exists('getActor_foreigner')) {
    function getActor_foreigner($appId) {
        // Define default values
        $levelId = 2;
        $serviceId = 1;
    
        // Assuming nextActor is a function that returns some actors based on levelId, appId, and serviceId
        $getData = nextActor($levelId, $appId, $serviceId);
    
        // Check if getData is an array
        if (is_array($getData) && count($getData) > 0) {
            // Implode the array into a comma-separated string
            $userIds = implode(',', $getData);
        } else {
            // If nextActor does not return an array or it's empty, return an empty array or handle accordingly
            return [];
        }
    
        // Fetch user data from the database using `whereIn` method
        try {
            //$userData = DB::table('user_table')->whereIn('user_id', explode(',', $userIds))->get();
            $userData = DB::table('user_table')
                ->whereIn('userid', explode(',', $userIds))
                ->get()
                ->toArray();
        } catch (\Exception $e) {
            // Handle potential database connection issues or query errors
            return ['error' => 'Failed to fetch user data: ' . $e->getMessage()];
        }
    
        // Generate the options HTML dynamically
         $html = ''; // Placeholder for dropdown
        foreach ($userData as $value) {
            // Assuming 'user_id' is the unique identifier for each user, and 'username' is the user name
            $html .= '<option value="' . $appId . '-' . $levelId . '-' . $value->userid . '-' . $serviceId . '">' . htmlspecialchars($value->username) . '</option>';
        }
    
        // Return the generated HTML options
        return $html;
    }
}
    

function nextActor($levelId, $appId, $serviceId) {

        $noRecord = "No records found.";
        $noActionCode = "No action code found.";
        $actionCode = DB::table('service_meta_work_flow_table')
                        ->where('level_id', $levelId)
                        ->where('service_id', $serviceId)
                        ->value('action_code');

        if (!$actionCode) {
            return $noRecord;
        }
   // dd($actionCode);
    
    switch ($actionCode) {
        case 1001:
                $userId = DB::table('approve_authority_table as at')
                            ->join('user_roles_access_table as ut', 'at.user_id', '=', 'ut.user_id')
                            ->where('ut.role_id', 4)
                            ->where('at.service_id', $serviceId)
                            ->where('at.is_active', 2)
                            ->value('at.user_id');
              if($userId){
                  return $userId ? $userId : $noRecord;
               } else {
                 return $noActionCode;
             }

        case 1002:
         
                
                $role_id = 5;
                //Get user_ids from service_examination_table for examiners
                $user_ids = DB::table('approve_authority_table AS at')
                    ->join('user_roles_access_table AS ut', 'at.user_id', '=', 'ut.user_id')
                    ->where('ut.role_id', $role_id)
                    ->where('at.service_id', $serviceId)
                    ->where('at.is_active', 2)
                    ->pluck('at.user_id');
            // Check if there are any user IDs
            if ($user_ids->isNotEmpty()) {
                return $user_ids->toArray(); // Return the user IDs as an array
            } else {
                return 'no_record'; // Return a no record message if no IDs found
            }
        

        case 1003:

            if ($actionCode == 1003) {
                
                // Get user_id from approve_authority_table assuming single authority
                $userId = DB::table('approve_authority_table as at')
                            ->join('user_roles_access_table as ut', 'at.user_id', '=', 'ut.user_id')
                            ->where('ut.role_id', 4)
                            ->where('at.service_id', $serviceId)
                            ->where('at.is_active', 2)
                            ->value('at.user_id');

                return $userId ? $userId : $noRecord;
            } else {
                return $noActionCode;
            }

        case 1004:
            if($serviceId == 1){
            if ($actionCode == 1004) {
                $userId = DB::table('noc_form')
                            ->where('id', $appId)
                            ->value('noc_userid');

                return $userId ? $userId : $noRecord;
            } else {
                return $noActionCode;
            }
        }else if($serviceId == 6){
            if ($actionCode == 1004) {
                $userId = DB::table('noc_form_foreigners')
                            ->where('id', $appId)
                            ->value('noc_userid');

                return $userId ? $userId : $noRecord;
            } else {
                return $noActionCode;
            }
        }

        case 1005: 
                $userId = DB::table('approve_authority_table as at')
                            ->join('user_roles_access_table as ut', 'at.user_id', '=', 'ut.user_id')
                            ->where('ut.role_id', 4)
                            ->where('at.service_id', $serviceId)
                            ->where('at.is_active', 2)
                            ->value('at.user_id');
                if($userId){
                     return $userId ? $userId : $noRecord;
                 } else {
                   return $noActionCode;
                 }

        case 1006:
           
                // Get user_id from work_flow_table based on application_id and level_id
                $userId = DB::table('work_flow_table')
                            ->where('service_id', $serviceId)
                            ->where('application_id', $appId)
                            ->where('level_id', 2)
                            ->value('user_id');
                
                if($userId){
                   return $userId ? $userId : $noRecord;
                } else {
                return $noActionCode;
                }

               
        case 1007:
            if ($actionCode == 1007) {
                // Get user_id from approve_authority_table assuming single authority
                $userId = DB::table('approve_authority_table as at')
                            ->join('user_roles_access_table as ut', 'at.user_id', '=', 'ut.user_id')
                            ->where('ut.role_id', 4)
                            ->where('at.service_id', $serviceId)
                            ->where('at.is_active', 2)
                            ->value('at.user_id');

                return $userId ? $userId : $noRecord;
            } else {
                return $noActionCode;
            }


        case 1011:
                if ($actionCode == 1011) {
                    // Get user_id from approve_authority_table assuming single authority
                    $userId = DB::table('approve_authority_table as at')
                                ->join('user_roles_access_table as ut', 'at.user_id', '=', 'ut.user_id')
                                ->where('ut.role_id', 7)
                                ->where('at.service_id', $serviceId)
                                ->where('at.is_active', 2)
                                ->value('at.user_id');
    
                    return $userId ? $userId : $noRecord;
                } else {
                    return $noActionCode;
                }


        case 2001:
                    $userId = DB::table('approve_authority_table as at')
                        ->join('user_roles_access_table as ut', 'at.user_id', '=', 'ut.user_id')
                        ->where('ut.role_id', 69)
                        ->where('at.service_id', 5)
                        ->where('at.is_active', 2)
                        ->value('at.user_id');
                    if ($userId) {
                        return $userId ? $userId : $noRecord;
                    } else {
                        return $noActionCode;
                    }
        
        case 2002:
        
                    //Get user_ids from service_examination_table for examiners
                    $userId = DB::table('approve_authority_table AS at')
                        ->join('user_roles_access_table AS ut', 'at.user_id', '=', 'ut.user_id')
                        ->where('ut.role_id', 71)
                        ->where('at.service_id', 5)
                        ->where('at.is_active', 2)
                        ->value('at.user_id');
                    // Check if there are any user IDs
                    if ($userId) {
                        return $userId ? $userId : $noRecord;
                    } else {
                        return $noActionCode;
                    }
        
        
        case 2003:
                        $userId = DB::table('approve_authority_table as at')
                            ->join('user_roles_access_table as ut', 'at.user_id', '=', 'ut.user_id')
                            ->where('ut.role_id', 69)
                            ->where('at.service_id', 5)
                            ->where('at.is_active', 2)
                            ->value('at.user_id');
                        if ($userId) {
                            return $userId ? $userId : $noRecord;
                        } else {
                            return $noActionCode;
                        }
        
        case 2004:
                        $userId = DB::table('approve_authority_table as at')
                            ->join('user_roles_access_table as ut', 'at.user_id', '=', 'ut.user_id')
                            ->where('ut.role_id', 71)
                            ->where('at.service_id', 5)
                            ->where('at.is_active', 2)
                            ->value('at.user_id');
                        if ($userId) {
                            return $userId ? $userId : $noRecord;
                        } else {
                            return $noActionCode;
                        }
        
        
        if (in_array($actionCode, [1008, 1009, 1010])) 
        {
            return 'NULL'; // No user_id for these levels (internal committee, external committee, apex committee)
            } else {
                    return $noActionCode;
            }

        if (in_array($actionCode, [1008, 1009, 1010])) {
                return 'NULL'; // No user_id for these levels (internal committee, external committee, apex committee)
        } else {
            return $noActionCode;
        }

        default:
            return "Invalid level_id";
    }

       
       
}



