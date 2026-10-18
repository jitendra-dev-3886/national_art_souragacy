<?php

namespace App\Http\Controllers\patientreportdashboards;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DynamicReportService;
use App\Models\patient\PatientArtclinic;
use App\Models\PatientArtclinic;
use App\Models\PatientArtbank;
use App\Models\App\Models\patient\PatientSurrogacyClinic;

class DynamicReportingController extends Controller
{
    public function dashboard()
    {
        $reportService = app(DynamicReportService::class);
        $count = $reportService->execute(
            PatientArtclinic::class,
            [
                [
                    'column' => 'gender',
                    'value' => 'Female'
                ]
            ]
        );
        $count = $reportService->execute(
            PatientArtclinic::class,
            [
                [
                    'column' => 'gender',
                    'value' => 'Female'
                ],
                [
                    'relation' => 'reporting',
                    'column' => 'status',
                    'value' => 'Finished'
                ]
            ]
        );
        return view('layouts.admin.reporting.dashboard');
    }
    public function dashboard(DynamicReportService $reportService)
    {

    }
}