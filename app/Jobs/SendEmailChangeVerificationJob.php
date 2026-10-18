<?php

namespace App\Jobs;

use App\Models\Admin\AccessChangeRequests;
use App\Models\HoldChangeRequest;
use App\Mail\EmailChangeVerificationMail;
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

class SendEmailChangeVerificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        DB::table('scheduler_logs')->insert([
                'job' => 'SendEmailChangeVerificationJob',
                'status' => 'stared',
                'ran_at' => now(),
            ]);
        $cutoff = Carbon::yesterday()->endOfDay()->subDays(3);
        $requests = AccessChangeRequests::where('status', 'pending')
            ->whereNull('email_sent')
            ->where('is_active',1)
            ->where('state','DELHI')
            // ->whereDate('created_at', '<=', $cutoff)
            ->get();
            
        if($requests->isEmpty()){
            Log::error('No email is pending to send');
        }else{
        foreach ($requests as $request) {

            // Check if stop request exists and confirmed
            $hold = DB::table('hold_change_request')->where(
                'request_id',
                $request->request_id
            )->first();

            if ($hold && $hold->hold_status == 'Requested') {
                // Stop request confirmed → DO NOT SEND EMAIL
                continue;
            }
            try {
            // Send email
                $temptoken = Str::random(60);
                $requestid = Crypt::encrypt($request->request_id);
                $link = URL::temporarySignedRoute(
                            'clinic.verify_access',        // route name
                            now()->addDays(7),             // expires in 7 days
                            [
                                'reqno'     => $requestid,
                                'temptoken' => $temptoken,
                            ]
                        );
                $clinicverifyaccess = [
                'link' => $link,
                'state' => $request->state,
                ];
                $clinicverifyaccess2 = [
                'link' => 'not available',
                'state' => $request->state,
                ];
                // Mail::to($request->new_clinic_email)->send(new AccessChangeVerify($clinicverifyaccess));
                // Mail::to('paras.jain31@nic.in')->send(new AccessChangeVerify($clinicverifyaccess2));

                // ✅ Update DB after successful send
                AccessChangeRequests::where('request_id', $request->request_id)
                    ->update([
                        'email_sent' => now(),
                        'token' => $temptoken,
                    ]);
                // ✅ Log success
                Log::info('Verification email sent successfully', [
                    'request_id' => $request->request_id,
                    'email'      => $request->new_clinic_email,
                ]);

            } catch (\Exception $e) {

                // ❌ Log failure
                Log::error('Verification email failed', [
                    'request_id' => $request->request_id,
                    'error'      => $e->getMessage(),
                ]);
            }
        }
        }
        DB::table('scheduler_logs')->insert([
                'job' => 'SendEmailChangeVerificationJob',
                'status' => 'completed',
                'ran_at' => now(),
            ]);
    }
}
