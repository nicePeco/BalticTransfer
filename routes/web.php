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
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureDriver;
use App\Models\Notification;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home.main');
});

Route::get('/home', [HomePageController::class, 'index'])->name('home.index');
Route::view('/contact', 'layouts.contact')->name('contact');
Route::view('/privacy', 'layouts.privacy')->name('privacy');
Route::view('/terms', 'layouts.terms')->name('terms');

Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

Route::middleware('guest')->group(function () {
    Route::get('/register/driver', [RegisteredUserController::class, 'createDriver'])->name('register.driver.form');
    Route::post('/register/driver', [RegisteredUserController::class, 'storeDriver'])->name('register.driver');
});

Route::view('/403', 'errors.403')->name('403');
Route::view('/404', 'errors.404')->name('404');

Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->roles->contains('name', 'driver')) {
        return redirect('/driver-dashboard');
    }
    return view('home.home');
})->middleware([\App\Http\Middleware\CheckSuspension::class])->name('dashboard');


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
    Route::get('/client/profile/search', [ClientController::class, 'search'])->name('client.profile.search');
    // Route::get('/offers', [OffersController::class, 'index'])->name('offers.index');
    Route::post('/offers', [OffersController::class, 'store'])->name('offers.store');
    Route::get('/offers', [OffersController::class, 'test'])->name('offers.test');
    Route::get('/offers/{hashid}', [OffersController::class, 'show'])->name('offers.show');
    Route::post('/offers/{offers}/edit', [OffersController::class, 'edit'])->name('offers.edit');
    Route::patch('/offers/{offers}', [OffersController::class, 'update'])->name('offers.update');
    Route::post('/rides', [RideController::class, 'store'])->name('rides.store');
    Route::delete('/rides/{ride}', [RideController::class, 'destroy'])->name('rides.destroy');
    Route::get('/rides/my-applications', [RideController::class, 'myApplications'])->name('driver.applications');
    Route::post('/offers/accept/{ride}', [OffersController::class, 'acceptRide'])->name('offers.accept');
    Route::delete('/offers/{offer}/cancel', [OffersController::class, 'cancel'])->name('offers.cancel');
    Route::get('/offers/{hashid}/accept', [OffersController::class, 'showAcceptedRide'])->name('offers.accept.show');
    Route::delete('/offers/{offers}', [OffersController::class, 'destroy'])->name('offers.destroy');
    Route::post('/offers/accept/{ride}', [OffersController::class, 'acceptRide'])->name('offers.accept');
    Route::delete('/offers/{offer}/cancel', [OffersController::class, 'cancel'])->name('offers.cancel');
    Route::get('/offers/{hashid}/accept', [OffersController::class, 'showAcceptedRide'])->name('offers.accept.show');
    Route::get('/messages/{offerId?}', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/delete', [NotificationController::class, 'deleteNotification'])->name('notifications.delete');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::get('/start-ride/{offerId}', [OffersController::class, 'startRide'])->name('start.ride');
    Route::get('/offers/{hashid}/ongoing', [OffersController::class, 'ongoing'])->name('offers.ongoing');
    Route::get('/offers/{hashid}/rate', [OffersController::class, 'rateDriverForm'])->name('offers.rate');
    Route::patch('/offers/{offerId}/finish', [OffersController::class, 'finishRide'])->name('offers.finish');
    Route::get('/driver/weekly-summary', [DriversController::class, 'weeklySummary'])->name('driver.payment');
    Route::post('/offers/{offer}/rate', [OffersController::class, 'submitDriverRating'])->name('offers.rate.submit');
    Route::get('/offers/{hashid}/rate-user', [OffersController::class, 'rateUserForm'])->name('offers.rateUser');
    Route::post('/offers/{offer_id}/rate-user', [OffersController::class, 'submitUserRating'])->name('offers.rateUser.submit');
});

