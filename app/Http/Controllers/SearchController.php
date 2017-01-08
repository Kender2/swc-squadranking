<?php

namespace App\Http\Controllers;

use App\Commander;
use App\Squad;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        if ($request->has('q')) {
            $searchTerm = $request->input('q');
            $searchType = $request->input('st', 'squad');

            if ($searchType === 'squad') {
                $results = Squad::whereDeleted(false)
                    ->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orderByRaw('mu - (' . config('sod.sigma_multiplier') . '*sigma) desc')
                    ->simplePaginate(20);
                if ($request->wantsJson()) {
                    return $results;
                }
                if (count($results) === 1) {
                    return redirect()->route('squadhistory', [$results->first()]);
                }
                return view('search.squad', compact('results'));
            } elseif ($searchType === 'commander') {
                $results = Commander::with('squad')
                    ->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orderBy('name')
                    ->simplePaginate(20);
                if ($request->wantsJson()) {
                    return $results;
                }
                if (count($results) === 1) {
                    $commander = $results->first();
                    return redirect()->route('squadmembers', ['id' => $commander->squad->id, 'hl' => $commander->playerId]);
                }
                return view('search.commander', compact('results'));
            }
        }
        return view('search.squad', compact('results'));
    }
}
