<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RenewalApproveRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $renewal_registration_details;
    
    public function __construct($renewal_registration_details)
    {
        
        $this->renewal_registration_details=$renewal_registration_details;

        //
    }
    public function build()
    {
            // Construct the custom link
        return $this
        // Renewal Application Approved – Application No. $this->renewal_registration_details['applicationNo']
            ->subject("Renewal Application " . $this->renewal_registration_details['status'] . " – Application No. " . $this->renewal_registration_details['applicationNo']) // Define the email subject
            ->view('mailer.renewal_approve_rejected') // Define the view for the email content
            ->with([
                'clinic_name' => $this->renewal_registration_details['clinic_name'],
                'applicationNo' => $this->renewal_registration_details['applicationNo'],
                'reg_rej_no' => $this->renewal_registration_details['reg_rej_no'],
                'status' => $this->renewal_registration_details['status'],
                'certificate_valid_date'=> $this->renewal_registration_details['certificate_valid_date'],
                'reg_rej_date' => $this->renewal_registration_details['reg_rej_date'],
                'state_name' => $this->renewal_registration_details['state_name'],
                'state_email' => $this->renewal_registration_details['state_email'],
            ]);
    }
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
