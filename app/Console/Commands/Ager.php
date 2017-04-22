<?php

namespace App\Console\Commands;

use App\Squad;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;

class Ager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sod:age-squads {--historical}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Applies sigma adjustment due to aging';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $squads = Squad::whereDeleted(false)->get();
        $now = Carbon::now();
        $bar = $this->output->createProgressBar(count($squads));
        foreach ($squads as $squad) {
            $lastBattleDate = Carbon::parse($squad->lastBattleDate());
            $days = $now->diffInDays($lastBattleDate);
            $adjustment = 0.005 * $days;
            Log::info('Squad ' . $squad->id . ' last war was ' . $lastBattleDate . ', which is ' . $days . ' days ago. Adjusting sigma ' . $squad->sigma . ' with ' . $adjustment);
            $squad->increment('sigma', $adjustment);
            $bar->advance();
        }
        $bar->finish();
    }

}
