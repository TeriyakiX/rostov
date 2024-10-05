<?php

namespace App\Mail;

use http\Env\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $address;
    public $phone;
    public $comment;
    public $typeOfRequest;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($address, $phone, $comment,$typeOfRequest='')
    {
        $this->address = $address;
        $this->phone = $phone;
        $this->comment = $comment;
        $this->typeOfRequest=$typeOfRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Форма вопрос')
            ->view('posts.send_email');
    }
}
