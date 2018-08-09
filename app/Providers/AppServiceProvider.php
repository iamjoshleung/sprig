<?php

namespace App\Providers;

use App\TumblrSite;
use Illuminate\Support\Facades\URL;
use App\Observers\TumblrSiteObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        TumblrSite::observe(TumblrSiteObserver::class);

        if(config('app.env') === 'production') {
            \URL::formatScheme('https');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if(config('app.env') === 'production') {
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
