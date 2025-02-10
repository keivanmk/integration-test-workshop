<?php

namespace App\Providers;

use App\Modules\Order\Events\OrderPlaced;
use App\Modules\Order\Listeners\SendOrderPlaceEmail;
use Illuminate\Support\Facades\Event;
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
        Event::listen(
            OrderPlaced::class,
            SendOrderPlaceEmail::class
        );
    }
}
