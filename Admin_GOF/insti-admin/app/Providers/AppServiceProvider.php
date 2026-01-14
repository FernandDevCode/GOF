<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;

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
        Schema::defaultStringLength(191);

        Gate::define('upload-brochure', function ($user) {
            if ($user->isAdmin()) {
                return true;
            }

            $allowedRoles = [
                'Directeur',
                'Directrice adjointe',
                'Chef de département',
                'Chef du service informatique'
            ];
            
            return $user->role && in_array($user->role->name, $allowedRoles);
        });

        // Global Gate handler: if the user has the requested ability via
        // the User::hasPermission method (or is Super Admin), allow access.
        Gate::before(function ($user, $ability) {
            if (!$user) {
                return null;
            }

            // Super Admin shortcut
            if (isset($user->role) && $user->role && $user->role->name === 'Super Admin') {
                return true;
            }

            // Use the user model's hasPermission if available
            if (method_exists($user, 'hasPermission') && $user->hasPermission($ability)) {
                return true;
            }

            return null;
        });
    }
}
