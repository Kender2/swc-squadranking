<?php
namespace App;

use Carbon\Carbon;
use Log;
use Moserware\Skills\GameInfo;
use Moserware\Skills\Rating;
use Moserware\Skills\RatingContainer;
use Moserware\Skills\SkillCalculator;
use Moserware\Skills\Team;

class Ranker implements RankerInterface
{
    protected $calculator;
    const DRAW_PROBABILITY = 1 / 40;

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
        $squad = Squad::firstOrCreate(['id' => $battle->squad_id]);
        $player1 = new \Moserware\Skills\Player($squad->id);
        $rating1 = new Rating($squad->mu, $squad->sigma);
        $team1 = new Team($player1, $rating1);

        $opponent_squad = Squad::firstOrCreate(['id' => $battle->opponent_id]);
        $player2 = new \Moserware\Skills\Player($opponent_squad->id);
        $rating2 = new Rating($opponent_squad->mu, $opponent_squad->sigma);
        $team2 = new Team($player2, $rating2);

        $teams = [$team1, $team2];

        $squad->uplinks_captured += $battle->score;
        $squad->uplinks_saved += 45 - $battle->opponent_score;
        $opponent_squad->uplinks_captured += $battle->opponent_score;
        $opponent_squad->uplinks_saved += 45 - $battle->score;

        if ($battle->score > $battle->opponent_score) {
            $squad->wins++;
            $opponent_squad->losses++;
            $teamOrder = [1, 2];
        } elseif ($battle->score < $battle->opponent_score) {
            $squad->losses++;
            $opponent_squad->wins++;
            $teamOrder = [2, 1];
        } else {
            $squad->draws++;
            $opponent_squad->draws++;
            $teamOrder = [1, 1];
        }

        Log::info('Ranking battle between ' . $squad->id . ' and ' . $opponent_squad->id);

        $gameInfo = new GameInfo(null, null, null, null, self::DRAW_PROBABILITY);
        /** @var RatingContainer $newRatings */
        $newRatings = $this->calculator->calculateNewRatings($gameInfo, $teams, $teamOrder);

        $player1NewRating = $newRatings->getRating($player1);
        $player2NewRating = $newRatings->getRating($player2);

        // Update the squad.
        $squad->mu = $player1NewRating->getMean();
        $squad->sigma = $player1NewRating->getStandardDeviation();
        $squad->save();
        Log::info('Rating for squad ' . $squad->id . ' updated from ' . $rating1->getMean() . ' to ' . $squad->mu);

        // Update the opponent squad.
        $opponent_squad->mu = $player2NewRating->getMean();
        $opponent_squad->sigma = $player2NewRating->getStandardDeviation();
        $opponent_squad->save();
        Log::info('Rating for squad ' . $opponent_squad->id . ' updated from ' . $rating2->getMean() . ' to ' . $opponent_squad->mu);

        // Store the effects the battle had on the ratings.
        $battle->mu_before = $rating1->getMean();
        $battle->mu_after = $squad->mu;
        $battle->sigma_before = $rating1->getStandardDeviation();
        $battle->sigma_after = $squad->sigma;
        $battle->opponent_mu_before = $rating2->getMean();
        $battle->opponent_mu_after = $opponent_squad->mu;
        $battle->opponent_sigma_before = $rating2->getStandardDeviation();
        $battle->opponent_sigma_after = $opponent_squad->sigma;

        $battle->processed_at = Carbon::now();
        $battle->save();

    }

    /**
     * Calculate a ranking score.
     *
     * @param float $mu
     * @param float $sigma
     * @return float
     */
    public static function calculateScore($mu, $sigma)
    {
        return max(round(($mu - (config('sod.sigma_multiplier') * $sigma)) * 100), 0);
    }

}
