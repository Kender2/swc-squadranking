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
        $memberProcessor = new MemberProcessor();
        $squad = Squad::find('f9c20e26-7f21-11e4-8fad-06de38004eb1');
        $data = $client->guildGetPublic('f9c20e26-7f21-11e4-8fad-06de38004eb1');
        $memberProcessor->processMembers($data->members, $squad);
        return 'ok';
    }
}
