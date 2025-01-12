<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DirectMessagesController;
use App\Http\Controllers\DriversController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NewRegisteredController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RideController;
use App\Models\Notification;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home.main');
});

Route::get('/home', [HomePageController::class, 'index'])->name('home.index');

Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

Route::get('/register/driver', [RegisteredUserController::class, 'createDriver'])->name('register.driver.form');
Route::post('/register/driver', [RegisteredUserController::class, 'storeDriver'])->name('register.driver');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

Route::get('/dashboard', function () {
    return view('home.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/messages/user', [DirectMessagesController::class, 'index'])
    ->middleware('auth')
    ->name('messages.user');
Route::post('/messages/direct', [DirectMessagesController::class, 'store'])->name('messages.direct.store');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/photo', [ProfileController::class, 'show'])->name('profile.photo');
    Route::patch('/photo', [ProfileController::class, 'upload'])->name('profile.update');
    Route::get('/offers/history', [OffersController::class, 'showHistory'])->name('offers.history');

    Route::get('/client', [ClientController::class, 'index'])->name('client.index');
    Route::get('/offers', [OffersController::class, 'index'])->name('offers.index');
    Route::post('/offers', [OffersController::class, 'store'])->name('offers.store');
    Route::get('/offers/test', [OffersController::class, 'test'])->name('offers.test');
    Route::get('/offers/{offers}', [OffersController::class, 'show'])->name('offers.show');
    Route::post('/offers/{offers}/edit', [OffersController::class, 'edit'])->name('offers.edit');
    Route::patch('/offers/{offers}', [OffersController::class, 'update'])->name('offers.update');
    Route::delete('/offers/{offers}', [OffersController::class, 'destroy'])->name('offers.destroy');
    Route::post('/offers/accept/{ride}', [OffersController::class, 'acceptRide'])->name('offers.accept');
    Route::delete('/offers/{offer}/cancel', [OffersController::class, 'cancel'])->name('offers.cancel');
    Route::get('/offers/{offer}/accept', [OffersController::class, 'showAcceptedRide'])->name('offers.accept.show');
    Route::get('/messages/{offerId?}', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    // Route::post('/notifications/{id}/read', function ($id) {
    //     $notification = auth()->user()->notifications()->findOrFail($id);
    //     $notification->markAsRead();
    //     return redirect()->back()->with('success', 'Notification marked as read.');
    // })->name('notifications.read');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/delete', [NotificationController::class, 'deleteNotification'])->name('notifications.delete');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::get('/start-ride/{offerId}', [OffersController::class, 'startRide'])->name('start.ride');
    Route::get('/offers/{offerId}/ongoing', [OffersController::class, 'ongoing'])->name('offers.ongoing');
    Route::get('/offers/{offer_id}/rate', [OffersController::class, 'rateDriverForm'])->name('offers.rate');
    Route::patch('/offers/{offerId}/finish', [OffersController::class, 'finishRide'])->name('offers.finish');
    Route::get('/driver/weekly-summary', [DriversController::class, 'weeklySummary'])->name('driver.payment');
    Route::post('/offers/{offer}/rate', [OffersController::class, 'submitDriverRating'])->name('offers.rate.submit');
    Route::get('/offers/{offer_id}/rate-user', [OffersController::class, 'rateUserForm'])->name('offers.rateUser');
    Route::post('/offers/{offer_id}/rate-user', [OffersController::class, 'submitUserRating'])->name('offers.rateUser.submit');
    // Route::get('/messages/user', [DirectMessagesController::class, 'index'])->name('messages.user');
    // Route::post('/messages/direct', [DirectMessagesController::class, 'store'])->name('messages.direct.store');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/driver-dashboard', [DriversController::class, 'index'])->name('driver.dashboard');
    Route::get('/driver/edit', [ProfileController::class, 'editDriver'])->name('driver.edit');
    Route::patch('/driver/edit', [ProfileController::class, 'updateDriver'])->name('driver.update');
    Route::post('/rides', [RideController::class, 'store'])->name('rides.store');
    Route::delete('/rides/{ride}', [RideController::class, 'destroy'])->name('rides.destroy');
    Route::get('/rides/my-applications', [RideController::class, 'myApplications'])->name('driver.applications');
    Route::post('/offers/accept/{ride}', [OffersController::class, 'acceptRide'])->name('offers.accept');
    Route::delete('/offers/{offer}/cancel', [OffersController::class, 'cancel'])->name('offers.cancel');
    Route::get('/offers/{offer}/accept', [OffersController::class, 'showAcceptedRide'])->name('offers.accept.show');
});

//admin

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'viewUsers'])->name('admin.users');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::post('/admin/users/{id}/update', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::get('/admin/drivers', [AdminController::class, 'viewDrivers'])->name('admin.drivers');
    Route::get('/admin/drivers/{id}/edit', [AdminController::class, 'editDriver'])->name('admin.drivers.edit');
    Route::post('/admin/drivers/{id}/update', [AdminController::class, 'updateDriver'])->name('admin.drivers.update');
    Route::get('/admin/rides', [AdminController::class, 'viewRides'])->name('admin.rides');
    Route::get('/admin/rides/{id}/edit', [AdminController::class, 'editRide'])->name('admin.rides.edit');
    Route::post('/admin/rides/{id}/update', [AdminController::class, 'updateRide'])->name('admin.rides.update');
    Route::get('/admin/messages', [MessageController::class, 'viewMessages'])->name('admin.messages');
    Route::get('/admin/messages/chat/{userId}', [DirectMessagesController::class, 'chat'])->name('admin.messages.chat');
    Route::post('/admin/messages/reply', [DirectMessagesController::class, 'reply'])->name('admin.messages.reply');
});

require __DIR__.'/auth.php';
