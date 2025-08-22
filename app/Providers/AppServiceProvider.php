<?php

namespace App\Providers;
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
        Gate::define('isAdmin', function($user) {
            return $user->role == 'admin';
        });

        Gate::define('isSuperAdmin', function($user) {
            return $user->role == 'super_admin';
        });

        Gate::define('isEmployee', function($user) {
            return $user->role == 'employee';
        });

        Gate::define('isEmployer', function($user) {
            return $user->role == 'employer';
        });

        Gate::define('isGuest', function($user) {
            return $user->role == null;
        });
    }
}
