<?php

namespace App\Http\Controllers;

use App\Commander;
use App\Squad;
use Cache;

class StatsController extends Controller
{

    public function stats()
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

        return view('stats', compact(['data']));
    }
}
