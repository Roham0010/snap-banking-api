<?php

namespace App\Broadcasting;

use App\Models\User;
use App\Services\SMS\SMSServiceInterface;
use Faker\Provider\bg_BG\PhoneNumber;
use Illuminate\Notifications\Notification;

class SMSChannel
{

    protected $smsService;
    /**
     * Create a new channel instance.
     */
    public function __construct(SMSServiceInterface $smsService)
    {
        $this->smsService = $smsService;
    }

    public function send($notifiable, Notification $notification)
    {
        if (method_exists($notification, 'toSMS')) {
            $message = $notification->toSMS($notifiable);
            return $this->smsService->sendSMS($message['phoneNumber'], $message['message']);
        }
    }
}
