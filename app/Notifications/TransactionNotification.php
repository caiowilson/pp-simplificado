<?php

namespace App\Notifications;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;

class TransactionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 10;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        //send notification with guzzle via http post on https://util.devi.tools/api/v1/notify
        return ['custom'];
    }

    public function toCustom($notifiable)
    {
        $client = new Client;
        $url = 'https://util.devi.tools/api/v1/notify';

        try {
            $response = $client->post($url, [
                'json' => [
                    'data' => [
                        'email' => $notifiable->email,
                        'message' => "Transaction Successful"
                    ]
                ]
            ]);

            // handle response if needed
            $body = $response->getBody();
            $content = $body->getContents();

            // Log the response or do something with it
            Log::info('Guzzle Notification POST Response: ' . $content, ['status' => $response->getStatusCode()]);
        } catch (\Exception $e) {
            // Handle the exception if the request fails
            Log::error('Error sending notification: ' . $e->getMessage(), ['exception' => $e]);

        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
