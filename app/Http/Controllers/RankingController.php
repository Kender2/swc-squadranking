<?php

namespace App\Http\Controllers;

use App\Squad;

class RankingController extends Controller
{
    public function ranking()
    {
        $squads = Squad::with('averageBaseScore')->whereDeleted(false)
            ->where('wins', '>=', config('sod.win_threshold'))
            ->orderByRaw('mu - (' . config('sod.sigma_multiplier') . '*sigma) desc')
            ->simplePaginate(50);

        return view('squad_ranking', compact('squads'));
    }
}
