<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOrderMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $requestData;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('email.orderstatusqueueprocess', [
            'data1' => $this->requestData,
        ], function ($message) {
            $message->from('hello@marlows-diamonds.co.uk');
            $message->to('sharma.gajendra@dotsquares.com', 'Customer')->bcc('sharma.gajendra@dotsquares.com','Admin')->subject('Order History');
            // $message->cc('gajendra30@gmail.com', 'Admin')->subject('New Website Inquiry local');
        });
    }
}
