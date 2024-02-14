<?php

namespace App\Providers;

use Aerni\Spotify\Spotify;
use Illuminate\Support\ServiceProvider;

class SpotifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Spotify::class, function ($app) {
            $config = config('spotify');
            return new Spotify($config['client_id'], $config['client_secret']);
        });
    }

    public function boot()
    {
        // ...
    }
}
