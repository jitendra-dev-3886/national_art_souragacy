<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function handleRequest(Request $request)
    {
       
        $app_id    = $request->input('app_id');
        $level_id  = $request->input('level_id');
        $user_id   = $request->input('user_id');
        $serviceid = $request->input('serviceid');
        $action_taken_by = status_name($level_id);
     
  

        $pre_level = $level_id - 1;
        $recieving_date  = previoucs_date_wfd($app_id,$pre_level);
       // dd($recieving_date);

        DB::table('work_flow_table')
            ->where('level_id', $pre_level)
            ->where('service_id', $serviceid)
            ->where('application_id', $app_id)
            ->update([
                'remarks'         => 'Application Assigned',
                'is_active'       => 'NO',
                'action_date'      => Carbon::now()->format('Y-m-d H:i:s')
            ]);


        DB::table('work_flow_table')->insert([
            'application_id'    => $app_id,
            'level_id'          => $level_id,
            'user_id'           => $user_id,
            'service_id'        => $serviceid,
            'action_taken_by'   => $action_taken_by,
            'is_active'         => 'YES',
            'submission_date'   => Carbon::now()
        ]);
        return true;
    }


    public function handleRequestForeigner(Request $request)
    {
       
        $app_id    = $request->input('app_id');
        $level_id  = $request->input('level_id');
        $user_id   = $request->input('user_id');
        $serviceid = $request->input('serviceid');
        $action_taken_by = status_name_foreigner($level_id);
     
  

        $pre_level = $level_id - 1;
        $recieving_date  = previoucs_date_wfd_foreigner($app_id,$pre_level);
       // dd($recieving_date);

        DB::table('work_flow_table')
            ->where('level_id', $pre_level)
            ->where('service_id', $serviceid)
            ->where('application_id', $app_id)
            ->update([
                'remarks'         => 'Application Assigned',
                'is_active'       => 'NO',
                'action_date'      => Carbon::now()->format('Y-m-d H:i:s')
            ]);


        DB::table('work_flow_table')->insert([
            'application_id'    => $app_id,
            'level_id'          => $level_id,
            'user_id'           => $user_id,
            'service_id'        => $serviceid,
            'action_taken_by'   => $action_taken_by,
            'is_active'         => 'YES',
            'submission_date'   => Carbon::now()
        ]);
        return true;
    }

    
}
