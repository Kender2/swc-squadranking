<?php
namespace App;

use Carbon\Carbon;
use Log;
use Moserware\Skills\GameInfo;
use Moserware\Skills\Rating;
use Moserware\Skills\RatingContainer;
use Moserware\Skills\SkillCalculator;
use Moserware\Skills\Team;

class Ranker
{
    protected $calculator;

    /**
     * Ranker constructor.
     * @param SkillCalculator $calculator
     */
    public function __construct(SkillCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function rank(Battle $battle)
    {
        $gameInfo = new GameInfo(null, null, null, null, 1/40);

        $squad1 = Squad::firstOrCreate(['id' => $battle->squad_id]);
        $player1 = new \Moserware\Skills\Player($squad1->id);
        $rating1 = new Rating($squad1->mu, $squad1->sigma);
        $team1 = new Team($player1, $rating1);

        $squad2 = Squad::firstOrCreate(['id' => $battle->opponent_id]);
        $player2 = new \Moserware\Skills\Player($squad2->id);
        $rating2 = new Rating($squad2->mu, $squad2->sigma);
        $team2 = new Team($player2, $rating2);

        $teams = [$team1, $team2];
        $teamOrder = [46 - $battle->score, 46 - $battle->opponent_score];

        Log::info('Ranking battle between ' . $squad1->id . ' and ' . $squad2->id);

        /** @var RatingContainer $newRatings */
        $newRatings = $this->calculator->calculateNewRatings($gameInfo, $teams, $teamOrder);

        $player1NewRating = $newRatings->getRating($player1);
        $player2NewRating = $newRatings->getRating($player2);

        $squad1->mu = $player1NewRating->getMean();
        $squad1->sigma = $player1NewRating->getStandardDeviation();
        $squad1->save();
        Log::info('Rating for squad ' . $squad1->id . ' updated from ' . $rating1->getMean() . ' to ' . $squad1->mu);

        $squad2->mu = $player2NewRating->getMean();
        $squad2->sigma = $player2NewRating->getStandardDeviation();
        $squad2->save();
        Log::info('Rating for squad ' . $squad2->id . ' updated from ' . $rating2->getMean() . ' to ' . $squad2->mu);

        $battle->processed_at = Carbon::now();
        $battle->save();

    }
}
