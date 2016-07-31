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
 */
class Squad extends Model
{
    const DEFAULT_INITIAL_MEAN = 25.0;
    const DEFAULT_INITIAL_STANDARD_DEVIATION = self::DEFAULT_INITIAL_MEAN / 3;
    use DispatchesJobs;

    public $incrementing = false;

    public $fillable = ['id'];

    protected $attributes = [
        'mu' => self::DEFAULT_INITIAL_MEAN,
        'sigma' => self::DEFAULT_INITIAL_STANDARD_DEVIATION,
    ];


    public function getRankAttribute()
    {
        if ($this->wins >= 10) {
            $query = 'SELECT 1 + (SELECT count(*) FROM squads a WHERE a.mu > b.mu AND a.wins >= 10 AND b.wins >= 10 ) AS rank FROM squads b WHERE id = :id';
            $bindings = ['id' => $this->id];
            return DB::selectOne($query, $bindings)->rank;
        }

        $winsToGo = 10 - $this->wins;
        $plural = $winsToGo !== 1 ? 's' : '';
        return '<span title="Needs ' . $winsToGo . ' more win' . $plural . ' to rank. Skill ' . $this->skill . '.">Unranked</span>';
    }

    public function getWarsAttribute()
    {
        return $this->wins + $this->losses + $this->draws;
    }

    public function getSkillAttribute()
    {
        return round(($this->mu - (3 * $this->sigma)) * 1000);
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

}
