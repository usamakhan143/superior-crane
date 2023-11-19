<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOtp extends Mailable
{
    use Queueable, SerializesModels;

    public $Otp;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($Otp)
    {
        $this->Otp = $Otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('OTP For Password Reset')->view('emails.sendotp');
    }
}
