<?php

namespace App;

use App\Jobs\FetchSquadData;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;

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
 */
class Squad extends Model
{
    const DEFAULT_INITIAL_MEAN = 25.0;
    const DEFAULT_INITIAL_STANDARD_DEVIATION = self::DEFAULT_INITIAL_MEAN / 3;
    use DispatchesJobs;
    use StatisticsTrait;

    public $incrementing = false;

    public $fillable = ['id'];

    protected $attributes = [
        'mu' => self::DEFAULT_INITIAL_MEAN,
        'sigma' => self::DEFAULT_INITIAL_STANDARD_DEVIATION,
    ];

    public function getRankAttribute()
    {
        if ($this->wins >= config('sod.win_threshold')) {
            $query = 'SELECT 1 + (SELECT count(*) FROM squads a WHERE a.mu-(:multiplier_a * a.sigma) > b.mu-(:multiplier_b * b.sigma) AND a.wins >= :win_threshold_a AND b.wins >= :win_threshold_b ) AS rank FROM squads b WHERE id = :id';
            $bindings = [
                'id' => $this->id,
                'win_threshold_a' => config('sod.win_threshold'),
                'win_threshold_b' => config('sod.win_threshold'),
                'multiplier_a' => config('sod.sigma_multiplier'),
                'multiplier_b' => config('sod.sigma_multiplier'),
            ];
            return DB::selectOne($query, $bindings)->rank;
        }

        $winsToGo = config('sod.win_threshold') - $this->wins;
        $plural = $winsToGo !== 1 ? 's' : '';
        return '<span title="Needs ' . $winsToGo . ' more win' . $plural . ' to rank. Skill ' . $this->skill . '.">Unranked</span>';
    }

    public function getWarsAttribute()
    {
        return $this->wins + $this->losses + $this->draws;
    }

    public function getSkillAttribute()
    {
        return Ranker::calculateScore($this->mu, $this->sigma);
    }

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

    public function renderName()
    {
        return static::colorName($this->name);
    }

    public function renderNamePlain()
    {
        return static::plainName($this->name);
    }

    public static function colorName($name)
    {
        $safe_name = htmlentities(urldecode($name));
        return preg_replace('/\[([0-9A-Fa-f]{6})\]/', '<span style="color: #$1">', $safe_name) . '</span>';
    }

    public static function plainName($name)
    {
        $safe_name = htmlentities(urldecode($name));
        return preg_replace('/\[[0-9A-Fa-f]{6}\]/', '', $safe_name);
    }

    public static function lastUpdate()
    {
        return Squad::orderBy('updated_at', 'desc')
            ->first(['updated_at'])
            ->updated_at
            ->diffForHumans();
    }

    public function lastBattle()
    {
        return Battle::whereSquadId($this->id)
            ->orWhere('opponent_squad_id', '=', $this->id)
            ->orderBy('end_date', 'desc')
            ->first();
    }

    /**
     * Get the members of the squad.
     */
    public function members()
    {
        return $this->hasMany('App\Commander', 'squadId');
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
        self::addTotalsToStats($stats);

        return $stats;
    }

}
