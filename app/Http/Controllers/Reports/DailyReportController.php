<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use App\Models\Report\DailyReportSnapshot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;




class DailyReportController extends Controller
{
    protected ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function dailyReport()
    {

        $sections = $this->reportService->getSections();

        return view('reports.daily_report', compact('sections'));
    }

    public function dailyPreview(Request $request)
    {
        $requestedFields = $request->input('fields', []);
        $reportDate = $request->input('report_date', now()->toDateString());

        if (empty($requestedFields)) {
            return back()->withErrors(['fields' => 'Please select at least one field to generate the report.'])->withInput();
        }

        // 1. Calculate and save data
        $allDailyResults = $this->reportService->calculateAllDailyTotals();
        $this->reportService->saveDailyReportToDatabase($allDailyResults, $reportDate);

        // 2. Get sections and dynamic years
        $sections = $this->reportService->getSections();
        $dynamicYears = $this->reportService->getTargetYears(); 
        
        $groupedReport = [];

        foreach ($sections as $section) {
            // Skip the 'K. Year' section from appearing as a regular data table section if it's just meant for metadata
            if ($section['name'] === 'K. Year') {
                continue; 
            }

            $sectionData = [
                'name' => $section['name'],
                'items' => []
            ];

            foreach ($section['fields'] as $field) {
                // ONLY include the field if its code was checked in the form request
                if (in_array($field['code'], $requestedFields)) {
                    
                    $yearlyData = [];
                    foreach ($dynamicYears as $year) {
                        $yearlyData[$year] = (int) ($allDailyResults["{$field['code']}_{$year}"] ?? 0);
                    }

                    $sectionData['items'][] = [
                        'title' => $field['name'],
                        'count' => (int) ($allDailyResults[$field['code']] ?? 0),
                        'years' => $yearlyData
                    ];
                }
            }

            // ONLY add the section if the user checked at least one field inside this specific section
            if (count($sectionData['items']) > 0) {
                $groupedReport[] = $sectionData;
            }
        }

        return view('reports.daily_report_preview', [
            'groupedReport' => $groupedReport,
            'reportDate'    => $reportDate,
            'dynamicYears'  => $dynamicYears
        ]);
    }

    public function dailyReportSnapshot(Request $request)
    {
        $reportDate = $request->input('report_date'); 
        $selectedYears = $request->input('search_years', []); 

        if (!$reportDate) {
            $latestRecord = DB::table('daily_report_submitted_records')->orderBy('report_date', 'desc')->first();
            $reportDate = $latestRecord ? $latestRecord->report_date : now()->toDateString();
        }

        $sections = $this->reportService->getSections();
        $allAvailableYears = $this->reportService->getTargetYears(); 

        // Only show year columns in the table if the user explicitly selected them
        $displayYears = !empty($selectedYears) 
            ? array_intersect($allAvailableYears, $selectedYears) 
            : [];

        // Fetch ALL records for this report date across all years
        $allSubmittedRows  = DB::table('daily_report_submitted_records')->where('report_date', $reportDate)->get();
        $allProceduresRows = DB::table('daily_report_procedures')->where('report_date', $reportDate)->get();
        $allOutcomesRows   = DB::table('daily_report_outcomes')->where('report_date', $reportDate)->get();

        // Index them by year for quick lookup
        $yearlySubmitted = $allSubmittedRows->keyBy('year');
        $yearlyProcedures = $allProceduresRows->keyBy('year');
        $yearlyOutcomes = $allOutcomesRows->keyBy('year');

        $groupedReport = [];

        foreach ($sections as $section) {
            if ($section['name'] === 'K. Year') continue;

            $sectionData = [
                'name' => $section['name'],
                'items' => []
            ];

            foreach ($section['fields'] as $field) {
                $fieldCode = $field['code'];
                
                $grandTotal = 0;
                $yearlyData = [];

                if (!empty($displayYears)) {
                    // Case 1: User explicitly selected specific years -> Sum ONLY those years
                    foreach ($displayYears as $year) {
                        $ySub  = $yearlySubmitted[$year] ?? null;
                        $yProc = $yearlyProcedures[$year] ?? null;
                        $yOut  = $allOutcomesRows->where('year', $year)->first() ?? null;

                        $val = $ySub->$fieldCode ?? $yProc->$fieldCode ?? $yOut->$fieldCode ?? 0;
                        
                        $yearlyData[$year] = (int) $val;
                        $grandTotal += (int) $val;
                    }
                } else {
                    // Case 2: Default view (No years selected) -> Sum ALL available years for a pure date-wise grand total
                    foreach ($allAvailableYears as $year) {
                        $ySub  = $yearlySubmitted[$year] ?? null;
                        $yProc = $yearlyProcedures[$year] ?? null;
                        $yOut  = $allOutcomesRows->where('year', $year)->first() ?? null;

                        $val = $ySub->$fieldCode ?? $yProc->$fieldCode ?? $yOut->$fieldCode ?? 0;
                        $grandTotal += (int) $val;
                    }

                    // Fallback: If summation across all years is 0, check default/null year rows
                    if ($grandTotal === 0) {
                        $defaultSub  = $allSubmittedRows->whereNull('year')->first();
                        $defaultProc = $allProceduresRows->whereNull('year')->first();
                        $defaultOut  = $allOutcomesRows->whereNull('year')->first();
                        
                        $grandTotal = (int) ($defaultSub->$fieldCode ?? $defaultProc->$fieldCode ?? $defaultOut->$fieldCode ?? 0);
                    }
                }

                $sectionData['items'][] = [
                    'title' => $field['name'],
                    'count' => $grandTotal,
                    'years' => $yearlyData
                ];
            }

            if (count($sectionData['items']) > 0) {
                $groupedReport[] = $sectionData;
            }
        }

        return view('reports.daily_report_snapshots', [
            'groupedReport'     => $groupedReport,
            'reportDate'        => $reportDate,
            'dynamicYears'      => $displayYears,      
            'allAvailableYears' => $allAvailableYears  
        ]);
    }
}