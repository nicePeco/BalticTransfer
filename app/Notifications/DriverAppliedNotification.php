<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Ride;

class DriverAppliedNotification extends Notification
{
    use Queueable;

    protected $ride;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ride $ride)
    {
        $this->ride = $ride;
    }

    /**
     * Determine the notification delivery channels.
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
            'title' => 'New Driver Application',
            'body' => 'A driver has applied for your ride from ' . $this->ride->offer->location_one . ' to ' . $this->ride->offer->city_one . '.',
            'offer_id' => $this->ride->offer->id,
            'driver_name' => $this->ride->driver->name,
        ];
    }
}
