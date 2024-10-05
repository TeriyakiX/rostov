<?php

namespace App\Jobs;

use App\Mail\ClientMessage;
use App\Models\ManagerContacts;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class QueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $name;
    public $address;
    public $body;
    public $order;

    /**
     * Create a new job instance.
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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to(ManagerContacts::firstOrFail())->send(new ClientMessage($this->name, $this->address, $this->body, $this->order));
    }
}
