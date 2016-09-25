<?php

namespace App\Console\Commands;

use App\Battle;
use App\RankerInterface;
use Illuminate\Console\Command;

class Rank extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sod:rank';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform ranking';

    /**
     * Execute the console command.
     *
     * @param RankerInterface $ranker
     */
    public function handle(RankerInterface $ranker)
    {
        $battles = Battle::where('processed_at', null)->orderBy('end_date')->get();
        foreach ($battles as $battle) {
            $this->comment('Ranking battle: ' . $battle->id);
            $ranker->rank($battle);
        }
    }

    /*
     * UPDATE `squads` SET mu=DEFAULT,sigma=DEFAULT,wins=0,losses=0,draws=0,uplinks_captured=0,uplinks_saved=0;
     * UPDATE `battles` SET processed_at=NULL,mu_before=NULL,mu_after=NULL,opponent_mu_before=NULL,opponent_mu_after=NULL,sigma_before=NULL,sigma_after=NULL,opponent_sigma_before=NULL,opponent_sigma_after=NULL;
     */

}
