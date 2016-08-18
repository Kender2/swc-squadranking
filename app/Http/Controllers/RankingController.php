<?php

namespace App\Http\Controllers;

use App\Squad;

class RankingController extends Controller
{
    public function ranking()
    {
        $squads = Squad::whereDeleted(false)
            ->where('wins', '>=', 10)
            ->orderByRaw('mu - (3*sigma) desc')
            ->simplePaginate(50);

        return view('squad_ranking', compact('squads'));
    }
}
