<?php

namespace App\Http\Controllers;

use App\GameClient;
use Illuminate\Foundation\Bus\DispatchesJobs;

class TestController extends Controller
{
    use DispatchesJobs;

    public function test(GameClient $client)
    {
//        $result = $client->switchIdentity(0);
        return 'ok';
    }
}
