<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $requestData;
    protected $adminEmail;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($requestData, $adminEmail)
    {
        $this->requestData = $requestData;
        $this->adminEmail = $adminEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('email.mail', [
            'title' => $this->requestData['title'],
            'email' => $this->requestData['email'],
            'phone' => $this->requestData['phone'],
            'url' => $this->requestData['custom_url'],
            'user_query' => $this->requestData['description'],
        ], function ($message) {
            $message->from('hello@marlows-diamonds.co.uk');
            $message->to('sharma.gajendra@dotsquares.com', 'Admin')->subject('New Website Enquiry local');
            // $message->cc('gajendra30@gmail.com', 'Admin')->subject('New Website Enquiry local');
        });
    }
}
