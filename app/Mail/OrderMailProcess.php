<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMailProcess extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $requestData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.orderstatusqueueprocess')->with([
            'data1' => $this->requestData,
        ])->subject('Order History');
    }
}
