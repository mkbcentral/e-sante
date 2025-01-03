<?php

namespace App\Providers;

use App\Enums\RoleType;
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
            return Auth::user()->roles()->pluck('name') === RoleType::ADMIN;
        });

        Gate::define('finance-pharma', function () {
            return Auth::user()->roles()->pluck('name')[0] === RoleType::PHARMA;
        });

        Gate::define('money-box-view', function () {
            return Auth::user()->roles()->pluck('name')->contains(RoleType::MONEY_BOX);
        });

        Gate::define('finance-view', function (): bool {
            return
                Auth::user()->roles()->pluck('name')->contains(RoleType::ADMIN) ||
                Auth::user()->roles()->pluck('name')->contains(RoleType::FINANCE) ||
                Auth::user()->roles()->pluck('name')->contains(RoleType::FINANCE_RECIPES);
        });

        Gate::define('finance-hospitalize', function () {
            return Auth::user()->roles()->pluck('name')[0];
        });

        Gate::define('nurse-actions', function () {
            return Auth::user()->roles()->pluck('name')->contains(RoleType::NURSE) ||
                Auth::user()->roles()->pluck('name')->contains(RoleType::CHIEF_NURSE);
        });
        Gate::define('pharma-actions', function () {
            return Auth::user()->roles()->pluck('name')->contains(RoleType::PHARMA);
        });
        Gate::define('labo-actions', function () {
            return Auth::user()->roles()->pluck('name')->contains(RoleType::LABO);
        });
        Gate::define('radio-actions', function () {
            return Auth::user()->roles()->pluck('name')->contains(RoleType::RADIO);
        });
        Gate::define('reception-actions', function () {
            return Auth::user()->roles()->pluck('name')->contains(RoleType::RECEPTION);
        });





        Carbon::macro('toFormattedDate', function () {
            return $this->format('d-m-Y');
        });
        Carbon::macro('toFormattedTime', function () {
            return $this->format('h:i A');
        });
    }
}
