<?php

namespace App;


use App\Commands\Auth\GetAuthTokenCommand;
use App\Commands\Guild\GetCommand;
use App\Commands\Player\LoginCommand;

class GameClient
{

    protected $client;
    protected $time = 0;
    protected $lastLoginTime;
    protected $authKey;
    protected $requestId = 2;

    /**
     * GameClient constructor.
     * @param ClientRequest $client
     */
    public function __construct(ClientRequest $client)
    {
        $this->client = $client;

        $request = new GameRequest();
        $request->commands[$this->requestId++] = new GetAuthTokenCommand();
        $this->authKey = $this->executeRequest($request)->result;

        $request = new GameRequest();
        $request->authKey = $this->authKey;
        $request->commands[$this->requestId++] = new LoginCommand();
        $this->executeRequest($request);
        $this->lastLoginTime = $this->time;
    }

    /**
     * @param GameRequest $body
     * @return array
     */
    protected function executeMultipleRequest(GameRequest $body)
    {
        $response = $this->client->makeRequest($body);

        $this->time = $response->serverTimestamp;

        $result = [];
        foreach ($response->data as $responseData) {
            $result[$responseData->requestId] = new CommandResponse($responseData);
        }

        return $result;
    }

    /**
     * @param GameRequest $request
     * @return CommandResponse
     */
    protected function executeRequest(GameRequest $request)
    {
        $result = $this->executeMultipleRequest($request);
        return current($result);
    }


    public function guildGet()
    {
        $request = new GameRequest();
        $request->authKey = $this->authKey;
        $request->commands[$this->requestId++] = new GetCommand();

        $response = $this->executeRequest($request);
        Log::debug(__FUNCTION__ . ' ' . $response);
        return $response;
    }

}
