<?php
namespace App;

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
}
