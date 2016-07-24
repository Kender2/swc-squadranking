<?php

namespace App\Http\Controllers;

use App\GameClient;
use App\Jobs\FetchSquadData;
use Illuminate\Foundation\Bus\DispatchesJobs;

class TestController extends Controller
{
    use DispatchesJobs;

    public function test(GameClient $client)
    {
        $guild = $client->guildGet()->result;

        $warHistory = $guild->warHistory;

        foreach ($warHistory as $war) {
            if ($war->opponentGuildId !== null) {
//                if (!Squad::where('id', $war->opponentGuildId)->exists()) {
                try {
                    $this->dispatch(new FetchSquadData($war->opponentGuildId, true));
                } catch (\Exception $e) {
                }
//                }
            }
        }

        return \GuzzleHttp\json_encode($guild);
    }
}
