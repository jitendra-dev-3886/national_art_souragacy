<?php

namespace App\Jobs;

use App\Models\Admin\AccessChangeRequests;
use App\Models\clinic\ClinicRegistrationModel;
use App\Models\HoldChangeRequest;
use App\Mail\RenewalDueNotificationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\AccessChangeVerify;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class SendEmailRenewalDueNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        DB::table('scheduler_logs')->insert([
                'job' => 'SendEmailRenewalDueNotification',
                'status' => 'stared',
                'ran_at' => now(),
            ]);


         $cutoff = Carbon::today()->addDays(60);
        $requests = ClinicRegistrationModel::where('status', 1)
        ->whereDate('certificate_valid_date', $cutoff)
        ->where('clinic_type', 'ARTSURROGACY')
        ->get();
            
        foreach ($requests as $request) {
            $checkedMail = DB::table('clinic_reg_reminder_mail')->where('clinic_id', $request->clinic_id)->first();
            if(!empty($checkedMail)){
                Log::info("Renewal reminder already sent for clinic_id: {$request->clinic_id}, email: {$request->email}");

            }else{
                    DB::table('clinic_reg_reminder_mail')->insert([
                        'clinic_id' => $request->clinic_id,
                        'email' => $request->email,
                        'clinic_type' => $request->clinic_type,
                        'certificate_valid_date' => $request->certificate_valid_date,
                        'status' => 1,
                    ]);
                $clinic = [
                    'clinic_name' => 'Example Clinic',
                    'applicationNo' => 'APP 123456',
                    'reg_rej_no' => 'REG123456',
                    'status' => 'Approved',
                ];
                Mail::to('pushpendrarajput40@gmail.com')->send(new RenewalDueNotificationMail($clinic));
            }

        }
        //     try {
        //     // Send email
        //         $temptoken = Str::random(60);
        //         $requestid = Crypt::encrypt($request->request_id);
        //         $link = URL::temporarySignedRoute(
        //                     'clinic.verify_access',        // route name
        //                     now()->addDays(7),             // expires in 7 days
        //                     [
        //                         'reqno'     => $requestid,
        //                         'temptoken' => $temptoken,
        //                     ]
        //                 );
        //         $clinicverifyaccess = [
        //         'link' => $link,
        //         'state' => $request->state,
        //         ];
        //         $clinicverifyaccess2 = [
        //         'link' => 'not available',
        //         'state' => $request->state,
        //         ];
        //         // Mail::to($request->new_clinic_email)
        //         //     ->send(new AccessChangeVerify($clinicverifyaccess));
        //         Mail::to('paras.jain31@nic.in')
        //             ->send(new AccessChangeVerify($clinicverifyaccess2));

        //         // ✅ Update DB after successful send
        //         AccessChangeRequests::where('request_id', $request->request_id)
        //             ->update([
        //                 'email_sent' => now(),
        //                 'token' => $temptoken,
        //             ]);
        //         // ✅ Log success
        //         Log::info('Verification email sent successfully', [
        //             'request_id' => $request->request_id,
        //             'email'      => $request->new_clinic_email,
        //         ]);

        //     } catch (\Exception $e) {

        //         // ❌ Log failure
        //         Log::error('Verification email failed', [
        //             'request_id' => $request->request_id,
        //             'error'      => $e->getMessage(),
        //         ]);
        //     }
        // }
        // }
        DB::table('scheduler_logs')->insert([
                'job' => 'SendEmailRenewalDueNotification',
                'status' => 'completed',
                'ran_at' => now(),
            ]);
    }
}
