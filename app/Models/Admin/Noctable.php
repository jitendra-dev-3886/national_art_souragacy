<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Noctable extends Model
{
    use HasFactory;

    // Specify the correct table name
    protected $table = 'user_roles_access_table';

    // Fillable fields for mass assignment
    protected $fillable = [
        'user_id',
        'role_id',
        'created_by',
        'deactivated_by',
        'is_active',
    ];

    // If needed, you might want to hide sensitive fields like passwords in API responses
    // protected $hidden = ['password'];

    /**
     * Get the action list for a specific user
     *
     * @return \Illuminate\Support\Collection
     */
    public function assignee()
    {
        // $uid = session()->get('uid');
        $uid = session()->get('userid');
        //dd($uid);
        $getdata_noc_data = DB::table(DB::raw('
        (
            SELECT m.application_id, m.level_id, m.user_id, m.action_taken_by,m.submission_date,
            ROW_NUMBER() OVER (PARTITION BY m.application_id ORDER BY m.id DESC) AS rn
            FROM work_flow_table AS m
        ) AS submitted_application
       '))
            ->join('noc_form AS nf', 'submitted_application.application_id', '=', 'nf.id')
            ->where('submitted_application.rn', 1)
            ->where('submitted_application.level_id', 1)
            ->where('submitted_application.user_id', $uid)
            ->select(
                'submitted_application.application_id',
                'submitted_application.level_id',
                'submitted_application.user_id',
                'submitted_application.action_taken_by',
                'submitted_application.rn',
                'submitted_application.submission_date',
                'nf.*'
            )
            ->orderBy('nf.id', 'desc')
            ->get();
        //dd($getdata_noc_data);
        return $getdata_noc_data;
    }

    public function action_list()
    {
        $uid = Session::get('userid');
        $getdata_noc_data = DB::table(DB::raw('
            (SELECT m.application_id, m.level_id, m.user_id, m.action_taken_by, m.submission_date,m.action_date,
                    ROW_NUMBER() OVER (PARTITION BY m.application_id ORDER BY m.id DESC) AS rn
            FROM work_flow_table AS m) AS submitted_application
        '))
            ->join('noc_form as nf', 'submitted_application.application_id', '=', 'nf.id')
            ->where('submitted_application.rn', 1)
            ->where('submitted_application.level_id', '!=', 1)
            ->where('submitted_application.level_id', '!=', 4)
            // ->where('submitted_application.level_id',  '=', 7)
            ->where('submitted_application.level_id', '!=', 8)
            ->where('submitted_application.level_id', '!=', 9)
            ->where('submitted_application.level_id', '!=', 10)
            ->where('submitted_application.level_id', '!=', 11)
            ->where('submitted_application.user_id', $uid)
            ->select(
                'submitted_application.application_id',
                'submitted_application.level_id',
                'submitted_application.user_id',
                'submitted_application.action_taken_by',
                'submitted_application.submission_date',
                'submitted_application.action_date',
                'submitted_application.rn',
                'nf.*'
            )
            ->orderBy('submitted_application.submission_date', 'desc')
            ->get();

        return $getdata_noc_data;
    }


      public function pendency_list()
    {
    $uid = Session::get('userid');
    //DB::enableQueryLog();
    $getdata_noc_data = DB::table('work_flow_table as wft')
                                ->join('noc_form as nf', 'wft.application_id', '=', 'nf.id')
                                ->select(
                                    'nf.*',
                                    'wft.application_id',
                                    'wft.level_id',
                                    'wft.user_id',
                                    'wft.action_taken_by',
                                    'wft.submission_date',
                                    'wft.is_active',
                                    'wft.action_date'
                                )
                                ->where('wft.is_active', '!=', 'NO')
                                ->where('wft.service_id', 1)
                                ->orderByDesc('wft.submission_date')
                                ->get();

    //dd(DB::getQueryLog());

        return $getdata_noc_data;
    }


    public function get_list_marked_for_approval()
    {
        $uid = session()->get('userid');
        $getdata_noc_data = DB::table(DB::raw('
            (SELECT m.application_id, m.level_id, m.user_id, m.action_taken_by, m.submission_date,m.action_date,
                    ROW_NUMBER() OVER (PARTITION BY m.application_id ORDER BY m.id DESC) AS rn
            FROM work_flow_table AS m) AS submitted_application
        '))
            ->join('noc_form as nf', 'submitted_application.application_id', '=', 'nf.id')
            ->where('submitted_application.rn', 1)
            
            ->where('submitted_application.level_id', '!=', 7)
            ->where('submitted_application.level_id', '=', 8)
            ->where('submitted_application.level_id', '!=', 9)
            ->where('submitted_application.level_id', '!=', 10)
            ->where('submitted_application.level_id', '!=', 11)
            ->where('submitted_application.level_id', '!=', 12)
            
            
            ->select(
                'submitted_application.application_id',
                'submitted_application.level_id',
                'submitted_application.user_id',
                'submitted_application.action_taken_by',
                'submitted_application.submission_date',
                'submitted_application.action_date',
                'submitted_application.rn',
                'nf.*'
            )
            ->orderBy('submitted_application.submission_date', 'desc')
            ->get();

        return $getdata_noc_data;
    }

    public function get_list_park_for_internal()
    {
        $uid = session()->get('userid');
        $getdata_noc_data = DB::table(DB::raw('
            (SELECT m.application_id, m.level_id, m.user_id, m.action_taken_by, m.submission_date,m.action_date,
                    ROW_NUMBER() OVER (PARTITION BY m.application_id ORDER BY m.id DESC) AS rn
            FROM work_flow_table AS m) AS submitted_application
        '))
            ->join('noc_form as nf', 'submitted_application.application_id', '=', 'nf.id')
            ->where('submitted_application.rn', 1)
            ->where('submitted_application.level_id', '!=', 7)
            ->where('submitted_application.level_id', '!=', 8)
            ->where('submitted_application.level_id', '=', 9)
            ->where('submitted_application.level_id', '!=', 10)
            ->where('submitted_application.level_id', '!=', 11)
            ->where('submitted_application.level_id', '!=', 12)
            ->where('submitted_application.user_id', $uid)
            ->select(
                'submitted_application.application_id',
                'submitted_application.level_id',
                'submitted_application.user_id',
                'submitted_application.action_taken_by',
                'submitted_application.submission_date',
                'submitted_application.action_date',
                'submitted_application.rn',
                'nf.*'
            )
            ->orderBy('submitted_application.submission_date', 'desc')
            ->get();

        return $getdata_noc_data;
    }

    public function get_Park_for_external_committeit()
    {
        $uid = session()->get('userid');
        $getdata_noc_data = DB::table(DB::raw('
            (SELECT m.application_id, m.level_id, m.user_id, m.action_taken_by, m.submission_date,m.action_date,
                    ROW_NUMBER() OVER (PARTITION BY m.application_id ORDER BY m.id DESC) AS rn
            FROM work_flow_table AS m) AS submitted_application
        '))
            ->join('noc_form as nf', 'submitted_application.application_id', '=', 'nf.id')
            ->where('submitted_application.rn', 1)
            ->where('submitted_application.level_id', '!=', 7)
            ->where('submitted_application.level_id', '!=', 8)
            ->where('submitted_application.level_id', '!=', 9)
            ->where('submitted_application.level_id', '=', 10)
            ->where('submitted_application.level_id', '!=', 11)
            ->where('submitted_application.level_id', '!=', 12)
            ->where('submitted_application.user_id', $uid)
            ->select(
                'submitted_application.application_id',
                'submitted_application.level_id',
                'submitted_application.user_id',
                'submitted_application.action_taken_by',
                'submitted_application.submission_date',
                'submitted_application.action_date',
                'submitted_application.rn',
                'nf.*'
            )
            ->orderBy('submitted_application.submission_date', 'desc')
            ->get();

        return $getdata_noc_data;
    }

    public function get_Park_for_Appex_Commity()
    {
        $uid = session()->get('userid');
        $getdata_noc_data = DB::table(DB::raw('
            (SELECT m.application_id, m.level_id, m.user_id, m.action_taken_by, m.submission_date,m.action_date,
                    ROW_NUMBER() OVER (PARTITION BY m.application_id ORDER BY m.id DESC) AS rn
            FROM work_flow_table AS m) AS submitted_application
        '))
            ->join('noc_form as nf', 'submitted_application.application_id', '=', 'nf.id')
            ->where('submitted_application.rn', 1)
            ->where('submitted_application.level_id', '!=', 7)
            ->where('submitted_application.level_id', '!=', 8)
            ->where('submitted_application.level_id', '!=', 9)
            ->where('submitted_application.level_id', '!=', 10)
            ->where('submitted_application.level_id', '=', 11)
            ->where('submitted_application.level_id', '!=', 12)
            ->where('submitted_application.user_id', $uid)
            ->select(
                'submitted_application.application_id',
                'submitted_application.level_id',
                'submitted_application.user_id',
                'submitted_application.action_taken_by',
                'submitted_application.submission_date',
                'submitted_application.action_date',
                'submitted_application.rn',
                'nf.*'
            )
            ->orderBy('submitted_application.submission_date', 'desc')
            ->get();

        return $getdata_noc_data;
    }

    public function get_list_final_approval()
    {
        $uid = session()->get('userid');

        //dd($uid);
        $getdata_noc_data = DB::table(DB::raw('
            (SELECT m.application_id, m.level_id, m.is_active, m.user_id, m.action_taken_by, m.submission_date,m.action_date,
                    ROW_NUMBER() OVER (PARTITION BY m.application_id ORDER BY m.id DESC) AS rn
            FROM work_flow_table AS m) AS submitted_application
        '))
            ->join('noc_form as nf', 'submitted_application.application_id', '=', 'nf.id')
            ->where('submitted_application.rn', 1)
            ->where('submitted_application.level_id', '!=', 7)
            ->where('submitted_application.level_id', '!=', 8)
            ->where('submitted_application.level_id', '!=', 9)
            ->where('submitted_application.level_id', '!=', 10)
            ->where('submitted_application.level_id', '!=', 11)
            ->where('submitted_application.level_id', '=', 12)
            ->where('submitted_application.is_active', '=', 'YES')
            ->where('submitted_application.user_id', $uid)
            ->select(
                'submitted_application.application_id',
                'submitted_application.level_id',
                'submitted_application.is_active',
                'submitted_application.user_id',
                'submitted_application.action_taken_by',
                'submitted_application.submission_date',
                'submitted_application.action_date',
                'submitted_application.rn',
                'nf.*'
            )
            ->orderBy('submitted_application.submission_date', 'desc')
            ->get();

        return $getdata_noc_data;
    }


    public function get_list_noc()
    {
        $uid = session()->get('userid');
        $getdata_noc_data =  DB::table('noc_genrate_table')
            ->select('*')
            ->where('noc_type', 'Indian')
            ->get();

        return $getdata_noc_data;
    }








    public function front_attachment_list($attach_id, $userid)
    {
        $user_id_noc_doc_id = DB::table('doc_file_uploads')
            ->join('doc_masters', 'doc_file_uploads.doc_id', '=', 'doc_masters.id')
            ->where('doc_file_uploads.app_id', $attach_id)
            ->where('doc_file_uploads.noc_user_id', $userid)
            ->select('doc_file_uploads.*', 'doc_masters.*')
            ->get();
        return $user_id_noc_doc_id;
    }

    public function back_attachment_list($u_id)
    {
        $auth_id = session()->get('uid');
        $user_id_noc_doc_id = DB::table('back_attachment')
            ->where('app_id', $u_id)
            ->where('auth_id', $auth_id)
            ->select('id', 'title', 'back_doc_file', 'app_id', 'auth_id', 'status')
            ->get();

        return $user_id_noc_doc_id;
    }


    
    public static function getCheckCounts()
    {
        $check1Count_submit                 = DB::table('work_flow_table')->where('level_id', 1)->count();
        $check2Count_noc_issue              = DB::table('work_flow_table')->where('level_id', 11)->count();
        $check3Count_query_raised           =  DB::table('work_flow_table')->where('level_id', '!=', 1)->where('level_id', '!=', 11)->count();
        $check4Count_query_response         = DB::table('work_flow_table') ->whereBetween('level_id', ['3', '9'])->count();

        return [
            'check1Count_submit' => $check1Count_submit,
            'check2Count_noc_issue' => $check2Count_noc_issue,
            'check3Count_query_raised' => $check3Count_query_raised,
            'check4Count_query_response' => $check4Count_query_response,
        ];
    }

    public function view_surrsurrogacy($start, $length, $search)
    {
        $surrogacy_detail_data = DB::table('surrogacyclinic as sc')
            ->leftJoin('signup as s', 'sc.userid', '=', 's.id')
            ->leftJoin('surrogacy_certificate_details as scd', 'scd.userid', '=', 'sc.userid')
            ->get();

        $surrogacy_filter = DB::table('surrogacyclinic')
            ->leftJoin('signup', 'surrogacyclinic.userid', '=', 'signup.id')
            ->leftJoin('surrogacy_certificate_details', 'surrogacy_certificate_details.userid', '=', 'surrogacyclinic.userid')
            ->where('signup.email', 'like', '%' . $search . '%')
            ->offset($start)
            ->limit($length)
            ->get();

        $total_records = $surrogacy_detail_data->count();
        return [
            'total_records' => $total_records,
            'data' => $surrogacy_filter,
            'recordsTotal' => $total_records, 
            'recordsFiltered' => $surrogacy_filter->count(),
        ];
    }


    public function view_art_detail($start, $length, $search)
    { 
            // Base query for the data
                $artclinic_detail_data = DB::table('signup as sup')
                ->leftJoin('artclinic_director as artd', 'artd.userid', '=', 'sup.id')
                ->leftJoin('artclinic_equipment as ace', 'ace.userid', '=', 'sup.id')
                ->leftJoin('artclinic as arc', 'arc.userid', '=', 'sup.id')
                ->leftJoin('clinic_applicationno  as can', 'can.clinic_id', '=', 'arc.id');
                

                // Apply filter to the query for the search
                $artclinic_filter = clone $artclinic_detail_data; // Clone the base query for filtering

                // Apply the search filter if a search term is provided
                if (!empty($search)) {
                $artclinic_filter = $artclinic_filter->where('sup.clinicname', 'like', '%' . $search . '%');
                }

                // Apply pagination
                $artclinic_filter = $artclinic_filter->offset($start)
                ->limit($length);

                // Get the total number of records (before filtering)
                $total_records = $artclinic_detail_data->count();

                // Get the filtered records after the search filter is applied
                $filtered_records = $artclinic_filter->count();

                // Get the filtered data
                $data = $artclinic_filter->get();

                // Return the response with data and counts
                return [
                'total_records' => $total_records,
                'data' => $data,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $filtered_records,
                ];
    }


    public function view_art_clinic_ajax($start, $length, $search)
    {
        $artclinic_detail_data = DB::table('signup as sup')
        // ->leftJoin('artclinic_director as artd', 'artd.userid', '=', 'sup.id')
        // ->leftJoin('artclinic_equipment as ace', 'ace.userid', '=', 'sup.id')
        ->leftJoin('artclinic as arc', 'arc.userid', '=', 'sup.id')
        ->leftJoin('clinic_applicationno  as can', 'can.clinic_id', '=', 'arc.id');
        
        // Apply filter to the query for the search
        $artclinic_filter = clone $artclinic_detail_data; // Clone the base query for filtering

        // Apply the search filter if a search term is provided
        if (!empty($search)) {
        $artclinic_filter = $artclinic_filter->where('sup.clinicname', 'like', '%' . $search . '%');
        }
        $artclinic_filter = $artclinic_detail_data->where('arc.archive_status', '!=', 0);

        // Apply pagination
        $artclinic_filter = $artclinic_filter->offset($start)->limit($length);

        // Get the total number of records (before filtering)
        $total_records = $artclinic_detail_data->count();

        // Get the filtered records after the search filter is applied
        $filtered_records = $artclinic_filter->count();

        // Get the filtered data
        $data = $artclinic_filter->get();

        // Return the response with data and counts
        return [
            'total_records' => $total_records,
            'data' => $data,
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filtered_records,
        ];
    }
}
