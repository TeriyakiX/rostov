<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendDocumentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $phone;
    public $email;
    public $typeOfRequest;
    public $link;
    public $documentName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name='',$phone = '', $email = '', $typeOfRequest = '', $link = '', $documentName = '')
    {
        $this->name=$name;
        $this->email = $email;
        $this->phone = $phone;
        $this->typeOfRequest = $typeOfRequest;
        $this->link = $link;
        $this->documentName = $documentName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Консультация')->view('mail.send_document_mail', [
            'name'=>$this->name,
            'phone' => $this->phone, 'email' => $this->email, 'typeOfRequest' => $this->typeOfRequest,
            'link' => $this->link, 'documentName' => $this->documentName
        ]);
    }
}
