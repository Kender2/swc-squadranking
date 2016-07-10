<?php

namespace App\Jobs;

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
        if ($this->refresh || !Squad::where('id', $this->guildId)->exists()) {
            $data = $client->guildGetPublic($this->guildId);
            $squad = Squad::firstOrNew(['id' => $this->guildId]);
            $squad->name = $data->name;
            $squad->faction = $data->membershipRestrictions->faction;
            $wins = $losses = $draws = $uplinks_captured = $uplinks_saved = 0;
            foreach ($data->warHistory as $war) {
                // Add previously unseen squad to the queue.
                if ($war->opponentGuildId !== null && !Squad::where('id', $war->opponentGuildId)->exists()) {
                    $this->dispatch(new FetchSquadData($war->opponentGuildId));
                }
                if ($war->score > $war->opponentScore) {
                    $wins++;
                } elseif ($war->score < $war->opponentScore) {
                    $losses++;
                } else {
                    $draws++;
                }
                $uplinks_captured += $war->score;
                $uplinks_saved += 45 - $war->opponentScore;
            }
            $squad->wins = $wins;
            $squad->losses = $losses;
            $squad->draws = $draws;
            $squad->uplinks_captured = $uplinks_captured;
            $squad->uplinks_saved = $uplinks_saved;
            $squad->save();
            sleep(mt_rand(1, 8));
        }
    }
}
