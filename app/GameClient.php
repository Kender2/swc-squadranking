<?php

namespace App;


use App\Commands\Auth\GetAuthTokenCommand;
use App\Commands\Guild\GetCommand;
use App\Commands\Player\LoginCommand;
use Illuminate\Support\Facades\Log;

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
        $request->addCommand(new GetAuthTokenCommand(), $this->requestId++);
        $this->authKey = $this->executeRequest($request)->result;

        $request = new GameRequest($this->authKey);
        $request->addCommand(new LoginCommand(), $this->requestId++);
        $this->executeRequest($request);
        $this->lastLoginTime = $this->time;
    }

    /**
     * @param GameRequest $request
     * @return array
     */
    protected function executeMultipleRequest(GameRequest $request)
    {
        $response = $this->client->makeRequest($request);

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
        $request = new GameRequest($this->authKey, $this->lastLoginTime, $this->time);
        $request->addCommand(new GetCommand(), $this->requestId++);

        $response = $this->executeRequest($request);
        Log::debug(__FUNCTION__ . ' ' . $response);
        return $response;
    }

}
