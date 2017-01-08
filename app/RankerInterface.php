<?php
namespace App;

use Moserware\Skills\Rating;

interface RankerInterface
{
    public function rank(Battle $battle);

    /**
     * Calculate a ranking score.
     *
     * @param float $mu
     * @param float $sigma
     * @return float
     */
    public static function calculateScore($mu, $sigma);

    /**
     * @param Squad $squad
     * @param Squad $opponent
     * @param int $outcome
     * @return Rating[]
     */
    public function calculateSkillRatings(Squad $squad, Squad $opponent, $outcome);
}
