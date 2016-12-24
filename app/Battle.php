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
 * @property float $mu_before
 * @property float $mu_after
 * @property float $opponent_mu_before
 * @property float $opponent_mu_after
 * @property float $sigma_before
 * @property float $sigma_after
 * @property float $opponent_sigma_before
 * @property float $opponent_sigma_after
 * @property-read mixed $skill_change
 * @property-read mixed $opponent_skill_change
 * @method static \Illuminate\Database\Query\Builder|\App\Battle whereMuBefore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Battle whereMuAfter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Battle whereOpponentMuBefore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Battle whereOpponentMuAfter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Battle whereSigmaBefore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Battle whereSigmaAfter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Battle whereOpponentSigmaBefore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Battle whereOpponentSigmaAfter($value)
 * @property-read mixed $outcome
 */
class Battle extends Model
{
    const MAX_SCORE = 45;

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
     * Determine if this a draw at the maximum score.
     *
     * @return bool
     */
    public function isMaxDraw()
    {
        return ($this->score === self::MAX_SCORE && $this->opponent_score === self::MAX_SCORE);
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
     * The outcome of the battle.
     *
     * Outcome::Win if the first squad won from the second.
     * Outcome::Lose if the first squad lost from the second.
     * Outcome::draw if they tied.
     *
     * @return int
     */
    public function getOutcomeAttribute()
    {
        if ($this->score > $this->opponent_score) {
            return Outcome::Win;
        } elseif ($this->score < $this->opponent_score) {
            return Outcome::Lose;
        } else {
            return Outcome::Draw;
        }
    }

    /**
     * @param $squad
     * @param $newRating
     * @param $opponent
     * @param $opponentNewRating
     */
    public function updateStats($squad, $newRating, $opponent, $opponentNewRating)
    {
        $this->mu_before = $squad->mu;
        $this->mu_after = $newRating->getMean();
        $this->sigma_before = $squad->sigma;
        $this->sigma_after = $newRating->getStandardDeviation();
        $this->opponent_mu_before = $opponent->mu;
        $this->opponent_mu_after = $opponentNewRating->getMean();
        $this->opponent_sigma_before = $opponent->sigma;
        $this->opponent_sigma_after = $opponentNewRating->getStandardDeviation();

        $this->processed_at = Carbon::now();
        $this->save();
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
