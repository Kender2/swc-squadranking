<?php

namespace App;

use Carbon\Carbon;
use Log;

class WarProcessor
{

    protected $ranker;

    /**
     * WarProcessor constructor.
     * @param RankerInterface $ranker
     */
    public function __construct(RankerInterface $ranker)
    {
        $this->ranker = $ranker;
    }

    /**
     * @param array $warHistory
     * @param string $squadId
     */
    public function processWarHistory(array $warHistory, $squadId)
    {
        Log::info('Processing war history: ' . count($warHistory) . ' wars.');
        foreach ($warHistory as $war) {
            if ($war->opponentGuildId !== null) {
                $war->squadId = $squadId;
                $this->processWarResult($war);
                if (Squad::firstOrNew(['id' => $war->opponentGuildId])->queueIfNeeded()) {
                    Log::info('Added opponent squad to queue.');
                }
            } else {
                Log::debug('Ignoring old war with no opponent id.');
            }
        }
    }

    /**
     * @param \stdClass $war
     */
    protected function processWarResult($war)
    {
        $battle = Battle::firstOrNew(['id' => $war->warId]);
        $warEnded = Carbon::createFromTimestampUTC($war->endDate);
        if (!$battle->exists) {
            $battle->end_date = $warEnded;
            $battle->squad_id = $war->squadId;
            $battle->opponent_id = $war->opponentGuildId;
            $battle->score = $war->score;
            $battle->opponent_score = $war->opponentScore;
            Log::info('Adding new battle');
            $battle->save();
            $this->ranker->rank($battle);
        } else {
            Log::debug('Already seen battle ' . $war->warId);
        }
    }
}
