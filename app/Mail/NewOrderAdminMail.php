<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PhpParser\Node\Scalar\String_;

class NewOrderAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $name, String $email,String $isFiz,String $phoneNumber,String $deliveryType,String $address,String $comment)
    {
       $this->name=$name;
       $this->email=$email;
       $this->phone=$phoneNumber;
       $this->isFiz=$isFiz;
       $this->deliveryType=$deliveryType;
       $this->address=$address;
       $this->comment=$comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name');
    }
}
