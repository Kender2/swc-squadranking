<?php

namespace App\Jobs;

use App\Battle;
use App\GameClient;
use App\Squad;
use App\WarProcessor;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class FetchSquadData extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

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
     * @param WarProcessor $warProcessor
     */
    public function handle(GameClient $client, WarProcessor $warProcessor)
    {
        $squad = Squad::firstOrNew(['id' => $this->guildId]);
        if ($this->refresh || $squad->needsFetching()) {
            Log::info('Fetching squad' . ($this->refresh ? ' due to refresh.' : '.'));
            $data = $client->guildGetPublic($this->guildId);
            if ($data === null) {
                $squad->deleted = true;
                Log::info('Marking squad as deleted');
            } else {
                $squad->name = $data->name;
                $squad->faction = $data->membershipRestrictions->faction;
                $warProcessor->processWarHistory($data->warHistory, $squad->id);
            }
            $squad->save();
            sleep(mt_rand(2, 8));
        } else {
            Log::info('No need to fetch squad ' . $this->guildId);
        }
    }

}
