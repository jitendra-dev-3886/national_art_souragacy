<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class NocAjax extends Model
{
    use HasFactory;

    public function submit_application_ajax($start, $length, $search)
    {
        $submit_application = DB::table('noc_form as nof')
            ->leftJoin('work_flow_table as wft', 'wft.application_id', '=', 'nof.id')
            ->where('wft.level_id', '=', 1);
           

        // Apply filter to the query for the search
        $submit_application_filter = DB::table('noc_form as nof')
            ->leftJoin('work_flow_table as wft', 'wft.application_id', '=', 'nof.id')
            ->where('nof.name_applicant', 'like', '%' . $search . '%')
            ->where('wft.level_id', '=', 1)
            ->offset($start)
            ->limit($length)
            ->get();

        $total_records = $submit_application->count();
        return [
            'total_records' => $total_records,
            'data' => $submit_application_filter,
            'recordsTotal' => $total_records,
            'recordsFiltered' => $submit_application_filter->count(),
        ];
    }


    public function get_total_query_raised_ajax($start, $length, $search)
    {
        $submit_application = DB::table('noc_form as nof')
            ->leftJoin('work_flow_table as wft', 'wft.application_id', '=', 'nof.id')
            ->where('wft.level_id', '!=', 1)
            ->where('wft.level_id', '!=', 10)
            ->where('wft.level_id', '!=', 11);

        // Apply filter to the query for the search
        $submit_application_filter = DB::table('noc_form as nof')
            ->leftJoin('work_flow_table as wft', 'wft.application_id', '=', 'nof.id')
            ->where('nof.name_applicant', 'like', '%' . $search . '%')
            ->where('wft.level_id', '!=', 1)
            ->where('wft.level_id', '!=', 10)
            ->where('wft.level_id', '!=', 11)
            ->offset($start)
            ->limit($length)
            ->get();

        $total_records = $submit_application->count();
        return [
            'total_records' => $total_records,
            'data' => $submit_application_filter,
            'recordsTotal' => $total_records,
            'recordsFiltered' => $submit_application_filter->count(),
        ];
    }


    public function noc_issue_ajax($start, $length, $search)
    {
        $submit_application = DB::table('noc_form as nof')
            ->leftJoin('work_flow_table as wft', 'wft.application_id', '=', 'nof.id')
            ->where('wft.level_id', '=', 11);

        // Apply filter to the query for the search
        $submit_application_filter = DB::table('noc_form as nof')
            ->leftJoin('work_flow_table as wft', 'wft.application_id', '=', 'nof.id')
            ->where('nof.name_applicant', 'like', '%' . $search . '%')
            ->where('wft.level_id', '=', 11)
            ->offset($start)
            ->limit($length)
            ->get();

        $total_records = $submit_application->count();
        return [
            'total_records' => $total_records,
            'data' => $submit_application_filter,
            'recordsTotal' => $total_records,
            'recordsFiltered' => $submit_application_filter->count(),
        ];
    }

    public function Query_Responce_ajax($start, $length, $search)
    {
        $submit_application = DB::table('noc_form as nof')
            ->leftJoin('work_flow_table as wft', 'wft.application_id', '=', 'nof.id')
            ->whereBetween('wft.level_id', ['3', '9']);

        // Apply filter to the query for the search
        $submit_application_filter = DB::table('noc_form as nof')
            ->leftJoin('work_flow_table as wft', 'wft.application_id', '=', 'nof.id')
            ->where('nof.name_applicant', 'like', '%' . $search . '%')
            ->whereBetween('wft.level_id', ['3', '9'])
            ->offset($start)
            ->limit($length)
            ->get();

        $total_records = $submit_application->count();
        return [
            'total_records' => $total_records,
            'data' => $submit_application_filter,
            'recordsTotal' => $total_records,
            'recordsFiltered' => $submit_application_filter->count(),
        ];
    }

    
}
