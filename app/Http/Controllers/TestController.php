<?php

namespace App\Http\Controllers;

use App\Exceptions\CommandException;
use App\GameClient;
use Illuminate\Foundation\Bus\DispatchesJobs;

class TestController extends Controller
{

    use DispatchesJobs;


    public function test(GameClient $client)
    {

        try {
            $target = $client->visitNeighbor('5342e24f-5672-11e4-804d-06b528004f3a')->player;
        } catch (CommandException $e) {
            return json_encode($e->getRequest());
            return $e->getCommandResponse();
        }

        $replays = [];
        $battles = [];
//        $farid = $client->visitNeighbor('8f4a2baf-2a6a-11e4-b845-06ffee004f7b')->player;
//        $target = $client->visitNeighbor('5342e24f-5672-11e4-804d-06b528004f3a')->player;

//        $battleLogs = $farid->playerModel->battleLogs;
//        foreach ($battleLogs as $battleLog) {
//            if ($battleLog->attacker->playerId === $farid->playerId) {
//                $battles[date('Y-m-d H:i:s', $battleLog->attackDate)] = [
//                    'name' => $battleLog->defender->name,
//                    'squad' => $battleLog->defender->guildName,
//                    'damage' => $battleLog->baseDamagePercent,
//                ];
//                $battleReplay = $client->getBattleReplay($battleLog->battleId, $farid->playerId);
//                if (isset($battleReplay->replayData)) {
//                    $battles[date('Y-m-d H:i:s', $battleLog->attackDate)]['replay'] = $battleReplay->replayData;
//                }
//            }
//        }

        return response()->json($target);
    }
}
