<?php

namespace App\Providers;

use App\Http\Requests\Api\V1\Login\LoginRequest;
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
        Gate::before(function ($user) {
            return $user->hasRole('super admin') ? true : null;
        });
        $this->app->bind('Laravel\Fortify\Http\Requests\LoginRequest', LoginRequest::class);
        //
    }
}
