<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\patient\PatientReportingReminderBatch;
use Illuminate\Support\Facades\Mail;
use App\Mail\PatientReportingReminderMail;

class SendPatientReportingReminderBatchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $batchId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $batchId)
    {
        $this->batchId = $batchId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $batch = PatientReportingReminderBatch::find($this->batchId);

        if (!$batch) {
            Log::error("Reminder Batch {$this->batchId} not found.");
            return;
        }

        $batch->update([
            'status' => PatientReportingReminderBatch::STATUS_PROCESSING,
            'started_at' => now(),
        ]);

        try {

            // $artDbName = DB::connection('mysql')->getDatabaseName();

            $clinics = DB::table("clinic_registration")
                ->whereIn('clinic_id', $batch->clinic_ids)
                ->select(
                    'clinic_id',
                    'name',
                    'email',
                    'clinic_type',
                    'state'
                )
                ->get();

            /*
            |--------------------------------------------------------------------------
            | TEMPORARY
            | Just log the clinics.
            | We'll replace this with Mail::to() later.
            |--------------------------------------------------------------------------
            */

            foreach ($clinics as $clinic) {

                Log::info('Reminder Email', [

                    'Batch' => $batch->batch_no,

                    'Clinic ID' => $clinic->clinic_id,

                    'Clinic Name' => $clinic->name,

                    'Email' => $clinic->email
                ]);
            }

            $batch->update([

                'emails_sent' => $clinics->count(),

                'status' => PatientReportingReminderBatch::STATUS_COMPLETED,

                'completed_at' => now(),
            ]);

        } catch (\Exception $e) {

            $batch->update([

                'status' => PatientReportingReminderBatch::STATUS_FAILED,

                'error_message' => $e->getMessage(),
            ]);

            Log::error($e);

            throw $e;
        }
    }
}