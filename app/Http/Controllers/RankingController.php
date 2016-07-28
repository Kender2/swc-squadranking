<?php

namespace App\Http\Controllers;

use App\Squad;
use Illuminate\Http\Request;

use App\Http\Requests;

class RankingController extends Controller
{
    public function ranking()
    {
        $squads = Squad::whereDeleted(false)
            ->orderBy('mu', 'desc')
            ->simplePaginate(50);

        return view('squad_ranking', compact('squads'));
    }
}
