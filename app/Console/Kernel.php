<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\SendEmailChangeVerificationJob;
use App\Jobs\SendEmailRenewalDueNotification;
use Illuminate\Support\Facades\DB;
use App\Jobs\GenerateDailySnapshotJob;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->job(new SendEmailChangeVerificationJob)->dailyAt('11:00');
        $schedule->job(new SendEmailChangeVerificationJob)
        ->dailyAt('11:00')
        // ->everyMinute()
        ->onFailure(function () {
            DB::table('scheduler_logs')->insert([
                'job' => 'SendEmailChangeVerificationJob',
                'status' => 'failed',
                'ran_at' => now(),
            ]);
        });

        $schedule->call(function () {
            $exists = DB::table('scheduler_logs')
                ->where('job', 'SendEmailChangeVerificationJob')
                ->where('status', 'success')
                ->whereDate('ran_at', today())
                ->exists();

            $exists2 = DB::table('scheduler_logs')
                ->where('job', 'SendEmailRenewalDueNotification')
                ->whereDate('ran_at', today())
                ->exists();

            if (!$exists) {
                DB::table('scheduler_logs')->insert([
                    'job' => 'SendEmailChangeVerificationJob',
                    'status' => 'missed',
                    'ran_at' => now(),
                ]);
            }
            if (!$exists2) {
                DB::table('scheduler_logs')->insert([
                    'job' => 'SendEmailRenewalDueNotification',
                    'status' => 'missed',
                    'ran_at' => now(),
                ]);
            }
        })->dailyAt('11:30'); // check after expected time

        $schedule->job(new SendEmailRenewalDueNotification)
        ->dailyAt('9:00')
        // ->everyMinute()
        ->onFailure(function () {
            DB::table('scheduler_logs')->insert([
                'job' => 'SendEmailRenewalDueNotification',
                'status' => 'failed',
                'ran_at' => now(),
            ]);
        });
        $schedule->job(new GenerateDailySnapshotJob())
             ->dailyAt('18:00')
             ->withoutOverlapping()
             ->onFailure(function () {
            DB::table('scheduler_logs')->insert([
                'job' => 'GenerateDailySnapshotJob',
                'status' => 'failed',
                'ran_at' => now(),
            ]);
        });
        $schedule->command('patient-reporting:reminder')
            ->everyMinute()
            ->withoutOverlapping();
        $schedule->command('patient-reporting:retry-failed')
            ->everyThirtyMinutes()
            ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     * run these to set cronjobs for schedular
     * crontab -e
     * php /var/www/html/myapp/artisan schedule:run >> /dev/null 2>&1
     * crontab -l
     * php artisan queue:work
     * 
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }



}
