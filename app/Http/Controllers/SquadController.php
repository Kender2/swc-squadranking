<?php

namespace App\Http\Controllers;

use App\Battle;
use App\GameClient;
use App\Outcome;
use App\Ranker;
use App\RankerInterface;
use App\Squad;
use Carbon\Carbon;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
                    if ($battle->score > $battle->opponentScore) {
                        $row['result'] = 'WIN';
                    } elseif ($battle->score < $battle->opponentScore) {
                        $row['result'] = 'LOSS';
                    } else {
                        $row['result'] = 'DRAW';
                    }
                    $row['score'] = $battle->score;
                    $row['opponentScore'] = $battle->opponentScore;
                    if (!$battle->opponentName) {
                        $row['opponent'] = '<i>Unknown</i>';
                    } else {
                        $row['opponent'] = urldecode($battle->opponentName);
                    }
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

    public function ssquadSearch(Request $request)
    {
        if ($request->has('name') && Str::length($request->input('name')) >= 3) {
            $results = $this->client->guildSearchByName($request->input('name'));
            foreach ($results as $result) {
                if (Squad::firstOrNew(['id' => $result->_id])->queueIfNeeded()) {
                    Log::info('Added squad ' . $result->_id . ' to queue from search.');
                }
            }
        }
        return view('ssquadsearch', compact('results'));
    }

    public function squadSearch(Request $request)
    {
        if ($request->has('q')) {
            $searchTerm = $request->input('q');
            $results = Squad::whereDeleted(false)
                ->where('name', 'LIKE', '%' . $searchTerm . '%')
                ->orderByRaw('mu - (' . config('sod.sigma_multiplier') . '*sigma) desc')
                ->simplePaginate(20);
            if (count($results) === 1) {
                return redirect()->route('squadhistory', [$results->first()]);
            }
        }
        return view('squadsearch', compact('results'));
    }

    public function squadHistory($id)
    {
        $squad = Squad::findOrFail($id);

        $offensiveBattles = Battle::whereSquadId($squad->id)->get();
        $defensiveBattles = Battle::whereOpponentId($squad->id)->get();

        $battles = [];
        foreach ($offensiveBattles as $offensiveBattle) {
            $skill_before = Ranker::calculateScore($offensiveBattle->mu_before, $offensiveBattle->sigma_before);
            $opponent_skill_before = Ranker::calculateScore($offensiveBattle->opponent_mu_before, $offensiveBattle->opponent_sigma_before);
            $battles[$offensiveBattle->end_date] = [
                'score' => $offensiveBattle->score,
                'opponent_score' => $offensiveBattle->opponent_score,
                'opponent' => Squad::findOrNew($offensiveBattle->opponent_id),
                'skill_difference' => max(1, $opponent_skill_before) / max(1, $skill_before),
                'skill_change' => $offensiveBattle->skillChange,
            ];
        }
        foreach ($defensiveBattles as $defensiveBattle) {
            $skill_before = Ranker::calculateScore($defensiveBattle->opponent_mu_before, $defensiveBattle->opponent_sigma_before);
            $opponent_skill_before = Ranker::calculateScore($defensiveBattle->mu_before, $defensiveBattle->sigma_before);
            $battles[$defensiveBattle->end_date] = [
                'score' => $defensiveBattle->opponent_score,
                'opponent_score' => $defensiveBattle->score,
                'opponent' => Squad::findOrNew($defensiveBattle->squad_id),
                'skill_difference' => max(1, $opponent_skill_before) / max(1, $skill_before),
                'skill_change' => $defensiveBattle->opponentSkillChange,
            ];
        }

        krsort($battles);

        return view('squad_history', compact(['battles', 'squad']));
    }

    public function squadMembers($id)
    {
        $squad = Squad::findOrFail($id);

        $members = $squad->members()->orderBy('xp', 'desc')->get();

        return view('squad_members', compact(['members', 'squad']));
    }

    public function squadPredict(Request $request, $id, $opponentId = null)
    {
        /** @var Squad $squad */
        $squad = Squad::findOrFail($id);

        // Get the opponent from the url if present.
        if ($opponentId) {
            $opponent = Squad::find($opponentId);
        } // Get the opponent from the search of present.
        elseif ($request->has('match')) {
            $searchTerm = $request->input('match');
            $results = Squad::whereDeleted(false)
                ->where('name', 'LIKE', '%' . $searchTerm . '%')
                ->orderByRaw('mu - (' . config('sod.sigma_multiplier') . '*sigma) desc')
                ->simplePaginate(20);
            if (count($results) === 1) {
                $opponent = $results->first();
                unset($results);
            }
        } elseif ($request->hasCookie('squad_id')) {
            $opponent = Squad::find($request->cookie('squad_id'));
        }

        // Add the match prediction.
        if (isset($opponent)) {
            Cookie::queue('squad_id', $opponent->id);

            if ($squad->skill > $opponent->skill) {
                $predictions = $this->winPrediction($squad, $opponent);
            } elseif ($squad->skill < $opponent->skill) {
                $predictions = $this->losePrediction($opponent, $squad);
            } else {
                $predictions = $this->drawPrediction($squad, $opponent);
            }
        }

        return view('squad_predict', compact(['squad', 'opponent', 'results', 'predictions']));
    }

    /**
     * @param Squad $squad
     * @param Squad $opponent
     * @param int $outcome
     * @return array
     */
    protected function createOutcomeTableData(Squad $squad, Squad $opponent, $outcome)
    {
        /** @var RankerInterface $ranker */
        $ranker = app()->make('App\RankerInterface');
        list($squadRating, $opponentRating) = $ranker->calculateSkillRatings($squad, $opponent, $outcome);
        $newSkill = $ranker::calculateScore($squadRating->getMean(), $squadRating->getStandardDeviation());
        $opponentNewSkill = $ranker::calculateScore($opponentRating->getMean(), $opponentRating->getStandardDeviation());
        $data = [
            [
                'squad' => $squad->renderName(),
                'old_skill' => $squad->skill,
                'new_skill' => $newSkill,
                'change' => $newSkill - $squad->skill,
            ],
            [
                'squad' => $opponent->renderName(),
                'old_skill' => $opponent->skill,
                'new_skill' => $opponentNewSkill,
                'change' => $opponentNewSkill - $opponent->skill,
            ],
        ];
        return $data;
    }

    /**
     * @param Squad $squad
     * @param Squad $opponent
     * @return array
     */
    protected function winPrediction(Squad $squad, Squad $opponent)
    {
        return [
            [
                'text' => 'I predict that ' . $squad->renderName() . ' will beat ' . $opponent->renderName() . ' with this result:',
                'data' => $this->createOutcomeTableData($squad, $opponent, Outcome::Win),
            ],
            [
                'text' => 'But if ' . $opponent->renderName() . ' beats ' . $squad->renderName() . ' the result will be:',
                'data' => $this->createOutcomeTableData($squad, $opponent, Outcome::Lose),
            ],
            [
                'text' => 'And in case of a tie the results will be:',
                'data' => $this->createOutcomeTableData($squad, $opponent, Outcome::Draw),
            ],
        ];
    }

    /**
     * @param Squad $squad
     * @param Squad $opponent
     * @return array
     */
    protected function losePrediction(Squad $opponent, Squad $squad)
    {
        return [
            [
                'text' => 'I predict that ' . $opponent->renderName() . ' will beat ' . $squad->renderName() . ' with this result:',
                'data' => $this->createOutcomeTableData($squad, $opponent, Outcome::Lose),
            ],
            [
                'text' => 'But if ' . $squad->renderName() . ' beats ' . $opponent->renderName() . ' the result will be:',
                'data' => $this->createOutcomeTableData($squad, $opponent, Outcome::Lose),
            ],
            [
                'text' => 'And in case of a tie the results will be:',
                'data' => $this->createOutcomeTableData($squad, $opponent, Outcome::Draw),
            ],
        ];
    }

    /**
     * @param Squad $squad
     * @param Squad $opponent
     * @return array
     */
    protected function drawPrediction(Squad $squad, Squad $opponent)
    {
        return [
            [
                'text' => 'I predict a tie between ' . $squad->renderName() . ' and ' . $opponent->renderName(),
                'data' => $this->createOutcomeTableData($squad, $opponent, Outcome::Lose),
            ],
            [
                'text' => 'But if ' . $squad->renderName() . ' beats ' . $opponent->renderName() . ' the result will be:',
                'data' => $this->createOutcomeTableData($squad, $opponent, Outcome::Lose),
            ],
            [
                'text' => 'And if ' . $opponent->renderName() . ' beats ' . $squad->renderName() . ' the result will be:',
                'data' => $this->createOutcomeTableData($squad, $opponent, Outcome::Draw),
            ],
        ];
    }
}