Route::middleware([\App\Http\Middleware\CheckDriverVerification::class])->group(function () {
    Route::get('/driver-dashboard', function () {
        return app(DriversController::class)->index();
    })->name('driver.dashboard');
    Route::get('/client', [ClientController::class, 'index'])->name('client.index');
});

Route::get('/driver/waiting', [DriversController::class, 'waitingPage'])->name('driver.waiting');

Route::middleware(['auth', EnsureDriver::class])->group(function () {
    Route::get('/driver/edit', [ProfileController::class, 'editDriver'])->name('driver.edit');
    Route::patch('/driver/update', [ProfileController::class, 'updateDriver'])->name('driver.update');
    Route::patch('/driver/photos', [ProfileController::class, 'updateCarPhotos'])->name('driver.updatePhotos');
    Route::get('/driver/verify', [DriversController::class, 'showVerificationForm'])->name('driver.verify');
    Route::post('/driver/verify', [DriversController::class, 'submitVerification'])->name('driver.verify.submit');
    Route::patch('/driver/main-photo', [ProfileController::class, 'updateMainCarPhoto'])->name('driver.updateMainPhoto');
    Route::delete('/driver/photo/{id}', [ProfileController::class, 'deleteCarPhoto'])->name('driver.deletePhoto');
});

//admin

Route::middleware(['auth', EnsureAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'viewUsers'])->name('admin.users');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::post('/admin/users/{id}/update', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::get('/admin/drivers', [AdminController::class, 'viewDrivers'])->name('admin.drivers');
    Route::get('/admin/drivers/{id}/edit', [AdminController::class, 'editDriver'])->name('admin.drivers.edit');
    Route::get('/admin/rides', [AdminController::class, 'viewRides'])->name('admin.rides');
    Route::get('/admin/rides/{id}/edit', [AdminController::class, 'editRide'])->name('admin.rides.edit');
    Route::post('/admin/rides/{id}/update', [AdminController::class, 'updateRide'])->name('admin.rides.update');
    Route::get('/admin/messages', [MessageController::class, 'viewMessages'])->name('admin.messages');
    Route::get('/admin/messages/mark-as-read/{userId}', [MessageController::class, 'markMessagesAsRead'])->name('admin.messages.markAsRead');
    Route::get('/admin/messages/chat/{userId}', [DirectMessagesController::class, 'chat'])->name('admin.messages.chat');
    Route::post('/admin/messages/reply', [DirectMessagesController::class, 'reply'])->name('admin.messages.reply');
    Route::post('/admin/users/suspend/{id}', [AdminController::class, 'suspendUser'])->name('admin.users.suspend');
    Route::post('/admin/users/unsuspend/{id}', [AdminController::class, 'unsuspendUser'])->name('admin.users.unsuspend');
    Route::post('/admin/messages/mark-read/{id}', [DirectMessagesController::class, 'markRead'])->name('admin.messages.mark-read');
    Route::post('/admin/messages/mark-unread/{id}', [DirectMessagesController::class, 'markUnread'])->name('admin.messages.mark-unread');
    Route::post('/admin/drivers/{id}/has-paid', [AdminController::class, 'hasPaid'])->name('admin.drivers.hasPaid');
    Route::post('/admin/drivers/{id}/has-not-paid', [AdminController::class, 'hasNotPaid'])->name('admin.drivers.hasNotPaid');
    Route::post('/admin/drivers/{id}/unsuspend', [AdminController::class, 'unsuspendDriver'])->name('admin.drivers.unsuspend');
    Route::get('/admin/driver/verifications', [AdminController::class, 'viewDriverVerifications'])->name('admin.driver-verifications');
    Route::patch('/admin/driver/verifications/{id}', [AdminController::class, 'updateDriverVerification'])->name('admin.driver-verification.update');
    Route::get('/admin/driver/download/{type}/{id}', [AdminController::class, 'downloadLicense'])->name('admin.download-license');
    Route::get('/admin/download-car-photo/{id}', [AdminController::class, 'downloadCarPhoto'])->name('admin.download-car-photo');
});

require __DIR__.'/auth.php';
