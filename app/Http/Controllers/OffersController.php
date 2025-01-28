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
use Hashids\Hashids;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OffersController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = Offers::query()
            ->when(Auth::user()->driver, function ($query) {
                $query->whereNull('accepted_driver_id')
                    ->orWhere('accepted_driver_id', Auth::user()->driver->id);
            })
            ->when(!Auth::user()->driver, function ($query) {
                $query->where('offers_id', Auth::id());
            })
            ->orderBy('city_two', 'asc')
            ->get();

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
    public function show($hashid)
    {
        // $offers = Offers::with('rides')->findOrFail($id);

        // if ($offers->accepted_driver_id) {
        //     if (Auth::id() !== $offers->offers_id && (!Auth::user()->driver || Auth::user()->driver->id !== $offers->accepted_driver_id)) {
        //         abort(403, 'You are not authorized to view this ride.');
        //     }
        // }

        // $currentRide = null;

        // if (Auth::check() && Auth::user()->driver) {
        //     $currentRide = Ride::where('offer_id', $id)
        //         ->where('driver_id', Auth::user()->driver->id ?? null)
        //         ->first();
        // }

        // if ($offers->accepted_driver_id) {
        //     $acceptedRide = $offers->rides->where('driver_id', $offers->accepted_driver_id)->first();

        //     return view('offers.show', compact('offers', 'acceptedRide', 'currentRide'));
        // }

        // return view('offers.show', compact('offers', 'currentRide'));

        $hashids = new Hashids(env('APP_KEY'), 10);
        $decodedId = $hashids->decode($hashid);

        if (empty($decodedId)) {
            abort(404, 'Offer not found.');
        }

        $id = $decodedId[0];

        $offers = Offers::with('rides')->findOrFail($id);

        if ($offers->accepted_driver_id) {
            if (Auth::id() !== $offers->offers_id && (!Auth::user()->driver || Auth::user()->driver->id !== $offers->accepted_driver_id)) {
                abort(403, 'You are not authorized to view this ride.');
            }
        }

        $currentRide = null;

        if (Auth::check() && Auth::user()->driver) {
            $currentRide = Ride::where('offer_id', $id)
                ->where('driver_id', Auth::user()->driver->id ?? null)
                ->first();
        }

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

        $offer = $ride->offer;
        if (Auth::id() !== $offer->offers_id) {
            abort(403, 'You are not authorized to accept this offer.');
        }

        $offer->update([
            'accepted_driver_id' => $ride->driver_id,
        ]);

        $user = User::where('driver_id', $ride->driver_id)->first();
        if ($user) {
            $user->notify(new DriverAcceptedNotification($offer));
        }

        $hashids = new Hashids(env('APP_KEY'), 10);
        $hashedId = $hashids->encode($offer->id);

        return redirect()->route('offers.show', $hashedId)->with('success', 'Driver has been accepted successfully.');
    }

    public function showAcceptedRide($hashid)
    {
        // $offer = offers::with(['rides.driver', 'user'])->findOrFail($offerId);

        // $scheduledStartTime = Carbon::parse($offer->city_two);
        
        // $currentTime = Carbon::now('Europe/Riga');
        
        // if ($scheduledStartTime > $currentTime) {
            
        //     $timeLeftSeconds = $currentTime->diffInSeconds($scheduledStartTime, false);

        //     $timeLeftMinutes = (int)($timeLeftSeconds / 60) - 120;
        // } else {
            
        //     $timeLeftSeconds = $currentTime->diffInSeconds($scheduledStartTime, false);

        //     $timeLeftMinutes = (int)($timeLeftSeconds / 60) - 120;
        // }

        // if (Auth::id() !== $offer->offers_id && (!$offer->accepted_driver_id || Auth::user()->driver->id !== $offer->accepted_driver_id)) {
        //     abort(403, 'Unauthorized access');
        // }

        // $acceptedRide = $offer->rides->where('driver_id', $offer->accepted_driver_id)->first();

        // return view('offers.accept', compact('offer', 'acceptedRide', 'timeLeftMinutes', 'scheduledStartTime', 'currentTime'));

        $hashids = new Hashids(env('APP_KEY'), 10);
        $decodedId = $hashids->decode($hashid);

        if (empty($decodedId)) {
            abort(404, 'Offer not found.');
        }

        $offerId = $decodedId[0];

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

    public function ongoing($hashid)
    {
        // $offer = Offers::with('rides')->findOrFail($offerId);

        // if ($offer->status !== 'ongoing') {
        //     abort(403, 'This ride is not currently ongoing.');
        // }

        // $acceptedRide = $offer->rides->where('driver_id', $offer->accepted_driver_id)->first();

        // $scheduledStartTime = Carbon::parse($offer->city_two);
        // $currentTime = Carbon::now('Europe/Riga');

        // if (!$acceptedRide) {
        //     abort(404, 'No accepted ride found for this offer.');
        // }

        // return view('offers.ongoing', compact('offer', 'scheduledStartTime', 'currentTime', 'acceptedRide'));
        // Decode the hashed ID to get the numeric offer ID
        $hashids = new Hashids(env('APP_KEY'), 10);
        $decodedId = $hashids->decode($hashid);

        if (empty($decodedId)) {
            abort(404, 'Offer not found.');
        }

        $offerId = $decodedId[0];

        $offer = Offers::with('rides')->findOrFail($offerId);

        if ($offer->status !== 'ongoing') {
            abort(403, 'This ride is not currently ongoing.');
        }

        $acceptedRide = $offer->rides->where('driver_id', $offer->accepted_driver_id)->first();

        if (!$acceptedRide) {
            abort(404, 'No accepted ride found for this offer.');
        }

        $scheduledStartTime = Carbon::parse($offer->city_two);
        $currentTime = Carbon::now('Europe/Riga');

        return view('offers.ongoing', compact('offer', 'scheduledStartTime', 'currentTime', 'acceptedRide'));
    }

    public function finishRide($offerId)
    {
        $offer = Offers::findOrFail($offerId);

        if (Auth::user()->driver->id !== $offer->accepted_driver_id) {
            abort(403, 'You are not authorized to finish this ride.');
        }

        $offer->status = 'completed';
         $offer->save();

        $acceptedRide = $offer->rides->where('driver_id', $offer->accepted_driver_id)->first();

        if (!$acceptedRide) {
            return redirect()->back()->with('error', 'No accepted ride found for this offer.');
        }

        $totalPrice = $acceptedRide->price;
        $companyShare = $totalPrice * 0.10;
        $driverEarnings = $totalPrice - $companyShare;

        Payment::create([
            'driver_id' => Auth::user()->driver->id,
            'total_earnings' => $driverEarnings,
            'company_share' => $companyShare,
            'week_start' => now()->startOfWeek()->toDateString(),
            'week_end' => now()->endOfWeek()->toDateString(),
        ]);

        $driver = Auth::user()->driver;
        $driver->total_company_share += $companyShare;
        $driver->save();

        $user = User::where('id', $offer->offers_id)->first();
        if ($user) {
            $user->notify(new RateDriverNotification($offer));
        }

        $driver = User::where('driver_id', $offer->accepted_driver_id)->first();
        if ($driver) {
            $driver->notify(new RateUserNotification($offer));
        }
        

        return redirect()->route('driver.payment')->with([
            'totalPrice' => $totalPrice,
            'companyShare' => $companyShare,
            'driverEarnings' => $driverEarnings,
        ]);
    }

    public function rateDriverForm($hashid)
    {
        // $offer = Offers::findOrFail($offerId);

        // if (Auth::id() !== $offer->offers_id) {
        //     abort(403, 'You are not authorized to rate this driver.');
        // }

        // return view('offers.rate', compact('offer'));

        $hashids = new Hashids(env('APP_KEY'), 10);
        $decodedId = $hashids->decode($hashid);

        if (empty($decodedId)) {
            abort(404, 'Offer not found.');
        }

        $offerId = $decodedId[0];

        $offer = Offers::findOrFail($offerId);

        if (Auth::id() !== $offer->offers_id) {
            abort(403, 'You are not authorized to rate this driver.');
        }

        return view('offers.rate', compact('offer'));
    }

    public function submitDriverRating(Request $request, $offerId)
    {
        $offer = Offers::with('acceptedDriver')->findOrFail($offerId);

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

        $currentRating = $driver->rating ?? 0;
        $currentRatingCount = $driver->rating_count;

        $newRating = (($currentRating * $currentRatingCount) + $request->rating) / ($currentRatingCount + 1);

        $driver->update([
            'rating' => round($newRating, 1),
            'rating_count' => $currentRatingCount + 1,
        ]);

        $offer->timestamps = false;
        $offer->user_rated_driver = true;
        $offer->save();
        $offer->timestamps = true;

        return redirect()->route('offers.history')->with('success', 'Thank you for rating your driver!');
    }

    public function rateUserForm($hashid)
    {
        // $offer = Offers::findOrFail($offerId);

        // if (Auth::user()->driver && Auth::user()->driver->id !== $offer->accepted_driver_id) {
        //     abort(403, 'You are not authorized to rate this user.');
        // }

        // return view('offers.rate_user', compact('offer'));

        // Decode the hashed ID to retrieve the numeric offer ID
        // Decode the hashed ID to retrieve the numeric offer ID
        $hashids = new Hashids(env('APP_KEY'), 10);
        $decodedId = $hashids->decode($hashid);

        if (empty($decodedId)) {
            abort(404, 'Offer not found.');
        }

        $offerId = $decodedId[0];

        $offer = Offers::findOrFail($offerId);

        if (Auth::user()->driver && Auth::user()->driver->id !== $offer->accepted_driver_id) {
            abort(403, 'You are not authorized to rate this user.');
        }

        return view('offers.rate_user', compact('offer'));
    }

    public function submitUserRating(Request $request, $offerId)
    {
        $offer = Offers::findOrFail($offerId);

        if (Auth::user()->driver && Auth::user()->driver->id !== $offer->accepted_driver_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'feedback' => 'nullable|string|max:500',
        ]);

        $user = User::where('id', $offer->offers_id)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'No user found for this ride.');
        }

        $currentRating = $user->rating ?? 0;
        $currentRatingCount = $user->rating_count;

        $newRating = (($currentRating * $currentRatingCount) + $request->rating) / ($currentRatingCount + 1);

        $user->update([
            'rating' => round($newRating, 1),
            'rating_count' => $currentRatingCount + 1,
        ]);

        $offer->timestamps = false;
        $offer->driver_rated_user = true;
        $offer->save();
        $offer->timestamps = true;

        return redirect()->route('offers.history')->with('success', 'Thank you for rating the user!');
    }


    public function showHistory()
    {
        $completedOffers = Offers::where('status', 'completed')
            ->where(function ($query) {
                $query->where('offers_id', Auth::id())
                    ->orWhereHas('rides', function ($q) {
                        $q->where('driver_id', Auth::user()->driver->id ?? null);
                    });
            })
            ->with(['rides' => function ($query) {
                $query->select('offer_id', 'price', 'driver_id');
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

        $creator = User::find($offers->offers_id);
        if ($creator) {
            $creator->notify(new RideCancelledNotification($offers));
        }

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
