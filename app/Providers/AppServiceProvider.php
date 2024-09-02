<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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

        Gate::define('admin-access', function () {
            return Auth::user()->roles()->pluck('name') === 'Admin';
        });

        Carbon::macro('toFormattedDate', function () {
            return $this->format('d-m-Y');
        });
        Carbon::macro('toFormattedTime', function () {
            return $this->format('h:i A');
        });
    }
}
