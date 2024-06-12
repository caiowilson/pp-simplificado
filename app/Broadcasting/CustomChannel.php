<?php

namespace App\Broadcasting;

use App\Notifications\TransactionNotification;

class CustomChannel
{
    public function send($notifiable, TransactionNotification $notification)
    {
        if (method_exists($notification, 'toCustom')) {
            return $notification->toCustom($notifiable);
        }
    }
}
