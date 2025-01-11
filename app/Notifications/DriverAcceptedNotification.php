<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DriverAcceptedNotification extends Notification
{
    use Queueable;

    protected $offer;

    public function __construct($offer)
    {
        $this->offer = $offer;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Ride Accepted',
            'body' => 'Your ride application has been accepted.',
            'offer_id' => $this->offer->id,
            'pick_up' => $this->offer->location_one,
            'drop_off' => $this->offer->city_one,
            'date_time' => $this->offer->city_two,
        ];
    }
}
