<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class CompleteOrder extends Mailable
{
    public $password;
    public function __construct($password)
    {
        $this->password = $password;
    }
    public function build()
    {
        return $this->subject('Регистрация после оформления заказа')->view('posts.completeorder',['password'=>$this->password]);
    }
}
