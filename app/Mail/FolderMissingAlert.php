<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FolderMissingAlert extends Mailable
{
  use Queueable, SerializesModels;

   public $messageContent; // your custom data

public function __construct($messageContent)
{
    $this->messageContent = $messageContent;
}

public function build()
{
    return $this->subject('Folder Missing Alert')
                ->view('mailer.folder_missing')
                ->with([
                    'messageContent' => $this->messageContent,
                ]);
}

}