<?php

namespace App\Http\Controllers;

use App\GameClient;
use App\MemberProcessor;
use App\Squad;
use Illuminate\Foundation\Bus\DispatchesJobs;

class TestController extends Controller
{
    use DispatchesJobs;

    public function test(GameClient $client)
    {
        return 'ok';
    }
}
