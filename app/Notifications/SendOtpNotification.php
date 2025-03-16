<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\NexmoMessage;

class SendOtpNotification extends Notification
{
    use Queueable;

    protected $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function via($notifiable)
    {
        return ['nexmo']; // Change this to your SMS provider (e.g., Twilio, Semaphore)
    }

    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content("Your OTP code is: {$this->otp}");
    }
}
