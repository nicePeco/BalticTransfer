<?php

namespace App\Notifications;

use App\Models\offers;
use App\Models\Ride;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RateDriverNotification extends Notification
{
    use Queueable;

    protected $offer;

    /**
     * Create a new notification instance.
     */
    public function __construct(offers $offer)
    {
        $this->offer = $offer;
    }

    /**
     * Determine the delivery channels.
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'Your ride has ended',
            'body' => 'Please rate your driver for the ride from ' . $this->offer->location_one . ' to ' . $this->offer->city_one . ' in the ride history tab.',
            'offer_id' => $this->offer->id,
            // 'route' => route('offers.rate', ['offer_id' => $this->offer->id]),
            'driver_name' => $this->acceptedRide->driver->name ?? 'Unknown Driver',
        ];
    }
}
