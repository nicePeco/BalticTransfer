<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RideCancelledNotification extends Notification
{
    use Queueable;

    protected $offer;

    /**
     * Create a new notification instance.
     */
    public function __construct($offer)
    {
        $this->offer = $offer;
    }

    /**
     * Determine which channels this notification should be sent through.
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the notification data to be stored in the database.
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'Ride Canceled',
            'body' => "Ride has been canceled from {$this->offer->location_one} to {$this->offer->city_one}.",
            'offer_id' => $this->offer->id,
        ];
    }
}
