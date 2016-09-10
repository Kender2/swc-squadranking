<?php

namespace App\Providers;

use App\ClientRequest;
use App\GameClient;
use App\Player;
use App\Ranker;
use GitWrapper\GitWrapper;
use Illuminate\Support\ServiceProvider;
use Moserware\Skills\TrueSkill\TwoPlayerTrueSkillCalculator;

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
        // The game client to communicate with the game backend.
        $this->app->singleton('GameClient', function ($app) {
            return new GameClient(new ClientRequest(), new Player());
        });

        // The skill calculator for the ranking.
        $this->app->bind('Moserware\Skills\SkillCalculator', TwoPlayerTrueSkillCalculator::class);
        $this->app->bind('App\RankerInterface', Ranker::class);

        // The git working copy for the game data.
        $this->app->bind('GitWrapper\GitWorkingCopy', function ($app) {
            $wrapper = new GitWrapper();
            $wrapper->git('config --global user.name "Squadranking bot"');
            $wrapper->git('config --global user.email bot@squadsofdeath.com');
            return $wrapper->workingCopy(storage_path('app/data'));
        });
    }
}
