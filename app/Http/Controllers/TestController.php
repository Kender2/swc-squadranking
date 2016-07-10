<?php

namespace App\Http\Controllers;

use App\ClientRequest;
use App\GameClient;
use App\Jobs\FetchSquadData;
use App\Squad;
use Illuminate\Foundation\Bus\DispatchesJobs;

class TestController extends Controller
{
    use DispatchesJobs;

    public function test()
    {
        $client = new GameClient(new ClientRequest());

        $guild = $client->guildGet()->result;

        $warHistory = $guild->warHistory;

        foreach ($warHistory as $war) {
            if ($war->opponentGuildId !== null) {
                if (!Squad::where('id', $war->opponentGuildId)->exists()) {
                    $this->dispatch(new FetchSquadData($war->opponentGuildId));
                }
            }
        }

        return \GuzzleHttp\json_encode($guild);
    }
}
