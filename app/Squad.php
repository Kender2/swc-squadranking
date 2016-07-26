<?php

namespace App;

use App\Jobs\FetchSquadData;
use Carbon\Carbon;
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
 */
class Squad extends Model
{
    use DispatchesJobs;

    public $incrementing = false;

    public $fillable = ['id'];

    public function needsFetching()
    {
        if (!$this->exists) {
            return true;
        }
        if ($this->deleted) {
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
}
