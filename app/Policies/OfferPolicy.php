<?php

namespace App\Policies;

use App\Models\Offers;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class OfferPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view the offer.
     */
    public function view(User $user, Offers $offer)
    {
        return $user->id === $offer->offers_id || 
               ($user->driver && $user->driver->id === $offer->accepted_driver_id);
    }

    /**
     * Determine if the user can create an offer.
     */
    public function create(User $user)
    {
        return $user->id; // Only clients can create offers
    }

    /**
     * Determine if the user can update the offer.
     */
    public function update(User $user, Offers $offer)
    {
        return $user->id === $offer->offers_id;
    }

    /**
     * Determine if the user can delete the offer.
     */
    public function delete(User $user, Offers $offer)
    {
        return $user->id === $offer->offers_id;
    }

    /**
     * Determine if the user can accept a ride.
     */
    public function acceptRide(User $user, Offers $offer)
    {
        return $user->id === $offer->offers_id;
    }

    /**
     * Determine if the user can finish a ride.
     */
    public function finishRide(User $user, Offers $offer)
    {
        return $user->driver && $user->driver->id === $offer->accepted_driver_id;
    }
}
