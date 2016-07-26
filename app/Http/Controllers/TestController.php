<?php

namespace App\Http\Controllers;

use App\GameClient;
use App\Jobs\FetchSquadData;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    use DispatchesJobs;

    public function test(GameClient $client)
    {
    }
}
