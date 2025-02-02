<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\CarPhoto;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        //3.12
        $user = Auth::user();
        $driver = $user->driver; 

        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->validate([
            'car_make' => ['nullable', 'string', 'max:255'],
            'car_model' => ['nullable', 'string', 'max:255'],
            'car_year' => ['nullable', 'integer', 'digits:4'],
            'car_photo' => ['nullable', 'image'],
        ]);

        $user = Auth::user();

        if ($user->driver) {
            $driver = $user->driver;

            $driver->update([
                'car_make' => $request->car_make,
                'car_model' => $request->car_model,
                'car_year' => $request->car_year,
            ]);

            if ($request->hasFile('car_photo')) {
                $path = $request->file('car_photo')->store('car_photos', 'public');
                $driver->update(['car_photo' => $path]);
            }
        }

        return redirect()->route('profile.edit')->with('status', 'Car information updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function show(Request $request)
    {
        return view('profile.picture');

    }

    public function upload(Request $request)
    {
        // $user = Auth::user();

        // if ($request->hasFile('profile_photo')) {
        //     $path = $request->profile_photo->store('images', 'public');
            
        //     $user->update([
        //         'profile_photo' => $path
        //     ]);
        // }

        // return redirect()->route('profile.photo');
        $user = Auth::user();

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
    
            $path = $request->profile_photo->store('images', 'public');
    
            $user->update([
                'profile_photo' => $path
            ]);
        }
    
        return redirect()->route('profile.photo')->with('success', 'Profile photo updated successfully!');
    }

    //12.3
    public function editDriver()
    {
        $user = Auth::user();

        if (!$user->driver) {
            abort(403, 'Unauthorized action.');
        }

        $driver = $user->driver;

        return view('driver.driver-edit', compact('driver'));
    }

    public function updateDriver(Request $request)
    {
        // $request->validate([
        //     'car_make' => ['nullable', 'string', 'max:255'],
        //     'car_model' => ['nullable', 'string', 'max:255'],
        //     'car_year' => ['nullable', 'integer', 'digits:4'],
        //     'car_photo' => ['nullable', 'image'],
        // ]);

        // $user = Auth::user();

        // $driver = $user->driver;

        // $driver->update([
        //     'car_make' => $request->car_make,
        //     'car_model' => $request->car_model,
        //     'car_year' => $request->car_year,
        // ]);

        // if ($request->hasFile('car_photo')) {
        //     if ($driver->car_photo) {
        //         Storage::disk('public')->delete($driver->car_photo);
        //     }
    
        //     $path = $request->file('car_photo')->store('car_photos', 'public');
        //     $driver->update(['car_photo' => $path]);
        // }

        // return redirect()->route('profile.edit')->with('status', 'Driver information updated successfully.');
        $request->validate([
            'car_make' => ['nullable', 'string', 'max:255'],
            'car_model' => ['nullable', 'string', 'max:255'],
            'car_year' => ['nullable', 'integer', 'digits:4'],
            'license_plate' => ['nullable', 'string', 'max:20'],
        ]);

        $user = Auth::user();
        $driver = $user->driver;

        $driver->update([
            'car_make' => $request->car_make,
            'car_model' => $request->car_model,
            'car_year' => $request->car_year,
            'license_plate' => $request->license_plate,
        ]);

        return redirect()->route('profile.edit')->with('status', 'Car information updated successfully.');
    }

    public function updateCarPhotos(Request $request)
    {
        $request->validate([
            'car_photos' => ['required'],
            'car_photos.*' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);
    
        $user = Auth::user();
        $driver = $user->driver;

        if ($request->hasFile('car_photos')) {
            $existingPhotoCount = $driver->carPhotos()->count();
            $newPhotos = $request->file('car_photos');
    
            if ($existingPhotoCount + count($newPhotos) > 10) {
                return redirect()->back()->withErrors(['car_photos' => 'You can only upload up to 10 car photos.']);
            }
    
            foreach ($newPhotos as $photo) {
                $path = $photo->store('car_photos', 'public');
    
                CarPhoto::create([
                    'driver_id' => $driver->id,
                    'photo_path' => $path
                ]);
            }
        }
    
        return redirect()->route('profile.edit')->with('status', 'Car photos uploaded successfully.');
    }

    public function deleteCarPhoto($id)
    {
        $photo = CarPhoto::findOrFail($id);

        if (Auth::user()->driver->id !== $photo->driver_id) {
            abort(403, 'Unauthorized action.');
        }

        Storage::disk('public')->delete($photo->photo_path);

        $photo->delete();

        return redirect()->route('profile.edit')->with('status', 'Car photo deleted successfully.');
    }

    public function updateMainCarPhoto(Request $request)
    {
        $request->validate([
            'main_car_photo' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $user = Auth::user();
        $driver = $user->driver;

        if ($request->hasFile('main_car_photo')) {
            if ($driver->car_photo) {
                Storage::disk('public')->delete($driver->car_photo);
            }

            $path = $request->file('main_car_photo')->store('car_photos/main', 'public');

            $driver->update(['car_photo' => $path]);
        }

        return redirect()->route('profile.edit')->with('status', 'Main car photo updated successfully.');
    }

}
