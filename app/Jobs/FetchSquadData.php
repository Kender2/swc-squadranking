<?php

namespace App\Jobs;

use App\Battle;
use App\GameClient;
use App\Squad;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class FetchSquadData extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, DispatchesJobs;

    private $guildId;
    /**
     * @var bool
     */
    private $refresh = false;

    /**
     * Create a new job instance.
     *
     * @param string $id
     * @param bool $refresh
     */
    public function __construct($id, $refresh = false)
    {
        $this->guildId = $id;
        $this->refresh = $refresh;
    }

    /**
     * Execute the job.
     *
     * @param GameClient $client
     */
    public function handle(GameClient $client)
    {
        $squad = Squad::firstOrNew(['id' => $this->guildId]);
        if ($this->refresh || $squad->needsFetching()) {
            Log::debug('Fetching squad' . ($this->refresh ? ' due to refresh.' : '.'));
            $data = $client->guildGetPublic($this->guildId);
            if ($data === null) {
                $squad->deleted = true;
                Log::debug('Marking squad as deleted');
            } else {
                $squad->name = $data->name;
                $faction = $squad->faction = $data->membershipRestrictions->faction;

                foreach ($data->warHistory as $war) {
                    if ($war->opponentGuildId !== null) {
                        $this->processWarResult($war, $faction);
                        $opponentId = $war->opponentGuildId;
                        $this->queueOpponent($opponentId);
                    }
                }
            }
            $squad->save();
            sleep(mt_rand(1, 3));
        } else {
            Log::debug('No need to fetch squad.');
        }
    }

    /**
     * @param \stdClass $war
     * @param string $faction
     */
    protected function processWarResult($war, $faction)
    {
        $battle = Battle::firstOrNew(['id' => $war->warId]);
        if (!$battle->exists) {
            $battle->end_date = Carbon::createFromTimestampUTC($war->endDate);
            if ($faction === 'rebel') {
                $battle->rebel_id = $this->guildId;
                $battle->empire_id = $war->opponentGuildId;
                $battle->rebel_score = $war->score;
                $battle->empire_score = $war->opponentScore;
            } else {
                $battle->rebel_id = $war->opponentGuildId;
                $battle->empire_id = $this->guildId;
                $battle->rebel_score = $war->opponentScore;
                $battle->empire_score = $war->score;
            }
            Log::debug('Adding new battle');
            $battle->save();
            // @TODO: send battle to ranking modifying code.
        } else {
            Log::debug('Already seen this battle');
        }
    }

    /**
     * @param string $opponentId
     */
    protected function queueOpponent($opponentId)
    {
        $opponent = Squad::firstOrNew(['id' => $opponentId]);
        if ($opponent->needsFetching()) {
            try {
                $this->dispatch(new FetchSquadData($opponentId));
                Log::debug('Added opponent squad to queue.');
            } catch (\Exception $e) {
                // Ignoring duplicate key errors.
            }
        }
    }
}
