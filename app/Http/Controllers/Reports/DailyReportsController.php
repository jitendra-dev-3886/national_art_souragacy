<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Services\ReportService;

class DailyReportsController extends Controller
{
    protected $reportService;

    // Inject your ReportService here
    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Show the form with checkboxes to generate a report.
     */
    public function index()
    {
        dd(4545);
        // Get the A-K sections layout from the service
        $sections = $this->reportService->getSections();
        dd($sections);

        return view('report.daily_report', [
            'sections' => $sections
        ]);
    }

    /**
     * Process the form submission and show the preview table.
     */
    public function preview(Request $request)
    {
        // Require at least a date and some fields
        $request->validate([
            'report_date' => 'required|date',
            'fields'      => 'required|array',
        ]);

        // Generate the final counts using the Service
        $reportData = $this->reportService->generate($request);

        return view('report.report.daily_report_preview', [
            'report' => $reportData
        ]);
    }
}