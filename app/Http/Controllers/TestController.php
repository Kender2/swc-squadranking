<?php

namespace App\Http\Controllers;

use App\ClientRequest;
use App\Commands\Auth\GetAuthTokenCommand;
use App\Commands\Guild\GetCommand;
use App\Commands\Player\LoginCommand;
use App\RequestBody;

class TestController extends Controller
{
    public function test()
    {
        $client = new ClientRequest();
        $body = new RequestBody();
        $body->addCommand(new GetAuthTokenCommand());
        $response = $client->makeRequest($body);

        $authKey = $response[0]->result;

        $body = new RequestBody();
        $body->authKey = $authKey;
        $body->addCommand(new LoginCommand());
        $response = $client->makeRequest($body);

        $body = new RequestBody();
        $body->authKey = $authKey;
        $body->addCommand(new GetCommand());
        $response = $client->makeRequest($body);

        return $response;
    }
}
