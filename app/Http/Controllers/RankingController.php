<?php

namespace App\Http\Controllers;

use App\Squad;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function ranking(Request $request)
    {
        $squads = Squad::with('averageBaseScore')->whereDeleted(false)
            ->where('wins', '>=', config('sod.win_threshold'))
            ->orderByRaw('mu - (' . config('sod.sigma_multiplier') . '*sigma) desc')
            ->simplePaginate(50);

        if ($request->wantsJson()) {
            return $squads;
        }

        return view('squad_ranking', compact('squads'));
    }
}
