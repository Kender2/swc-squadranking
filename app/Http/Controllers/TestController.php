<?php

namespace App\Http\Controllers;

use App\GameClient;
use App\Squad;
use Illuminate\Foundation\Bus\DispatchesJobs;

class TestController extends Controller
{
    use DispatchesJobs;

    public function test(GameClient $client)
    {
        $columns = [
            'Amount' => 'count(1)',
            'Avg wins' => 'avg(wins)',
            'Avg draws' => 'avg(draws)',
            'Avg losses' => 'avg(losses)',
            'Avg uplinks taken' => 'avg(uplinks_captured)',
            'Avg uplinks saved' => 'avg(uplinks_saved)',
            'Avg reputation' => 'avg(reputation)',
            'Avg medals' => 'avg(medals)',
        ];
        $terms = [];
        foreach ($columns as $title => $expression) {
            $terms[] = $expression . ' AS "' . $title . '"';
        }
        $query = implode(',', $terms);

        $a = Squad::whereFaction('rebel')
            ->getQuery()
            ->selectRaw($query)
            ->first();
        dd($a);
        return 'ok';
    }
}
