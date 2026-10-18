<?php

namespace App\Jobs;

use App\Helpers\dashboardHelper;
use App\Mail\RenewalDueNotificationMail;
use App\Models\clinic\ClinicRegistrationModel;
use App\Models\renewal\RenewalNotificationLog;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendEmailRenewalDueNotification implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    public function handle(): void
    {
        DB::table('scheduler_logs')->insert([
            'job' => 'SendEmailRenewalDueNotification',
            'status' => 'started',
            'ran_at' => now(),
        ]);

        $this->createNormalReminders();

        $this->createRelaxationReminders();

        $this->sendPendingEmails();

        DB::table('scheduler_logs')->insert([
            'job' => 'SendEmailRenewalDueNotification',
            'status' => 'completed',
            'ran_at' => now(),
        ]);
    }

    // private function createNormalReminders()
    // {
    //     $today = Carbon::today();

    //     $daysList = [
    //         60 => '60_days',
    //         53 => '53_days',
    //         45 => '45_days'
    //     ];

    //     foreach ($daysList as $days => $type) {

    //         $expiryDate = $today->copy()->addDays($days);

    //         $clinics = ClinicRegistrationModel::where('status', 1)
    //             ->where('clinic_type', 'ARTSURROGACY')
    //             ->whereDate('certificate_valid_date', $expiryDate)
    //             ->get();

    //         foreach ($clinics as $clinic) {

    //             $alreadyExists = RenewalNotificationLog::where(
    //                 'clinic_id',
    //                 $clinic->clinic_id
    //             )
    //             ->where(
    //                 'notification_type',
    //                 $type
    //             )
    //             ->exists();

    //             if (!$alreadyExists) {

    //                 RenewalNotificationLog::create([
    //                     'clinic_id' => $clinic->clinic_id,
    //                     'email' => $clinic->email,
    //                     'notification_type' => $type,
    //                     'certificate_expiry_date' => $clinic->certificate_valid_date,
    //                     'target_date' => $today
    //                 ]);
    //             }
    //         }
    //     }
    // }

    // private function createRelaxationReminders()
    // {
    //     $notificationDate = Carbon::parse('2026-05-15');

    //     if (!$notificationDate->isToday()) {
    //         return;
    //     }

    //     $cutoff = $notificationDate
    //         ->copy()
    //         ->addDays(60);

    //     $clinics = ClinicRegistrationModel::where('status', 1)
    //         ->where('clinic_type', 'ARTSURROGACY')
    //         ->whereDate(
    //             'certificate_valid_date',
    //             '<=',
    //             $cutoff
    //         )
    //         ->get();

    //     foreach ($clinics as $clinic) {

    //         $alreadyExists = RenewalNotificationLog::where(
    //             'clinic_id',
    //             $clinic->id
    //         )
    //         ->where(
    //             'notification_type',
    //             'relaxation'
    //         )
    //         ->exists();

    //         if (!$alreadyExists) {

    //             RenewalNotificationLog::create([
    //                 'clinic_id' => $clinic->id,
    //                 'email' => $clinic->email,
    //                 'notification_type' => 'relaxation',
    //                 'certificate_expiry_date' => $clinic->certificate_valid_date,
    //                 'target_date' => Carbon::today()
    //             ]);
    //         }
    //     }
    // }
    private function createNormalReminders(): void
    {
        $today = Carbon::today();

        $daysMap = [
            60 => '60_days',
            53 => '53_days',
            45 => '45_days'
        ];

        foreach ($daysMap as $days => $type) {

            $expiryDate = $today->copy()->addDays($days);

            $clinics = ClinicRegistrationModel::where('status', 1)
                ->where('clinic_type', 'ARTSURROGACY')
                ->whereDate('certificate_valid_date', $expiryDate)
                ->get();

            foreach ($clinics as $clinic) {

                RenewalNotificationLog::firstOrCreate(
                    [
                        'clinic_id' => $clinic->clinic_id,
                        'clinic_type' => $clinic->clinic_type,
                        'email_type' => $type,
                        'expiry_date' => $clinic->certificate_valid_date,
                    ],
                    [
                        'scheduled_send_date' => $today,
                        'status' => 'pending',
                    ]
                );
            }
        }
    }
    private function createRelaxationReminders(): void
    {
        $notificationDate = Carbon::parse(dashboardHelper::notificationDate());
        

        if (today()->lt($notificationDate)) {
            return;
        }

        $cutoff = $notificationDate->copy()->addDays(60);

        $clinics = ClinicRegistrationModel::where('status', 1)
            // ->where('clinic_type', 'ARTSURROGACY')
            ->whereDate('certificate_valid_date', '<=', $cutoff)
            ->get();

        foreach ($clinics as $clinic) {

            RenewalNotificationLog::firstOrCreate(
                [
                    'clinic_id' => $clinic->clinic_id,
                    'clinic_type' => $clinic->clinic_type,
                    'email_type' => '60_days_relaxation',
                    'expiry_date' => $clinic->certificate_valid_date,
                ],
                [
                    'scheduled_send_date' => $notificationDate,
                    'status' => 'pending'
                ]
            );

            RenewalNotificationLog::firstOrCreate(
                [
                    'clinic_id' => $clinic->clinic_id,
                    'clinic_type' => $clinic->clinic_type,
                    'email_type' => '53_days_relaxation',
                    'expiry_date' => $clinic->certificate_valid_date,
                ],
                [
                    'scheduled_send_date' => $notificationDate->copy()->addDays(7),
                    'status' => 'pending'
                ]
            );

            RenewalNotificationLog::firstOrCreate(
                [
                    'clinic_id' => $clinic->clinic_id,
                    'clinic_type' => $clinic->clinic_type,
                    'email_type' => '45_days_relaxation',
                    'expiry_date' => $clinic->certificate_valid_date,
                ],
                [
                    'scheduled_send_date' => $notificationDate->copy()->addDays(15),
                    'status' => 'pending'
                ]
            );
        }
    }

    private function sendPendingEmails()
    {
        $notifications = RenewalNotificationLog::whereIn(
        'status',
        ['pending', 'failed']
        )
        ->whereDate(
            'scheduled_send_date',
            '<=',
            Carbon::today()
        )
        ->where('attempts', '<', 30)
        ->get();

        foreach ($notifications as $notification) {

            try {

                $clinic = ClinicRegistrationModel::where('clinic_id', $notification->clinic_id)
                        ->where('status', 1)
                        ->first();

                if (!$clinic) {
                    $notification->update([
                        'status' => 'failed',
                        'error_message' => 'Clinic not found or inactive',
                        'last_attempt_at' => now(),
                        'attempts' => $notification->attempts + 1
                    ]);
                    continue;
                }

                Mail::to($clinic->email)->send(new RenewalDueNotificationMail($clinic));

                $notification->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                    'last_attempt_at' => now(),
                    'attempts' => $notification->attempts + 1,
                    'error_message' => null
                ]);

            } catch (\Exception $e) {

                $notification->update([
                    'status' => 'failed',
                    'attempts' => $notification->attempts + 1,
                    'last_attempt_at' => now(),
                    'error_message' => $e->getMessage()
                ]);
            }
        }
    }


}