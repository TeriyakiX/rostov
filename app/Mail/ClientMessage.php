<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $address;
    public $body;
    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $address, $body, $order)
    {
        $this->name = $name;
        $this->address = $address;
        $this->body = $body;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Комментарии заказчика')->markdown('mail.client_email');
    }
}
