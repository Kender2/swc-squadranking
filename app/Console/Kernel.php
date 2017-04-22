<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Rank::class,
        Commands\Refresh::class,
        Commands\GrabData::class,
        Commands\Ager::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Disabled until transition to new format is done.
//        $schedule->command('sod:grab-data')->hourly();
        $schedule->call('\App\Squad::applyAging', [config('sod.sigma_aging')])->daily();

    }
}
