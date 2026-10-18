<?php

namespace App\Models\Noc;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class UserNoc extends Model

{
    
    public function myapplication($uid)
    {
        $submitappication =  DB::table('noc_form')
        ->leftjoin('work_flow_table', 'work_flow_table.application_id', '=', 'noc_form.id')
        ->where('work_flow_table.level_id', '=', 1)
        ->where('noc_form.noc_userid', '=', $uid)
        ->select('noc_form.id','noc_form.application_no', 'noc_form.transfer', 
        'noc_form.noc_userid', 'noc_form.transfer', 'noc_form.transfer_of', 'noc_form.address',
        'noc_form.state',
        'noc_form.district',
        'noc_form.created_at',
        'work_flow_table.application_id', 
        'work_flow_table.level_id',
        )
        ->orderBy('noc_form.id', 'desc')
        ->get();

        return $submitappication;
    }


    public function myapplication_foreigner($uid)
    {
        $submitappication =  DB::table('noc_form_foreigners')
        ->leftjoin('work_flow_table', 'work_flow_table.application_id', '=', 'noc_form_foreigners.id')
        ->where('work_flow_table.level_id', '=', 1)
        ->where('noc_form_foreigners.noc_userid', '=', $uid)
        ->select('noc_form_foreigners.id','noc_form_foreigners.application_no', 'noc_form_foreigners.transfer', 
        'noc_form_foreigners.noc_userid', 'noc_form_foreigners.transfer', 'noc_form_foreigners.transfer_of', 'noc_form_foreigners.address',
        'noc_form_foreigners.state',
        'noc_form_foreigners.district',
        'noc_form_foreigners.created_at',
        'work_flow_table.application_id', 
        'work_flow_table.level_id',
        )
        ->orderBy('noc_form_foreigners.id', 'desc')
        ->get();

        return $submitappication;
    }

    public function noc_genrate_view($uid)
    {
       // dd($uid);
        @$noc_genrate_data =  DB::table('noc_form')
        ->leftjoin('noc_genrate_table', 'noc_genrate_table.app_id', '=', 'noc_form.id')
        ->where('noc_genrate_table.noc_user_id', '=', $uid)
        ->get();
       // dd($noc_genrate_data);
        return $noc_genrate_data;
    }

    public function myapplication_query_raised($uid)
    {

     $queryraised = DB::table(DB::raw('(
       SELECT m.application_id, m.level_id, m.user_id, m.action_taken_by, 
              ROW_NUMBER() OVER (PARTITION BY m.application_id ORDER BY m.id DESC) AS rn
       FROM work_flow_table AS m
   ) AS submitted_application'))
       ->join('noc_form AS nf', 'submitted_application.application_id', '=', 'nf.id')
       ->where('submitted_application.rn', 1)
       ->where('submitted_application.user_id', $uid)
       ->where('submitted_application.level_id', '=', 4)
       ->select('submitted_application.application_id', 'submitted_application.level_id', 'submitted_application.user_id', 
                'submitted_application.action_taken_by', 'submitted_application.rn', 'nf.*')
       ->get();

       return $queryraised;
    }

    public function myapplication_query_raised_foreigner($uid)
    {

     $queryraised = DB::table(DB::raw('(
       SELECT m.application_id, m.level_id, m.service_id, m.user_id, m.action_taken_by, 
              ROW_NUMBER() OVER (PARTITION BY m.application_id ORDER BY m.id DESC) AS rn
       FROM work_flow_table AS m
   ) AS submitted_application'))
       ->join('noc_form AS nf', 'submitted_application.application_id', '=', 'nf.id')
       ->where('submitted_application.rn', 1)
       ->where('submitted_application.service_id', 6)
       ->where('submitted_application.user_id', $uid)
       ->where('submitted_application.level_id', '=', 4)
       ->select('submitted_application.application_id', 'submitted_application.service_id', 'submitted_application.level_id', 'submitted_application.user_id', 
                'submitted_application.action_taken_by', 'submitted_application.rn', 'nf.*')
       ->get();

       return $queryraised;
    }
}
