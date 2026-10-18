<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccessChangeRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $accesschangerequest;

    public function __construct($accesschangerequest)
    {
        
        $this->accesschangerequest=$accesschangerequest;

        //
    }
    public function build()
    {
        return $this
            ->subject('Request to Update Registered Clinic Email ID.') // Define the email subject
            ->view('mailer.access_change_request') // Define the view for the email content
            ->with([
                'state' => $this->accesschangerequest['state'], // Pass the reset link to the view
                'link'  => $this->accesschangerequest['link']
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
