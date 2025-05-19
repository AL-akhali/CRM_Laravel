<?php

namespace App\Providers;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
        Filament::registerNavigationGroups([
            'الإدارة',
        ]);
        Gate::define('view-private-notes', function ($user) {
            return $user->hasRole('crm_agent'); // عدّل حسب دورك
        });
    });

    // Filament::authorize(fn (User $user) => true); // اسمح لكل المستخدمين بالوصول
    }
}
