<?php

namespace App;

use Carbon\Carbon;
use Log;

class WarProcessor
{

    protected $ranker;

    /**
     * WarProcessor constructor.
     * @param $ranker
     */
    public function __construct(Ranker $ranker)
    {
        $this->ranker = $ranker;
    }

    /**
     * @param array $warHistory
     * @param string $squadId
     */
    public function processWarHistory(array $warHistory, $squadId)
    {
        Log::debug('Processing war history');
        foreach ($warHistory as $war) {
            if ($war->opponentGuildId !== null) {
                $war->squadId = $squadId;
                $this->processWarResult($war);
                if (Squad::firstOrNew(['id' => $war->opponentGuildId])->queueIfNeeded()) {
                    Log::debug('Added opponent squad to queue.');
                }
            }
        }
    }

    /**
     * @param \stdClass $war
     */
    protected function processWarResult($war)
    {
        $battle = Battle::firstOrNew(['id' => $war->warId]);
        if (!$battle->exists) {
            $battle->end_date = Carbon::createFromTimestampUTC($war->endDate);
            $battle->squad_id = $war->squadId;
            $battle->opponent_id = $war->opponentGuildId;
            $battle->score = $war->score;
            $battle->opponent_score = $war->opponentScore;
            Log::debug('Adding new battle');
            $battle->save();
            $this->ranker->rank($battle);
        } else {
            Log::debug('Already seen this battle');
        }
    }
}
