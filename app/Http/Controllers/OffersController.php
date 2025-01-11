<?php

namespace App\Http\Controllers;

use App\Models\offers;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Ride;
use App\Models\User;
use App\Notifications\DriverAcceptedNotification;
use App\Notifications\RateDriverNotification;
use App\Notifications\RateUserNotification;
use App\Notifications\RideCancelledNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $offers = Offers::query()
        // ->when(Auth::user()->driver, function ($query) {
        //     // For drivers, only show unaccepted offers or their accepted offers
        //     $query->whereNull('accepted_driver_id')
        //           ->orWhere('accepted_driver_id', Auth::user()->driver->id);
        // })
        // ->when(!Auth::user()->driver, function ($query) {
        //     // For non-drivers (offer creators), show only their offers
        //     $query->where('offers_id', Auth::id());
        // })
        // ->get();

        // return view('offers.index', compact('offers'));
        $offers = Offers::query()
            ->when(Auth::user()->driver, function ($query) {
                // For drivers: Show unaccepted offers or offers accepted by this driver
                $query->whereNull('accepted_driver_id')
                    ->orWhere('accepted_driver_id', Auth::user()->driver->id);
            })
            ->when(!Auth::user()->driver, function ($query) {
                // For regular users: Show only their offers
                $query->where('offers_id', Auth::id());
            })
            ->orderBy('city_two', 'asc') // Sort offers by closest pick-up time
            ->get();

        // For drivers: Retrieve IDs of applied offers to show "Applied" status
        $appliedOffers = [];
        if (Auth::user()->driver) {
            $appliedOffers = Auth::user()->driver->rides()->pluck('offer_id')->toArray();
        }

        return view('offers.index', compact('offers', 'appliedOffers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        offers::create([
            'location_one' => $request->get('location_one'),
            'city_one' => $request->get('city_one'),
            'location_two' => $request->get('location_two'),
            'city_two' => $request->get('city_two'),
            'information' => $request->get('information'),
            'distance' => $request->get('distance'),
            'time' => $request->get('time'),  
            'offers_id' => $request->get('offers_id'),
        ]);

        return redirect()->route('client.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $offers = Offers::with('rides')->findOrFail($id);

        // Check if the offers is accepted
        if ($offers->accepted_driver_id) {
            // Restrict visibility to the offers creator and the accepted driver
            if (Auth::id() !== $offers->offers_id && (!Auth::user()->driver || Auth::user()->driver->id !== $offers->accepted_driver_id)) {
                abort(403, 'You are not authorized to view this ride.');
            }
        }

        $currentRide = null;

        // If the user is authenticated and is a driver, find their ride application for this offers
        if (Auth::check() && Auth::user()->driver) {
            $currentRide = Ride::where('offer_id', $id)
                ->where('driver_id', Auth::user()->driver->id ?? null)
                ->first();
        }

        // Check if there is an accepted ride for this offers
        if ($offers->accepted_driver_id) {
            $acceptedRide = $offers->rides->where('driver_id', $offers->accepted_driver_id)->first();

            return view('offers.show', compact('offers', 'acceptedRide', 'currentRide'));
        }

        return view('offers.show', compact('offers', 'currentRide'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(offers $offers)
    {
        return view('offers.edit', compact('offers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, offers $offers)
    {
        $offers->update([
            'location_one' => $request->get('location_one'),
            'city_one' => $request->get('city_one'),
            'location_two' => $request->get('location_two'),
            'city_two' => $request->get('city_two'),
            'information' => $request->get('information'),
        ]);

        return redirect()->route('client.index');
    }

    public function acceptRide(Request $request, $rideId)
    {
        $ride = Ride::findOrFail($rideId);

        // Check if the authenticated user owns the offer
        $offer = $ride->offer;
        if (Auth::id() !== $offer->offers_id) {
            abort(403, 'You are not authorized to accept this offer.');
        }

        // Update the accepted driver ID for the offer
        $offer->update([
            'accepted_driver_id' => $ride->driver_id,
        ]);

        // Notify the driver (linked user)
        $user = User::where('driver_id', $ride->driver_id)->first(); // Find the user by driver_id
        if ($user) {
            $user->notify(new DriverAcceptedNotification($offer)); // Notify the User model
        }

        return redirect()->route('offers.show', $offer->id)->with('success', 'Driver has been accepted successfully.');
    }

    // public function cancel(offers $offer)
    // {
    //     // if ($offer->accepted_driver_id) {
    //     //     $offer->delete();
    //     //     return redirect()->route('client.index')->with('success', 'The ride offer has been successfully canceled.');
    //     // }

    //     // return redirect()->route('offers.show', $offer->id)->with('error', 'No accepted ride to cancel.');
    //     // Check if the offer has an accepted driver
    //     if ($offer->accepted_driver_id) {
    //         // Clear the accepted driver ID
    //         $offer->update([
    //             'accepted_driver_id' => null,
    //         ]);

    //         return redirect()->route('client.index')->with('success', 'The ride offer has been successfully canceled.');
    //     }

    //     return redirect()->route('offers.show', $offer->id)->with('error', 'No accepted ride to cancel.');
    //     }

    public function showAcceptedRide($offerId)
    {
        $offer = offers::with(['rides.driver', 'user'])->findOrFail($offerId);

        $scheduledStartTime = Carbon::parse($offer->city_two);
        
        $currentTime = Carbon::now('Europe/Riga');
        
        if ($scheduledStartTime > $currentTime) {
            
            $timeLeftSeconds = $currentTime->diffInSeconds($scheduledStartTime, false);

            $timeLeftMinutes = (int)($timeLeftSeconds / 60) - 120;
        } else {
            
            $timeLeftSeconds = $currentTime->diffInSeconds($scheduledStartTime, false);

            $timeLeftMinutes = (int)($timeLeftSeconds / 60) - 120;
        }

        if (Auth::id() !== $offer->offers_id && (!$offer->accepted_driver_id || Auth::user()->driver->id !== $offer->accepted_driver_id)) {
            abort(403, 'Unauthorized access');
        }

        $acceptedRide = $offer->rides->where('driver_id', $offer->accepted_driver_id)->first();

        return view('offers.accept', compact('offer', 'acceptedRide', 'timeLeftMinutes', 'scheduledStartTime', 'currentTime'));
    }

    public function startRide($offerId)
    {
        $offer = Offers::findOrFail($offerId); 

         $scheduledStartTime = Carbon::parse($offer->city_two);
        
         $currentTime = Carbon::now('Europe/Riga');
         
         if ($scheduledStartTime > $currentTime) {
             
             $timeLeftSeconds = $currentTime->diffInSeconds($scheduledStartTime, false);

             $timeLeftMinutes = (int)($timeLeftSeconds / 60) - 120;
         } else {
             
            $timeLeftMinutes = -1;
         }

         $offer->status = 'ongoing';
         $offer->save();

         $acceptedRide = $offer->rides->where('driver_id', $offer->accepted_driver_id)->first();

        return view('offers.ongoing', compact('timeLeftMinutes', 'scheduledStartTime', 'currentTime', 'offer', 'acceptedRide')); 
    }

    public function ongoing($offerId)
    {
        // Retrieve the offer using the provided ID
        $offer = Offers::with('rides')->findOrFail($offerId);

        // Check if the status is 'ongoing'
        if ($offer->status !== 'ongoing') {
            abort(403, 'This ride is not currently ongoing.');
        }

        $acceptedRide = $offer->rides->where('driver_id', $offer->accepted_driver_id)->first();

        // Fetch necessary information
        $scheduledStartTime = Carbon::parse($offer->city_two);
        $currentTime = Carbon::now('Europe/Riga');

        if (!$acceptedRide) {
            abort(404, 'No accepted ride found for this offer.');
        }

        // Pass the information to the view
        return view('offers.ongoing', compact('offer', 'scheduledStartTime', 'currentTime', 'acceptedRide'));
    }

    public function finishRide($offerId)
    {
        $offer = Offers::findOrFail($offerId);

        // Ensure only the accepted driver can finish the ride
        if (Auth::user()->driver->id !== $offer->accepted_driver_id) {
            abort(403, 'You are not authorized to finish this ride.');
        }

        // Update the offer status to 'completed'
        $offer->status = 'completed';
         $offer->save();

        $acceptedRide = $offer->rides->where('driver_id', $offer->accepted_driver_id)->first();

        if (!$acceptedRide) {
            return redirect()->back()->with('error', 'No accepted ride found for this offer.');
        }

        $totalPrice = $acceptedRide->price;
        $companyShare = $totalPrice * 0.10; // 10% for the company
        $driverEarnings = $totalPrice - $companyShare;

        Payment::create([
            'driver_id' => Auth::user()->driver->id,
            'total_earnings' => $driverEarnings,
            'company_share' => $companyShare,
            'week_start' => now()->startOfWeek()->toDateString(),
            'week_end' => now()->endOfWeek()->toDateString(),
        ]);

        $user = User::where('id', $offer->offers_id)->first(); // Assuming 'offers_id' is the user ID
        if ($user) {
            $user->notify(new RateDriverNotification($offer)); // Notify the user
        }

        $driver = User::where('driver_id', $offer->accepted_driver_id)->first();
        if ($driver) {
            $driver->notify(new RateUserNotification($offer)); // Notify the driver
        }
        
        // $offer->user->notify(new RateDriverNotification($offer));

        return redirect()->route('driver.payment')->with([
            'totalPrice' => $totalPrice,
            'companyShare' => $companyShare,
            'driverEarnings' => $driverEarnings,
        ]);
    }

    public function rateDriverForm($offerId)
    {
        $offer = Offers::findOrFail($offerId);

        // Ensure only the user who created the offer can rate the driver
        if (Auth::id() !== $offer->offers_id) {
            abort(403, 'You are not authorized to rate this driver.');
        }

        return view('offers.rate', compact('offer'));
    }

    public function submitDriverRating(Request $request, $offerId)
    {
        $offer = Offers::with('acceptedDriver')->findOrFail($offerId);

        // Ensure the user is authorized to rate this ride
        if (Auth::id() !== $offer->offers_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'feedback' => 'nullable|string|max:500',
        ]);

        $driver = $offer->acceptedDriver;

        if (!$driver) {
            return redirect()->back()->with('error', 'No driver found for this ride.');
        }

        // Update the driver's rating
        $currentRating = $driver->rating ?? 0;
        $currentRatingCount = $driver->rating_count;

        $newRating = (($currentRating * $currentRatingCount) + $request->rating) / ($currentRatingCount + 1);

        $driver->update([
            'rating' => round($newRating, 1),
            'rating_count' => $currentRatingCount + 1,
        ]);

        $offer->timestamps = false; // Temporarily disable timestamps
        $offer->user_rated_driver = true;
        $offer->save();
        $offer->timestamps = true; // Re-enable timestamps

        return redirect()->route('offers.history')->with('success', 'Thank you for rating your driver!');
    }

    public function rateUserForm($offerId)
    {
        $offer = Offers::findOrFail($offerId);

        // Ensure only the driver of the ride can rate the user
        if (Auth::user()->driver && Auth::user()->driver->id !== $offer->accepted_driver_id) {
            abort(403, 'You are not authorized to rate this user.');
        }

        return view('offers.rate_user', compact('offer'));
    }

    public function submitUserRating(Request $request, $offerId)
    {
        $offer = Offers::findOrFail($offerId);

        // Ensure only the driver of the ride can rate the user
        if (Auth::user()->driver && Auth::user()->driver->id !== $offer->accepted_driver_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'feedback' => 'nullable|string|max:500',
        ]);

        // Retrieve the user to be rated
        $user = User::where('id', $offer->offers_id)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'No user found for this ride.');
        }

        // Calculate the new rating
        $currentRating = $user->rating ?? 0;
        $currentRatingCount = $user->rating_count;

        $newRating = (($currentRating * $currentRatingCount) + $request->rating) / ($currentRatingCount + 1);

        $user->update([
            'rating' => round($newRating, 1),
            'rating_count' => $currentRatingCount + 1,
        ]);

        // Update the offer to indicate the driver has rated the user
        $offer->timestamps = false; // Disable timestamps temporarily
        $offer->driver_rated_user = true;
        $offer->save();
        $offer->timestamps = true; // Re-enable timestamps

        return redirect()->route('offers.history')->with('success', 'Thank you for rating the user!');
    }


    public function showHistory()
    {
        $completedOffers = Offers::where('status', 'completed')
            ->where(function ($query) {
                $query->where('offers_id', Auth::id()) // Rides created by the user
                    ->orWhereHas('rides', function ($q) {
                        $q->where('driver_id', Auth::user()->driver->id ?? null); // Rides driven by the driver
                    });
            })
            ->with(['rides' => function ($query) {
                $query->select('offer_id', 'price', 'driver_id'); // Include price in the query
            }])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('offers.history', compact('completedOffers'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(offers $offers)
    {
        // $offers->delete();

        // return redirect()->route('client.index');
        // Get the user who created the offer
        // Notify the offer creator
        $creator = User::find($offers->offers_id);
        if ($creator) {
            $creator->notify(new RideCancelledNotification($offers));
        }

        // Notify the driver (if an accepted driver exists)
        if ($offers->accepted_driver_id) {
            $driver = User::where('driver_id', $offers->accepted_driver_id)->first();
            if ($driver) {
                $driver->notify(new RideCancelledNotification($offers));
            }
        }

        $offers->delete();

        return redirect()->route('client.index')->with('success', 'The ride has been successfully cancelled.');
    }

    public function test() 
    {
        return view('offers.test');
    }
}
