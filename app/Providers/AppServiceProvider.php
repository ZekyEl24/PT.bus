<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Profil;

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
        View::composer(['layout.admin', 'login'], function ($view) {
            $profil = Profil::find(1);

            if ($profil && $profil->logo) {
                // pastikan path bersih
                $profil->logo = 'storage/' . ltrim($profil->logo, '/');
            }

            $view->with('profilPerusahaan', $profil);
        });
    }
}