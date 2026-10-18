<?php

namespace App\Http\Controllers;

use App\Models\Admin\Noctable;
use App\Models\clinic\ClinicRegistrationModel;
use App\Models\clinic\ArtClinicModel;
use App\Models\clinic\BankModel;
use App\Models\clinic\SurrogacyClinicModel;
use App\Models\renewal\RenewalSCApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function index()
  {

    //dd('dsfsdfsd');
    Log::info('Admin login dashboard page After successful login.');
    $noctable = new Noctable();
    $getdata_count = $noctable->getCheckCounts();
    $role = Session::get('role');
    // dd($role);
    return view('layouts.admin.dashboard', compact('getdata_count', 'role'));
  }
  public function clinicData(Request $request)
  {

    $connection = env('DB_CONNECTION');
    // $connection = config('database.third_connection');


    $clinic_type = $request->query('type');

    $validTypes = [
      'register-clinic',
      'register-bank',
      'register-surrogacy',
      'reject-clinic',
      'reject-bank',
      'reject-surrogacy'
    ];

    if (!in_array($clinic_type, $validTypes, true)) {

      return abort(400, 'Invalid clinic type request'); 
    }
      if (in_array($clinic_type, ['register-clinic', 'register-bank', 'register-surrogacy'], true)) {
        $types = [
            'register-clinic' => 'ARTCLINIC',
            'register-bank' => 'ARTBANK',
            'register-surrogacy' => 'ARTSURROGACY'
        ];

       $query = (new ClinicRegistrationModel)->setConnection($connection)->where('clinic_type', $types[$clinic_type])
          ->where('status', 1);


        if ($request->ajax() || $request->has('draw')) {

            $columns = [
                0 => 'id',
                1 => 'name',
                2 => 'address',
                3 => 'state',
                4 => 'email',
                5 => 'registration_no'
            ];

            $orderColumnIndex = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir', 'desc');
            $orderColumn = $columns[$orderColumnIndex] ?? 'id';
            $query->orderBy($orderColumn, $orderDir);
            
            // Apply search filter (search only if 3 or more characters)  
            $search = $request->input('search.value');
            $query = $this->applySearch($query, $search, 'register');

            $total = (new ClinicRegistrationModel)->setConnection($connection)->where('clinic_type', $types[$clinic_type])
                ->where('status', 1)
                ->count();

            $filtered = $query->count();
            
            $data = $query->select(['id','clinic_id','name','address','state','email','registration_no','certificate_path'])
                          ->skip($request->start ?? 0)->take($request->length ?? 20)->get();

            return response()->json([
                "draw" => intval($request->draw ?? 1),
                "recordsTotal" => $total,
                "recordsFiltered" => $filtered,
                "data" => $data
            ]);
        }
          return view('layouts.list_clinic', compact('clinic_type'));
      }

      if (in_array($clinic_type, ['reject-clinic', 'reject-bank', 'reject-surrogacy'], true)) {
          
        $clinicModel = [
            'reject-clinic' => [ArtClinicModel::class, 'ARTCLINIC'],
            'reject-bank' => [BankModel::class, 'ARTBANK'],
            'reject-surrogacy' => [SurrogacyClinicModel::class, 'ARTSURROGACY']
        ];

        // dd($clinicModel);
        $data = $clinicModel[$clinic_type];

        $clinicModel = $data[0];
        $type = $data[1];

        $query = $clinicModel::with('certificate')
            ->whereHas('certificate', function ($q) {
                $q->where('approved_rejected', 'Registration Rejected');
            });

        if ($request->ajax() || $request->has('draw')) {

          $columns = [
              0 => 'id',
              1 => 'clinicname',
              2 => 'address',
              3 => 'state',
              4 => 'email',
              5 => 'applicationno'
          ];

          $orderColumnIndex = $request->input('order.0.column');
          $orderDir = $request->input('order.0.dir', 'desc');
          $orderColumn = $columns[$orderColumnIndex] ?? 'id';
          $query->orderBy($orderColumn, $orderDir);

          // Apply search filter (search only if 3 or more characters)  
          $search = $request->input('search.value');
          $query = $this->applySearch($query, $search, 'reject');
          
          $total = $clinicModel::whereHas('certificate', function ($q) {
              $q->where('approved_rejected', 'Registration Rejected');
          })->count();

          $filtered = $query->count();

          $data = $query->select('id','clinicname','address','state','email','applicationno')->skip($request->start ?? 0)->take($request->length ?? 20)->get();

          // dd($data);

          return response()->json([
              "draw" => intval($request->draw ?? 1),
              "recordsTotal" => $total,
              "recordsFiltered" => $filtered,
              "data" => $data
          ]);
        }

        $renewal = RenewalSCApplication::where('appstatus', 'Rejected')
            ->where('clinic_type', $type)
            ->get();

        return view('layouts.list_reject_clinic', compact('clinic_type', 'renewal'));
      }
  }
  private function applySearch($query, $search, $type)
    {
      if (!$search || strlen($search) < 3) {
          return $query;
      }

      if ($type === 'register') {
          return $query->where(function ($q) use ($search) {
              $q->where('name', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('state', 'like', "%{$search}%")
                ->orWhere('registration_no', 'like', "%{$search}%");
          });
      }

      if ($type === 'reject') {

          return $query->where(function ($q) use ($search) {
              $q->where('clinicname', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('state', 'like', "%{$search}%")
                ->orWhere('applicationno', 'like', "%{$search}%");
          });
      }
      return $query;
  }
}
