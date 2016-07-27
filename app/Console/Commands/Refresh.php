<?php

namespace App\Console\Commands;

use App\GameClient;
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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param GameClient $client
     * @param WarProcessor $warProcessor
     * @return mixed
     */
    public function handle(GameClient $client, WarProcessor $warProcessor)
    {
        $squads = Squad::where('deleted', false)->orderBy('updated_at')->get();
        foreach ($squads as $squad) {
            Log::info('Fetching squad ' . $squad->id . ' from console.');
            $this->info('Fetching squad ' . $squad->id);
            $data = $client->guildGetPublic($squad->id);
            if ($data === null) {
                $squad->deleted = true;
                Log::info('Marking squad ' . $squad->id . ' as deleted');
            } else {
                $squad->name = $data->name;
                $squad->faction = $data->membershipRestrictions->faction;
                $warProcessor->processWarHistory($data->warHistory, $squad->id);
            }
            $squad->save();
            $seconds = mt_rand(2, 8);
            $this->comment('Sleeping ' . $seconds . ' seconds.');
            sleep($seconds);
        }
    }
}
