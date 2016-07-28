<?php

namespace App;

use App\Exceptions\PlayerBannedException;
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
        Log::info('Processing war history: ' . count($warHistory) . ' wars.');
        foreach ($warHistory as $war) {
            if ($war->opponentGuildId !== null) {
                $war->squadId = $squadId;
                $this->processWarResult($war);
                if (Squad::firstOrNew(['id' => $war->opponentGuildId])->queueIfNeeded()) {
                    Log::info('Added opponent squad to queue.');
                }
            }
            else {
                Log::info('Ignoring old war with no opponent id.');
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
            Log::info('Already seen battle ' . $war->warId);
            if ($warEnded->ne($battle->end_date)) {
                Log::notice('Fixing war end date from ' . $battle->end_date . ' to ' . $warEnded);
                $battle->update(['end_date' => $warEnded]);
            }
        }
    }
}
