<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use App\Mail\PatientReportingReminderMail;
use App\Models\patient\PatientReportingReminderFailedEmail;
use App\Models\patient\PatientReportingReminder;
use App\Models\patient\PatientReportingReminderBatch;

class RetryPatientReportingReminderEmails extends Command
{
    protected $signature = 'patient-reporting:retry-failed';

    protected $description = 'Retry failed patient reporting reminder emails';

    public function handle()
    {
        /*
        |--------------------------------------------------------------------------
        | Get latest reminder
        |--------------------------------------------------------------------------
        */
        $reminder = PatientReportingReminder::latest('initiated_at')->first();
        if (!$reminder) {
            $this->info('No patient reporting reminder found.');
            return Command::SUCCESS;
        }
        /*
        |--------------------------------------------------------------------------
        | Check whether all batches have finished
        |--------------------------------------------------------------------------
        */
        $pendingBatches = PatientReportingReminderBatch::where(
                'patient_reporting_reminder_id',
                $reminder->id
            )
            ->whereIn('status', [
                PatientReportingReminderBatch::STATUS_PENDING,
                PatientReportingReminderBatch::STATUS_PROCESSING,
            ])
            ->exists();
        /*
        |--------------------------------------------------------------------------
        | Initial batches are still processing
        |--------------------------------------------------------------------------
        */
        if ($pendingBatches) {
            $this->info(
                'Initial reminder batches are still processing.'
            );
            return Command::SUCCESS;
        }
        /*
        |--------------------------------------------------------------------------
        | All batches have finished
        |--------------------------------------------------------------------------
        */
        $this->info(
            'All reminder batches have finished. Checking failed emails.'
        );

        /*
        |--------------------------------------------------------------------------
        | Get failed email records
        |--------------------------------------------------------------------------
        */

        $failedEmails = PatientReportingReminderFailedEmail::where(
                'status',
                'Failed'
            )
            ->where(
                'attempt_count',
                '<',
                PatientReportingReminderFailedEmail::MAX_RETRY_ATTEMPTS
            )
            ->whereHas('batch', function ($query) use ($reminder) {
                $query->where(
                    'patient_reporting_reminder_id',
                    $reminder->id
                );
            })
            ->orderBy('failed_at')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | No failed emails
        |--------------------------------------------------------------------------
        */

        if ($failedEmails->isEmpty()) {

            $this->info('No failed reminder emails found.');

            return Command::SUCCESS;
        }

        $this->info(
            "Failed emails found: {$failedEmails->count()}"
        );

        $emailsSent = 0;
        $emailsFailed = 0;

        /*
        |--------------------------------------------------------------------------
        | Retry each failed email
        |--------------------------------------------------------------------------
        */

        foreach ($failedEmails as $failedEmail) {

            try {

                /*
                |--------------------------------------------------------------------------
                | Create clinic object for Mailable
                |--------------------------------------------------------------------------
                */

                $clinic = (object) [
                    'clinic_id' => $failedEmail->clinic_id,
                    'clinic_type' => $failedEmail->clinic_type,
                    'name' => $failedEmail->clinic_name,
                    'email' => $failedEmail->email,
                ];

                /*
                |--------------------------------------------------------------------------
                | Send email
                |--------------------------------------------------------------------------
                */

                Mail::to($failedEmail->email)
                    ->send(new PatientReportingReminderMail($clinic));

                /*
                |--------------------------------------------------------------------------
                | Update successful retry
                |--------------------------------------------------------------------------
                */

                $failedEmail->update([
                    'status' => 'Sent',
                    'attempt_count' => $failedEmail->attempt_count + 1,
                    'last_retry_at' => now(),
                    'error_message' => null,
                ]);

                $emailsSent++;

                $this->info(
                    "Retry successful: {$failedEmail->clinic_id} - {$failedEmail->email}"
                );

            } catch (\Exception $e) {

                $emailsFailed++;

                /*
                |--------------------------------------------------------------------------
                | Update failed retry
                |--------------------------------------------------------------------------
                */

                $failedEmail->update([
                    'status' => 'Failed',
                    'attempt_count' => $failedEmail->attempt_count + 1,
                    'last_retry_at' => now(),
                    'error_message' => $e->getMessage(),
                ]);

                Log::error(
                    'Patient Reporting Reminder Email Retry Failed',
                    [
                        'failed_email_id' => $failedEmail->id,
                        'batch_id' => $failedEmail->patient_reporting_reminder_batch_id,
                        'clinic_id' => $failedEmail->clinic_id,
                        'email' => $failedEmail->email,
                        'attempt_count' => $failedEmail->attempt_count,
                        'error' => $e->getMessage(),
                    ]
                );

                $this->error(
                    "Retry failed: {$failedEmail->clinic_id} - {$failedEmail->email}"
                );

                continue;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        $this->info("Retry completed.");
        $this->info("Emails successfully sent: {$emailsSent}");
        $this->info("Emails still failed: {$emailsFailed}");

        return Command::SUCCESS;
    }
}