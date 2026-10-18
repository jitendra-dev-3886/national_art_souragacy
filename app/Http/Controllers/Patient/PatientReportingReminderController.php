<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use App\Models\patient\PatientReportingReminder;
use App\Services\Patient\PatientReportingReminderService;

class PatientReportingReminderController extends Controller
{
    protected $reminderService;

    public function __construct(PatientReportingReminderService $reminderService)
    {
        $this->reminderService = $reminderService;
    }

    /**
     * Initiate Patient Reporting Reminder Notification
     */
    public function sendReminder(Request $request)
    {
        try {

            $response = $this->reminderService->initiateReminder(
                session('userid')
            );

            return response()->json($response);

        } catch (\Exception $e) {

            Log::error('Patient Reporting Reminder Error', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Unable to initiate patient reporting reminder.'
            ], 500);
        }
    }
}