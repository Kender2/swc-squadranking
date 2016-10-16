<?php

namespace App;

use App\Jobs\FetchSquadData;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Log;

/**
 * App\Squad
 *
 * @mixin \Eloquent
 * @property string $id
 * @property string $name
 * @property float $mu
 * @property float $sigma
 * @property string $faction
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property boolean $deleted
 * @method static \Illuminate\Database\Query\Builder|\App\Squad whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Squad whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Squad whereMu($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Squad whereSigma($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Squad whereFaction($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Squad whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Squad whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Squad whereDeleted($value)
 * @property integer $wins
 * @property integer $draws
 * @property integer $losses
 * @property integer $uplinks_captured
 * @property integer $uplinks_saved
 * @property integer $reputation
 * @property integer $medals
 * @property-read mixed $rank
 * @property-read mixed $wars
 * @property-read mixed $skill
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Commander[] $members
 * @method static \Illuminate\Database\Query\Builder|\App\Squad whereWins($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Squad whereDraws($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Squad whereLosses($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Squad whereUplinksCaptured($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Squad whereUplinksSaved($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Squad whereReputation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Squad whereMedals($value)
 * @property-read \App\Commander $averageBaseScore
 * @property-read mixed $average_base_score
 */
class Squad extends Model
{
    const DEFAULT_INITIAL_MEAN = 25.0;
    const DEFAULT_INITIAL_STANDARD_DEVIATION = self::DEFAULT_INITIAL_MEAN / 3;
    use DispatchesJobs;
    use StatisticsTrait;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    public $fillable = ['id'];

    /**
     * @var array
     */
    protected $attributes = [
        'mu' => self::DEFAULT_INITIAL_MEAN,
        'sigma' => self::DEFAULT_INITIAL_STANDARD_DEVIATION,
    ];

    /**
     * @return string
     */
    public function getRankAttribute()
    {
        if ($this->wins >= config('sod.win_threshold')) {
            return static::calculateRankFromSkill($this->skill);
        }

        $winsToGo = config('sod.win_threshold') - $this->wins;
        return static::formatUnranked($winsToGo, $this->skill);
    }

    public static function calculateRankFromSkill($skill)
    {
        $query = 'SELECT count(*) AS rank FROM squads WHERE ROUND((mu-(:multiplier * sigma)),3) >= :skill AND wins >= :win_threshold AND deleted = 0';
        $bindings = [
            'win_threshold' => config('sod.win_threshold'),
            'multiplier' => config('sod.sigma_multiplier'),
            'skill' => round($skill / 1000, 3),
        ];
        return DB::selectOne($query, $bindings)->rank;
    }

    /**
     * @return int
     */
    public function getWarsAttribute()
    {
        return $this->wins + $this->losses + $this->draws;
    }

    /**
     * @return float
     */
    public function getSkillAttribute()
    {
        return Ranker::calculateScore($this->mu, $this->sigma);
    }

    /**
     * @return bool
     */
    public function needsFetching()
    {
        if (!$this->exists || $this->name === null) {
            return true;
        }
        if ($this->getAttributeValue('deleted')) {
            return false;
        }
        $twoDaysAgo = Carbon::now()->subDays(2);
        $recentlyFetched = $this->updated_at->gt($twoDaysAgo);

        return !$recentlyFetched;
    }

    /**
     * @return bool
     */
    protected function queue()
    {
        try {
            $this->dispatch(new FetchSquadData($this->id));
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * @return bool True if squad was added to the queue.
     */
    public function queueIfNeeded()
    {
        if ($this->needsFetching()) {
            return $this->queue();
        }
        return false;
    }

    /**
     * @return string
     */
    public function renderName()
    {
        return static::colorName($this->name);
    }

    /**
     * @return string
     */
    public function renderNamePlain()
    {
        return static::plainName($this->name);
    }

    /**
     * @param $name
     * @return string
     */
    public static function colorName($name)
    {
        $safe_name = htmlentities(urldecode($name));
        return preg_replace('/\[([0-9A-Fa-f]{6})\]/', '<span style="color: #$1">', $safe_name) . '</span>';
    }

    /**
     * @param $name
     * @return string
     */
    public static function plainName($name)
    {
        $safe_name = htmlentities(urldecode($name));
        return preg_replace('/\[[0-9A-Fa-f]{6}\]/', '', $safe_name);
    }

    /**
     * @return string
     */
    public static function lastUpdate()
    {
        return Squad::orderBy('updated_at', 'desc')
            ->first(['updated_at'])
            ->updated_at
            ->diffForHumans();
    }

    /**
     * Get the members of the squad.
     */
    public function members()
    {
        return $this->hasMany('App\Commander', 'squadId');
    }

    /**
     * @return mixed
     */
    public function averageBaseScore()
    {
        return $this->hasOne('App\Commander', 'squadId')
            ->selectRaw('squadId, avg(xp) as aggregate')
            ->groupBy('squadId');
    }

    /**
     * @param int $score
     * @param int $opponentScore
     * @param float $mu
     * @param float $sigma
     */
    public function updateFromBattle($score, $opponentScore, $mu, $sigma)
    {
        Log::info('Updating mu for squad ' . $this->id . ' from ' . $this->mu . ' to ' . $mu);
        $this->uplinks_captured += $score;
        $this->uplinks_saved += 45 - $opponentScore;
        $this->mu = $mu;
        $this->sigma = $sigma;
        $this->save();
    }

    /**
     * @return float
     */
    public function getAverageBaseScoreAttribute()
    {
        if (!$this->relationLoaded('averageBaseScore')) {
            $this->load('averageBaseScore');
        }
        $related = $this->getRelation('averageBaseScore');

        return $related ? $related->aggregate : 0;
    }

    /**
     * @param array $factions
     * @return array
     */
    public static function getStats(array $factions = ['empire', 'rebel'])
    {
        $columns = [
            'Amount' => 'count(1)',
            'Avg wins' => 'avg(wins)',
            'Avg draws' => 'avg(draws)',
            'Avg losses' => 'avg(losses)',
            'Avg uplinks taken' => 'avg(uplinks_captured)',
            'Avg uplinks saved' => 'avg(uplinks_saved)',
            'Avg reputation' => 'avg(reputation)',
            'Avg medals' => 'avg(medals)',
        ];
        $stats = self::getStatsForFactions($factions, $columns);
        $stats['All'] = self::getTotalsForStats($stats);

        return $stats;
    }

    /**
     * @param int $winsToGo
     * @param float $skill
     * @return string
     */
    public static function formatUnranked($winsToGo, $skill)
    {
        $plural = $winsToGo !== 1 ? 's' : '';
        return '<span title="Needs ' . $winsToGo . ' more win' . $plural . ' to rank. Skill ' . number_format($skill) . '.">Unranked</span>';
    }

}
