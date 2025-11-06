<?php

namespace App\Providers;

use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use Filament\Forms\Components\Builder;
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
        $supported_locales = config('laravellocalization.supportedLocales');
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) use ($supported_locales) {
            $switch
                ->locales(array_keys($supported_locales));
        });
    }
}
