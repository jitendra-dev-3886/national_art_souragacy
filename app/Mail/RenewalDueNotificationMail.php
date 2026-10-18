<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RenewalDueNotificationMail extends Mailable
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
    { // Construct the custom link
        return $this
        // Renewal Application Approved – Application No. $this->renewal_registration_details['applicationNo']
            ->subject("Registration Renewal Due – National ART & Surrogacy Registry") // Define the email subject
            ->view('mailer.renewal_due_notification') // Define the view for the email content
            ->with([
                'clinic_name' => $this->renewal_registration_details['name'],
                'state' => $this->renewal_registration_details['state']
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
