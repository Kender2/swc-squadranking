<?php

namespace App\Http\Controllers;

use App\ClientRequest;
use App\GameClient;

class TestController extends Controller
{
    public function test()
    {
        $client = new GameClient(new ClientRequest());

        $guild = $client->guildGet();

        return $guild;
    }
}
