<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChangeNameApproveRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $change_name_registration_details;
    
    public function __construct($change_name_registration_details)
    {
        
        $this->change_name_registration_details=$change_name_registration_details;

        //
    }
    public function build()
    {
            // Construct the custom link
        return $this
        // change_name Application Approved – Application No. $this->change_name_registration_details['applicationNo']
            ->subject("Change Name Application " . $this->change_name_registration_details['status'] . " – Application No. " . $this->change_name_registration_details['application_no']) // Define the email subject
            ->view('mailer.changename_approve_rejected') // Define the view for the email content
            ->with([
                'name' => $this->change_name_registration_details['name'],
                'application_no' => $this->change_name_registration_details['application_no'],
                'registration_no' => $this->change_name_registration_details['registration_no'],
                'status' => $this->change_name_registration_details['status'],
                'certificate_valid_date'=> $this->change_name_registration_details['certificate_valid_date'],
                'reg_rej_date' => $this->change_name_registration_details['reg_rej_date'],
                'state_name' => $this->change_name_registration_details['state_name'],
                'state_email' => $this->change_name_registration_details['state_email'],
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
