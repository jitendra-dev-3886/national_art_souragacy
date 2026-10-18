<?php

namespace App\Models\Admin;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Archive extends Model
{
    use HasFactory;

    public function fetch_data_archive($searchApp)
    {

//dd($searchApp);

        $surrogacy_detail_data = DB::table('signup as s')
        ->leftJoin('surrogacyclinic as sc', function ($join) {
                $join->on('sc.userid', '=', 's.id')
                    ->where('sc.appstatus','Pending')
                    ->where('sc.status', 1);   // ← Added condition
            })
        ->leftJoin('s_applicationno as san', 'san.surrogacy_id', '=', 'sc.id')
        ->where('san.id', $searchApp)
       // ->where('san.applicationno', 'LIKE', '%' . $searchApp) // Match last digits
        ->select(
            'sc.id',
            'sc.userid',
            's.clinicname',
            's.email',
            's.state',
            's.district',
            's.address',
            's.pincode',
            's.mobile',
            'san.applicationno',
            'sc.archive_status',
            'sc.datetime_decision'
        )
        ->get();


       // dd($surrogacy_detail_data);
            foreach ($surrogacy_detail_data as $data) {
                $data->type_of_clinic = 'art_surrogacy';  // Add your static value here
            }            
            return $surrogacy_detail_data;       
    }
    public function fetch_data_unarchive($searchApp)
    {



        $surrogacy_detail_data = DB::table('signup as s')
        ->leftJoin('surrogacyclinic as sc', 'sc.userid', '=', 's.id')
        ->leftJoin('s_applicationno as san', 'san.surrogacy_id', '=', 'sc.id')
        ->where('sc.id', $searchApp)
    //    ->where('san.applicationno', 'LIKE', '%' . $searchApp) // Match last digits
        ->where('sc.archive_status', 2) // added condition
        ->select(
            'sc.id',
            'sc.userid',
            's.clinicname',
            's.email',
            's.state',
            's.district',
            's.address',
            's.pincode',
            's.mobile',
            'san.applicationno',
            'sc.archive_status',
            'sc.datetime_decision'
        )
        ->get();

      //  dd($surrogacy_detail_data);

            foreach ($surrogacy_detail_data as $data) {
                $data->type_of_clinic = 'art_surrogacy';  // Add your static value here
            }            
            return $surrogacy_detail_data;       
    }

    public function fetch_data_archive_art_bank($searchApp)
    {
        $surrogacy_detail_data = DB::table('signup as s')
            ->leftJoin('artbank as artbk', function ($join) {
                $join->on('artbk.userid', '=', 's.id')
                    ->where('artbk.appstatus','Pending')
                    ->where('artbk.status', 1);   // ← Added condition
            })
            ->leftJoin('bank_applicationno as artcd', 'artcd.bank_id', '=', 'artbk.id')
          ->where('artcd.id', "$searchApp")
          //  ->where('artcd.applicationno', 'LIKE', '%' . $searchApp) // Match last digits
            ->select(
                'artbk.id',
                'artbk.userid',
                's.clinicname',
                's.email',
                's.state',
                's.district',
                's.address',
                's.pincode',
                's.mobile',
                'artcd.applicationno',
                'artbk.archive_status',
                'artbk.datetime_decision',
            )
            ->get();

            foreach ($surrogacy_detail_data as $data) {
                $data->type_of_clinic = 'art_bank';  // Add your static value here
            }
            
            return $surrogacy_detail_data;
       
    }
    public function fetch_data_unarchive_art_bank($searchApp)
    {
        $surrogacy_detail_data = DB::table('signup as s')
            ->leftJoin('artbank  as artbk', 'artbk.userid', '=', 's.id')
            ->leftJoin('bank_applicationno as artcd', 'artcd.bank_id', '=', 'artbk.id')
            ->where('artbk.id', "$searchApp")
          //  ->where('artcd.applicationno', 'LIKE', '%' . $searchApp) // Match last digits
            ->where('artbk.archive_status', 2) // added condition
            ->select(
                'artbk.id',
                'artbk.userid',
                's.clinicname',
                's.email',
                's.state',
                's.district',
                's.address',
                's.pincode',
                's.mobile',
                'artcd.applicationno',
                'artbk.archive_status',
                'artbk.datetime_decision',
            )
            ->get();

            foreach ($surrogacy_detail_data as $data) {
                $data->type_of_clinic = 'art_bank';  // Add your static value here
            }
            
            return $surrogacy_detail_data;
       
    }

    public function fetch_data_archive_art_clinic($searchApp)
    {
        $surrogacy_detail_data = DB::table('signup as s')
            ->leftJoin('artclinic as ac', function ($join) {
                $join->on('ac.userid', '=', 's.id')
                    ->where('ac.appstatus','Pending')
                    ->where('ac.status', 1);   // ← Added condition
            })
            ->leftJoin('clinic_applicationno as acd', 'acd.clinic_id', '=', 'ac.id')
           ->where('acd.id', "$searchApp")
          //  ->where('acd.applicationno', 'LIKE', '%' . $searchApp) // Match last digits
            ->select(
                'ac.id',
                'ac.userid',
                'ac.cliniclevel',
                's.clinicname',
                's.email',
                's.state',
                's.district',
                's.address',
                's.pincode',
                's.mobile',
                'acd.applicationno',
                'ac.archive_status',
                'ac.datetime_decision',
            )
            ->get();

            foreach ($surrogacy_detail_data as $data) {
                $data->type_of_clinic = 'art_clinic';  // Add your static value here
            }
            
            return $surrogacy_detail_data;
       
    }
    public function fetch_data_unarchive_art_clinic($searchApp)
    {
        $surrogacy_detail_data = DB::table('signup as s')
            ->leftJoin('artclinic  as ac', 'ac.userid', '=', 's.id')
            ->leftJoin('clinic_applicationno as acd', 'acd.clinic_id', '=', 'ac.id')
            ->where('ac.id', "$searchApp")
         //   ->where('acd.applicationno', 'LIKE', '%' . $searchApp) // Match last digits
            ->where('ac.archive_status', 2) // added condition
            ->select(
                'ac.id',
                'ac.userid',
                'ac.cliniclevel',
                's.clinicname',
                's.email',
                's.state',
                's.district',
                's.address',
                's.pincode',
                's.mobile',
                'acd.applicationno',
                'ac.archive_status',
                'ac.datetime_decision',
            )
            ->get();

            foreach ($surrogacy_detail_data as $data) {
                $data->type_of_clinic = 'art_clinic';  // Add your static value here
            }
            
            return $surrogacy_detail_data;
       
    }
}
