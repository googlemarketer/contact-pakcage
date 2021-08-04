<?php

namespace Googlemarketer\Contact\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message,  $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $name)
    {
        $this->message = $message;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $thisd
     */
    public function build()
    {
        return $this->markdown('contact::contacts.email')->with(['message' => $this->message, 'name' => $this->name]);
    }
}
