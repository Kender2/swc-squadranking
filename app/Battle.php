<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Battle
 *
 * @mixin \Eloquent
 * @property string $id
 * @property string $squad_id
 * @property boolean $score
 * @property string $opponent_id
 * @property boolean $opponent_score
 * @property string $end_date
 * @property string $processed_at
 * @method static \Illuminate\Database\Query\Builder|\App\Battle whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Battle whereSquadId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Battle whereScore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Battle whereOpponentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Battle whereOpponentScore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Battle whereEndDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Battle whereProcessedAt($value)
 */
class Battle extends Model
{
    public $incrementing = false;

    public $timestamps = false;

    public $fillable = ['id', 'squad_id', 'score', 'opponent_id', 'end_date'];

    public static function result($score, $opponentScore)
    {
        if ($score > $opponentScore) {
            return 'WIN';
        }
        if ($score < $opponentScore) {
            return 'LOSS';
        }
        return 'DRAW';
    }

    /**
     * Get the date of the most recent battle.
     *
     * @return Carbon
     */
    public static function mostRecentBattleDate()
    {
        return new Carbon(Battle::orderBy('end_date', 'desc')->limit(1)->first(['end_date'])->end_date);
    }


    /**
     * Skill delta caused by battle.
     *
     * @return float
     */
    public function getSkillChangeAttribute()
    {
        return $this->getScoreDelta(
            $this->mu_before,
            $this->sigma_before,
            $this->mu_after,
            $this->sigma_after
        );
    }

    /**
     * Skill delta for opponent caused by battle.
     *
     * @return float
     */
    public function getOpponentSkillChangeAttribute()
    {
        return $this->getScoreDelta(
            $this->opponent_mu_before,
            $this->opponent_sigma_before,
            $this->opponent_mu_after,
            $this->opponent_sigma_after
        );
    }

    /**
     * Subtract two sigmas mu pairs.
     *
     * @todo: move to own class, this does not belong with Battle.
     *
     * @param float $first_mu
     * @param float $first_sigma
     * @param float $second_mu
     * @param float $second_sigma
     * @return float
     */
    public function getScoreDelta($first_mu, $first_sigma, $second_mu, $second_sigma)
    {
        $before = Ranker::calculateScore($first_mu, $first_sigma);
        $after = Ranker::calculateScore($second_mu, $second_sigma);
        return $after - $before;
    }

}
