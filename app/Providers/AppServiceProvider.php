<?php

namespace App\Providers;

use App\ClientRequest;
use App\GameClient;
use App\Player;
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
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('GameClient', function ($app) {
            return new GameClient(new ClientRequest(), new Player());
        });
    }
}
