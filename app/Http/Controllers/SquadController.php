<?php

namespace App\Http\Controllers;

use App\GameClient;
use App\Jobs\FetchSquadData;
use App\Squad;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Log;

class SquadController extends Controller
{
    use DispatchesJobs;

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
                    $warRecord[] = $row;
                }
            }
            $squadName = urldecode($squad->name);
            $squad = \GuzzleHttp\json_encode($squad, JSON_PRETTY_PRINT);
            return view('squad', compact('squadName', 'squad', 'warRecord'));
        }
    }

    public function squadSearch(Request $request)
    {
        if ($request->has('name')) {
            $results = $this->client->guildSearchByName($request->input('name'));
            foreach ($results as $result) {
                $squad = Squad::firstOrNew(['id' => $result->_id]);
                if ($squad->needsFetching()) {
                    Log::debug('Adding squad to queue from search.');
                    try {
                        $this->dispatch(new FetchSquadData($result->_id));
                    } catch (\Exception $e) {
                    }
                }
            }
        }
        return view('squadsearch', compact('results'));
    }
}
