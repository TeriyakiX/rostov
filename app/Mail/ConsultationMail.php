<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConsultationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $phone_number;
    public $email;
    public $link;
    public $typeOfRequest;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $phone_number, $email,$link,$typeOfRequest)
    {
        $this->name = $name;
        $this->phone_number = $phone_number;
        $this->email = $email;
        $this->link=$link;
        $this->typeOfRequest=$typeOfRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Консультация')->markdown('mail.consultation_email');
    }
}
