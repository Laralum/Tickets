<?php

namespace Laralum\Tickets;

use Illuminate\Support\ServiceProvider;

class TicketsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadTranslationsFrom(__DIR__.'/Translations', 'laralum_tickets');

        if (!$this->app->routesAreCached()) {
            require __DIR__.'/Routes/web.php';
        }

        $this->publishes([
            __DIR__.'/Views/Public' => resource_path('views/vendor/Laralum/Profile'),
        ], 'laralum');

        $this->loadViewsFrom(__DIR__.'/Views/Laralum', 'laralum_tickets'); //Loading private views
        $this->loadViewsFrom(resource_path('views/vendor/Laralum/Tickets'), 'laralum_tickets_public'); //Loading public views

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
