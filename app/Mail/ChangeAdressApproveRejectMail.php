<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChangeAdressApproveRejectMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $change_address_registration_details;
    
    public function __construct($change_address_registration_details)
    {
        
        $this->change_address_registration_details=$change_address_registration_details;

        //
    }
    public function build()
    {
            // Construct the custom link
        return $this
        // Change Addrees Application Approved – Application No. $this->change_address_registration_details['applicationNo']
            ->subject("Change Addrees Application " . $this->change_address_registration_details['status'] . " – Application No. " . $this->change_address_registration_details['applicationNo']) // Define the email subject
            ->view('mailer.change_address_approve_reject') // Define the view for the email content
            ->with([
                'clinic_name' => $this->change_address_registration_details['clinic_name'],
                'applicationNo' => $this->change_address_registration_details['applicationNo'],
                'reg_rej_no' => $this->change_address_registration_details['reg_rej_no'],
                'status' => $this->change_address_registration_details['status'],
                'certificate_valid_date'=> $this->change_address_registration_details['certificate_valid_date'],
                'reg_rej_date' => $this->change_address_registration_details['reg_rej_date'],
                'state_name' => $this->change_address_registration_details['state_name'],
                'state_email' => $this->change_address_registration_details['state_email'],
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
