<?php

namespace App\Console\Commands;

use App\Battle;
use App\Ranker;
use Illuminate\Console\Command;
use Moserware\Skills\TrueSkill\TwoPlayerTrueSkillCalculator;

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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ranker = new Ranker(new TwoPlayerTrueSkillCalculator());
        $battles = Battle::where('processed_at', null)->orderBy('end_date')->get();
        foreach ($battles as $battle) {
            $this->comment('Ranking battle: ' . $battle->id);
            $ranker->rank($battle);
        }
    }

    /*
     * UPDATE `squads` SET mu=25,sigma=25/3,wins=0,losses=0,draws=0,uplinks_captured=0,uplinks_saved=0;
     * UPDATE `battles` SET processed_at = NULL;
     */

}
