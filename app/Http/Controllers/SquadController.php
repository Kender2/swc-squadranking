<?php

namespace App\Http\Controllers;

use App\GameClient;
use App\Squad;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Log;

class SquadController extends Controller
{

    private $client;

    /**
     * SquadController constructor.
     * @param GameClient $client
     */
    public function __construct(GameClient $client)
    {
        $this->client = $client;
    }


    public function viewSquad(Request $request)
    {
        if ($request->has('squadId')) {
            $squadId = $request->input('squadId');
            $squad = $this->client->guildGetPublic($squadId);
            if ($squad === null) {
                return view('squad_not_found');
            }
            $warRecord = [];
            if (!empty($squad->warHistory)) {
                foreach ($squad->warHistory as $battle) {
                    $row = [];
                    $row['endDate'] = Carbon::createFromTimestampUTC($battle->endDate);
                    $row['result'] = ($battle->score > $battle->opponentScore) ? 'WIN' : (($battle->score < $battle->opponentScore) ? 'LOSS' : 'DRAW');
                    $row['score'] = $battle->score;
                    $row['opponentScore'] = $battle->opponentScore;
                    $row['opponent'] = empty($battle->opponentName) ? '<i>Unknown</i>' : urldecode($battle->opponentName);
                    $row['opponentId'] = $battle->opponentGuildId;
                    $warRecord[$battle->endDate] = $row;
                }
            }
            ksort($warRecord);
            $squadName = urldecode($squad->name);
            $squad = \GuzzleHttp\json_encode($squad, JSON_PRETTY_PRINT);
            return view('squad', compact('squadName', 'squad', 'warRecord'));
        }
        return redirect('/');
    }

    public function squadSearch(Request $request)
    {
        if ($request->has('name')) {
            $results = $this->client->guildSearchByName($request->input('name'));
            foreach ($results as $result) {
                if (Squad::firstOrNew(['id' => $result->_id])->queueIfNeeded()) {
                    Log::info('Added squad ' . $result->_id . ' to queue from search.');
                }
            }
        }
        return view('squadsearch', compact('results'));
    }
}
