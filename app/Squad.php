<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Squad
 *
 * @mixin \Eloquent
 */
class Squad extends Model
{
    public $incrementing = false;

    public $fillable = ['id'];

    public function needsFetching()
    {
        if (!$this->exists) {
            return true;
        }
        $twoDaysAgo = Carbon::now()->subDays(2);
        $recentlyFetched = $this->updated_at->gt($twoDaysAgo);

        return !$recentlyFetched;
    }
}
