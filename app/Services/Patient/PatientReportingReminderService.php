<?php

namespace App\Services\Patient;

use App\Models\patient\PatientReportingReminder;
use App\Models\patient\PatientReportingReminderBatch;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendPatientReportingReminderBatchJob;

class PatientReportingReminderService
{
    /**
     * Initiate reminder notification process.
     */
    public function initiateReminder($initiatedBy)
    {
        /*
        |--------------------------------------------------------------------------
        | Step 1 : Check 10-Day Restriction
        |--------------------------------------------------------------------------
        */

        $lastReminder = PatientReportingReminder::latest('initiated_at')->first();

        if ($lastReminder) {

            $nextAllowedDate = Carbon::parse($lastReminder->initiated_at)
                ->addDays(10);

            if (now()->lt($nextAllowedDate)) {

                return [
                    'success' => false,
                    'message' => 'Patient reporting reminder has already been initiated on '
                        . Carbon::parse($lastReminder->initiated_at)->format('d-m-Y H:i')
                        . '. Next reminder can be initiated after '
                        . $nextAllowedDate->format('d-m-Y H:i'),
                    'next_allowed_date' => $nextAllowedDate->format('Y-m-d H:i:s')
                ];
            }
        }
        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Step 2 : Get all clinics that have not started reporting
            |--------------------------------------------------------------------------
            */

            $clinics = $this->getNotStartedClinics();

            if ($clinics->isEmpty()) {

                DB::rollBack();

                return [
                    'success' => false,
                    'message' => 'No clinics found for sending reminder.'
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | Step 3 : Create Reminder Entry
            |--------------------------------------------------------------------------
            */

            $batchSize = 100;

            $totalClinics = $clinics->count();

            $totalBatches = ceil($totalClinics / $batchSize);

            $reminder = PatientReportingReminder::create([
                'initiated_by' => $initiatedBy,
                'total_clinics' => $totalClinics,
                'batch_size' => $batchSize,
                'total_batches' => $totalBatches,
                'status' => PatientReportingReminder::STATUS_INITIATED,
                'initiated_at' => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Step 4 : Create Batch Entries
            |--------------------------------------------------------------------------
            */

            foreach ($clinics->chunk($batchSize) as $index => $batchClinics) {

                $batch = PatientReportingReminderBatch::create([

                    'patient_reporting_reminder_id' => $reminder->id,

                    'batch_no' => $index + 1,

                    'batch_size' => $batchClinics->count(),

                    'clinic_ids' => $batchClinics
                            ->pluck('clinic_id')
                            ->values()
                            ->toArray(),

                    'emails_sent' => 0,

                    'status' => PatientReportingReminderBatch::STATUS_PENDING,

                    'scheduled_at' => Carbon::now()->addMinutes($index * 15),
                ]);
                Log::info('Batch Created', [
                    'batch_no' => $index + 1,
                    'batch_size' => $batchClinics->count(),
                    'scheduled_at' => $batch->scheduled_at,
                ]);

                /*
                 * Queue Job will be dispatched here later
                 */
                // SendPatientReportingReminderBatchJob::dispatch($batch->id)->delay($batch->scheduled_at);
            }
            Log::info('Reminder Created', [
                'reminder_id' => $reminder->id,
                'total_clinics' => $totalClinics,
                'total_batches' => $totalBatches,
            ]);

            DB::commit();

            return [

                'success' => true,

                'message' => 'Reminder initiated successfully.',

                'reminder_id' => $reminder->id,

                'total_clinics' => $totalClinics,

                'total_batches' => $totalBatches
            ];

        } catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Fetch all clinics that have not started reporting.
     */
    private function getNotStartedClinics()
    {

        $artDbName = DB::connection(config('database.default'))->getDatabaseName(); 
        $patientDbConnection = env('DB_SECOND_CONNECTION'); 
        $patientDbName = DB::connection($patientDbConnection)->getDatabaseName();

        return DB::table(DB::raw("{$artDbName}.clinic_registration as c"))
            ->where('c.status', 1)
            ->whereIn('c.clinic_type', [
                'ARTCLINIC',
                'ARTBANK',
                'ARTSURROGACY'
            ])
            ->whereNotIn(
                DB::raw('c.clinic_id COLLATE utf8mb4_unicode_ci'),
                function ($query) use ($patientDbName) {
                    $query->select(DB::raw('p.clinic_id COLLATE utf8mb4_unicode_ci'))
                        ->from(DB::raw("{$patientDbName}.patient_period_reporting_table as p"));
                }
            )
            ->select(
                'c.clinic_id',
                'c.clinic_type',
                'c.name',
                'c.state',
                'c.email'
            )
            ->orderBy('c.clinic_type')
            ->orderBy('c.state')
            ->orderBy('c.name')
            ->get();
    }
}