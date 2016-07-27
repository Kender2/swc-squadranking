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
            ->take(100)
            ->get();
        return view('squad_ranking', compact('squads'));
    }
}
