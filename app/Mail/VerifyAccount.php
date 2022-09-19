<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyAccount extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $token = $this->details['token'];
        $email = $this->details['email'];

        return $this->from('samirhussein274@gmail.com', 'Jumia Clone')->subject('Verify Account')->html("<a href='#?token=$token&email=$email'>Verify your account</a>");
    }
}
