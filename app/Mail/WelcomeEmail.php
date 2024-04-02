<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable implements ShouldQueue
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
        return $this->view('email.mail')->with([
            'title' => $this->requestData['title'],
            'email' => $this->requestData['email'],
            'phone' => $this->requestData['phone'],
            'url' => $this->requestData['custom_url'],
            'user_query' => $this->requestData['description'],
        ])->subject('New Website Inquiry');
    }
}
