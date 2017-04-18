<?php

namespace App\Console\Commands;

use App\GameClient;
use App\MemberProcessor;
use App\Squad;
use App\WarProcessor;
use Illuminate\Console\Command;
use Log;

class Refresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sod:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshes all squad data';

    /**
     * Execute the console command.
     *
     * @param GameClient $client
     * @param WarProcessor $warProcessor
     * @param MemberProcessor $memberProcessor
     */
    public function handle(GameClient $client, WarProcessor $warProcessor, MemberProcessor $memberProcessor)
    {
        $squads = Squad::where('deleted', false)->orderBy('updated_at')->get();
        foreach ($squads as $squad) {
            Log::info('Fetching squad ' . $squad->id . ' from console.');
            $this->info('Fetching squad ' . $squad->id);
            $data = $client->guildGetPublic($squad->id);
            if ($data === null) {
                $squad->deleted = true;
                Log::notice('Marking squad ' . $squad->id . ' as deleted');
            } else {
                $squad->name = $data->name;
                $squad->faction = $data->membershipRestrictions->faction;
                $squad->reputation = $data->totalRepInvested;
                $squad->medals = $data->score;
                $warProcessor->processWarHistory($data->warHistory, $squad->id);
                $memberProcessor->processMembers($data->members, $squad);
            }
            $squad->touch();
            // Delay to ease the strain on the server.
            $sleep = config('sod.request_delay');
            $this->comment('Sleeping ' . $sleep . ' seconds.');
            sleep($sleep);
        }
    }
}
