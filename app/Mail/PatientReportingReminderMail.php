<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class PatientReportingReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $clinic;

    public function __construct($clinic)
    {
        $this->clinic = $clinic;
    }

    public function build()
    {
        // return $this->subject('Reminder test mail')
        //             ->view('mailer.patient_reporting_reminder');
        return $this->subject('Reminder for Commencement of Patient Data Reporting on the National ART & Surrogacy Registry Portal.')
                    ->view('mailer.patient_reporting_reminder');
    }
}