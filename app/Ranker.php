<?php
namespace App;

use Log;
use Moserware\Skills\GameInfo;
use Moserware\Skills\Player as GamePlayer;
use Moserware\Skills\Rating;
use Moserware\Skills\RatingContainer;
use Moserware\Skills\SkillCalculator;
use Moserware\Skills\Team;

class Ranker implements RankerInterface
{
    protected $calculator;
    const DRAW_PROBABILITY = 1 / 40;
    protected static $teamOrders = [
        Outcome::Win => [1, 2],
        Outcome::Draw => [1, 1],
        Outcome::Lose => [2, 1],
    ];

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
        /** @var Squad $squad */
        $squad = Squad::firstOrCreate(['id' => $battle->squad_id]);
        /** @var Squad $opponent */
        $opponent = Squad::firstOrCreate(['id' => $battle->opponent_id]);

        Log::info('Ranking battle between ' . $squad->id . ' and ' . $opponent->id);

        // In case of a 45-45 tie we don't calculate new ratings but use the
        // old ones since that tells us nothing.
        if ($battle->isMaxDraw()) {
            $newRating = new Rating($squad->mu, $squad->sigma);
            $opponentNewRating = new Rating($opponent->mu, $opponent->sigma);
        } else {
            list($newRating, $opponentNewRating) = $this->calculateSkillRatings($squad, $opponent, $battle->outcome);
        }

        // Store the effects the battle had on the ratings.
        $battle->updateStats($squad, $newRating, $opponent, $opponentNewRating);

        // Update the squads.
        $squad->updateFromBattle($battle->score, $battle->opponent_score, $newRating);
        $opponent->updateFromBattle($battle->opponent_score, $battle->score, $opponentNewRating);
    }

    /**
     * Calculate the new skill ratings for a clash between two squads.
     *
     * @param Squad $squad
     * @param Squad $opponent
     * @param int $outcome
     * @return array
     */
    public function calculateSkillRatings(Squad $squad, Squad $opponent, $outcome)
    {
        $player1 = new GamePlayer($squad->id);
        $rating1 = new Rating($squad->mu, $squad->sigma);

        $player2 = new GamePlayer($opponent->id);
        $rating2 = new Rating($opponent->mu, $opponent->sigma);

        $teams = [new Team($player1, $rating1), new Team($player2, $rating2)];

        $gameInfo = new GameInfo(null, null, null, null, self::DRAW_PROBABILITY);
        /** @var RatingContainer $newRatings */
        $newRatings = $this->calculator->calculateNewRatings($gameInfo, $teams, self::$teamOrders[$outcome]);

        $newRating = $newRatings->getRating($player1);
        $opponentNewRating = $newRatings->getRating($player2);

        return [$newRating, $opponentNewRating];
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
        return max(round(($mu - (config('sod.sigma_multiplier') * $sigma)) * 1000), 0);
    }




}
