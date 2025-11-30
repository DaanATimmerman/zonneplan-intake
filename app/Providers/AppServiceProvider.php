<?php

namespace App\Providers;

use App\Http\Integrations\ZonneplanApi\ZonneplanApi;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ZonneplanApi::class, function () {
            return new ZonneplanApi(
                key: config('services.zonneplan.api_key'),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
