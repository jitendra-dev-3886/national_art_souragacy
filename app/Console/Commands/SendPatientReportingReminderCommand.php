<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\patient\PatientReportingReminderBatch;
use Illuminate\Support\Facades\Mail;
use App\Mail\PatientReportingReminderMail;
use App\Models\patient\PatientReportingReminderFailedEmail;

class SendPatientReportingReminderCommand extends Command
{
    protected $signature = 'patient-reporting:reminder';

    protected $description = 'Process pending patient reporting reminder batches';

    public function handle()
    {
        /*
        |--------------------------------------------------------------------------
        | Find the next pending batch which is due
        |--------------------------------------------------------------------------
        */

        $batch = PatientReportingReminderBatch::where(
                'status',
                PatientReportingReminderBatch::STATUS_PENDING
            )
            ->where('scheduled_at', '<=', now())
            ->orderBy('scheduled_at')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | No batch is due
        |--------------------------------------------------------------------------
        */

        if (!$batch) {

            $this->info('No pending reminder batch is due.');

            return Command::SUCCESS;
        }

        /*
        |--------------------------------------------------------------------------
        | Batch found
        |--------------------------------------------------------------------------
        */

        $this->info(
            "Batch {$batch->batch_no} is due for processing."
        );
        /*
        |--------------------------------------------------------------------------
        | Mark batch as Processing
        |--------------------------------------------------------------------------
        */

        $batch->update([
            'status' => PatientReportingReminderBatch::STATUS_PROCESSING,
            'started_at' => now(),
        ]);

        $this->info(
            "Batch {$batch->batch_no} marked as Processing."
        );
        $clinicIds = $batch->clinic_ids;
        /*
        |--------------------------------------------------------------------------
        | Get clinics belonging to this batch
        |--------------------------------------------------------------------------
        */

        $artDbName = DB::connection(config('database.default'))->getDatabaseName();

        $clinics = DB::table(DB::raw("{$artDbName}.clinic_registration"))
            ->whereIn('clinic_id', $clinicIds)
            ->where('status',1)
            ->select(
                'clinic_id',
                'clinic_type',
                'name',
                'state',
                'email'
            )
            ->get();

        $this->info(
            "Clinics found for Batch {$batch->batch_no}: " . $clinics->count()
        );
        $emailsSent = 0;
        $emailsFailed = 0;
        foreach ($clinics as $clinic) 
        {

            try {

                // TEMPORARY: send only to your test email
                Mail::to('testuser123@yopmail.com')
                    ->send(new PatientReportingReminderMail($clinic));
                // Mail::to($clinic->email)
                //     ->send(new PatientReportingReminderMail($clinic));

                $emailsSent++;

                $this->info(
                    "Email sent for clinic: {$clinic->clinic_id}"
                );
                break; // TEST ONLY — stop after first email

            } catch (\Exception $e) {
                $emailsFailed++;
                /*
                |--------------------------------------------------------------------------
                | Store failed email
                |--------------------------------------------------------------------------
                */

                PatientReportingReminderFailedEmail::create([
                    'patient_reporting_reminder_batch_id' => $batch->id,
                    'clinic_id' => $clinic->clinic_id,
                    'clinic_type' => $clinic->clinic_type,
                    'clinic_name' => $clinic->name,
                    'email' => $clinic->email,
                    'error_message' => $e->getMessage(),
                    'attempt_count' => 1,
                    'status' => 'Failed',
                    'failed_at' => now(),
                ]);
                Log::error('Patient Reporting Reminder Email Failed', [

                    'batch_id' => $batch->id,

                    'clinic_id' => $clinic->clinic_id,

                    'email' => $clinic->email,

                    'error' => $e->getMessage(),
                ]);

                $this->error(
                    "Email failed for clinic: {$clinic->clinic_id}"
                );
                continue;
            }
        }
        $this->info("Emails sent: {$emailsSent}");
        $this->info("Emails failed: {$emailsFailed}");
        /*
        |--------------------------------------------------------------------------
        | Update Batch Status
        |--------------------------------------------------------------------------
        */

        if ($emailsSent === $clinics->count()) {

            // All emails successfully sent
            $status = PatientReportingReminderBatch::STATUS_COMPLETED;

        } elseif ($emailsSent > 0) {

            // Some emails sent, some failed
            $status = PatientReportingReminderBatch::STATUS_PARTIAL;

        } else {

            // All emails failed
            $status = PatientReportingReminderBatch::STATUS_FAILED;
        }

        $batch->update([
            'emails_sent' => $emailsSent,
            'emails_failed' => $emailsFailed,
            'status' => $status,
            'completed_at' => now(),
        ]);

        $this->info(
            "Batch {$batch->batch_no} completed. " .
            "Sent: {$emailsSent}, Failed: {$emailsFailed}"
        );

        Log::info('Patient Reporting Reminder Batch Due', [
            'batch_id'     => $batch->id,
            'batch_no'     => $batch->batch_no,
            'batch_size'   => $batch->batch_size,
            'scheduled_at' => $batch->scheduled_at,
        ]);

        return Command::SUCCESS;
    }
}