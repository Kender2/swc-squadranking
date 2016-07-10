<?php

namespace App\Jobs;

use App\Battle;
use App\GameClient;
use App\Squad;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchSquadData extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, DispatchesJobs;

    private $guildId;
    /**
     * @var bool
     */
    private $refresh;

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
        if ($this->refresh || $squad->name === null) {
            $data = $client->guildGetPublic($this->guildId);
            $squad->name = $data->name;
            $squad->faction = $data->membershipRestrictions->faction;
            $scoring = [
                'wins' => 0,
                'losses' => 0,
                'draws' => 0,
                'uplinks_captured' => 0,
                'uplinks_saved' => 0,
            ];

            foreach ($data->warHistory as $war) {
                if ($war->opponentGuildId !== null) {

                    $battle = Battle::firstOrNew(['id' => $war->warId]);
                    if (!$battle->exists) {
                        $battle->end_date = $war->endDate;
                        if ($squad->faction === 'rebel') {
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
                        $battle->save();
                        // @TODO: send battle to ranking modifying code.
                    }

                    $opponent = Squad::firstOrNew(['id' => $war->opponentGuildId]);

                    if ($opponent->name === null) {
                        // Add previously unseen squad to the queue.
                        $this->dispatch(new FetchSquadData($war->opponentGuildId));
                    }
                }
                if ($war->score > $war->opponentScore) {
                    $scoring['wins']++;
                } elseif ($war->score < $war->opponentScore) {
                    $scoring['losses']++;
                } else {
                    $scoring['draws']++;
                }
                $scoring['uplinks_captured'] += $war->score;
                $scoring['uplinks_saved'] += 45 - $war->opponentScore;
            }
            $squad->fill($scoring);
            $squad->save();
            sleep(mt_rand(1, 8));
        }
    }
}
