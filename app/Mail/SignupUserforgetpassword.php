<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SignupUserforgetpassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $signuppasswordrequest;

    public function __construct($signuppasswordrequest)
    {
        
        $this->signuppasswordrequest=$signuppasswordrequest;

        //
    }
    // public function __construct()
    // {
    //     //
    // }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Userforgetpassword',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }
    public function build()
    {
        return $this
            ->subject('Reset your password for login-reg.') // Define the email subject
            ->view('mailer.signup_user_forget_password') // Define the view for the email content
            ->with([
                'link' => $this->signuppasswordrequest['link'], // Pass the reset link to the view
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
