<?php

namespace App\Http\Controllers;

use App\Commander;
use App\Squad;
use Cache;
use Illuminate\Http\Request;

class StatsController extends Controller
{

    public function stats(Request $request)
    {
        $data = Cache::get('statistics', false);
        if ($data === false) {
            $data = [
                'Squads' => Squad::getStats(),
                'Commanders' => Commander::getStats(),
                'Planets' => Commander::getPlanetStats(),
            ];
            Cache::put('statistics', $data, 60);
        }
        if ($request->wantsJson()) {
            return $data;
        }

        return view('stats', compact(['data']));
    }
}
