<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PhpParser\Node\Scalar\String_;

class SendOneClickMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var String
     * @var String
     * @var String
     * @var String
     * @var string
     */
    private $name;
    private $phoneNumber;
    private $vendorCode;
    private $deliveryMethod;
    private $address;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $name, string $phoneNumber, $vendorCode, string $deliveryMethod, string $address = null)
    {
        $this->name = $name;
        $this->phoneNumber = $phoneNumber;
        $this->vendorCode = $vendorCode;
        $this->deliveryMethod = $deliveryMethod;
        $this->address = $address;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Форма покупки в 1 клик')->view('posts.send_one_click_mail',[
            'name'=>$this->name,'phoneNumber'=>$this->phoneNumber,'vendorCode'=>$this->vendorCode,
            'deliveryMethod'=>$this->deliveryMethod,'address'=>$this->address
        ]);
    }
}
