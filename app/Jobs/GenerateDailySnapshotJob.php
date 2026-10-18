<?php

namespace App\Jobs;

use App\Models\clinic\Statetable;
use App\Services\DailySnapshotService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class GenerateDailySnapshotJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(DailySnapshotService $service): void
    {
        try {
            DB::table('scheduler_logs')->insert([
                'job' => 'GenerateDailySnapshotJob',
                'status' => 'stared',
                'ran_at' => now(),
            ]);

            $reportDate = now()->toDateString();

            Log::info("Daily Snapshot Generation Started");

            // National Report
            $service->generateSnapshot();

            // State Reports
            // $states = Statetable::orderBy('state_name')
            //     ->pluck('state_name');

            // foreach ($states as $state) {

            //     $service->generate(
            //         $reportDate,
            //         'State',
            //         strtoupper($state)
            //     );
            // }

            Log::info("Daily Snapshot Generation Completed");
            DB::table('scheduler_logs')->insert([
                'job' => 'GenerateDailySnapshotJob',
                'status' => 'completed',
                'ran_at' => now(),
            ]);

        } catch (\Exception $e) {

            Log::error(
                'Daily Snapshot Generation Failed : '
                . $e->getMessage()
            );

            throw $e;
        }
    }
}