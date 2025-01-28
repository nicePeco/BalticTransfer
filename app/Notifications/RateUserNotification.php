<?php

namespace App\Notifications;

use App\Models\offers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RateUserNotification extends Notification
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
            'title' => 'Rate the user for the completed ride',
            'body' => 'The ride from ' . $this->offer->location_one . ' to ' . $this->offer->city_one . ' has been completed. Please rate the user in the ride history tab.',
            'offer_id' => $this->offer->id,
            // 'route' => route('offers.rateUser', ['offer_id' => $this->offer->id]),
            'user_name' => $this->offer->user->name ?? 'Unknown User',
        ];
    }
}
