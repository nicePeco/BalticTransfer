<?php

namespace App\Providers;

use App\Models\offers;
use App\Policies\OfferPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    protected $policies = [
        offers::class => OfferPolicy::class,
    ];
}
