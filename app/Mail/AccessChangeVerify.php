<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccessChangeVerify extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $accesschangeverify;
    
    public function __construct($accesschangeverify)
    {
        
        $this->accesschangeverify=$accesschangeverify;

        //
    }
    public function build()
    {
            // Construct the custom link
        return $this
            ->subject('Clinic Email Change Request – Verification Required') // Define the email subject
            ->view('mailer.access_change_verify') // Define the view for the email content
            ->with([
                'link' => $this->accesschangeverify['link'], // Pass the reset link to the view
                'state' => $this->accesschangeverify['state'],
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
