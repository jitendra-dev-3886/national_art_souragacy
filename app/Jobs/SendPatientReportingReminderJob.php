<?php

namespace App\Jobs;

use App\Mail\PatientReportingReminderMail;
use App\Models\patient\PatientReportingReminderLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPatientReportingReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $clinic;

    public function __construct($clinic)
    {
        $this->clinic = $clinic;
    }

    public function handle()
    {
        Mail::to($this->clinic->email)
            ->send(new PatientReportingReminderMail($this->clinic));

        PatientReportingReminderLog::create([
            'clinic_id'        => $this->clinic->clinic_id,
            'clinic_type'      => $this->clinic->clinic_type,
            'email'            => $this->clinic->email,
            'reminder_month'   => now()->format('Y-m'),
            'sent_at'          => now(),
            'status'           => 'Sent'
        ]);
    }
}