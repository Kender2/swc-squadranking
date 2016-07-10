<?php

namespace App;

use App\Commands\Auth\GetAuthTokenCommand;
use App\Commands\Guild\GetCommand;
use App\Commands\Guild\GetPublicCommand;
use App\Commands\Player\LoginCommand;
use app\Exceptions\CommandException;
use Cache;
use Log;

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
        $this->getAuthToken();
        $this->login();
    }

    /**
     * @param GameRequest $request
     * @return array
     * @throws CommandException
     */
    protected function executeMultipleRequest(GameRequest $request)
    {
        $response = $this->client->makeRequest($request);

        $this->time = $response->serverTimestamp;

        $result = [];
        foreach ($response->data as $responseData) {
            $commandResponse = new CommandResponse($responseData);
            if ($commandResponse->status !== 0) {
                throw new CommandException($request, $commandResponse);
            }
            $result[$responseData->requestId] = $commandResponse;
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
        return $response;
    }

    public function guildGetPublic($guildId)
    {
        $request = new GameRequest($this->authKey, $this->lastLoginTime, $this->time);
        $request->addCommand(new GetPublicCommand($guildId), $this->requestId++);

        $response = $this->executeRequest($request);
        return $response->result;
    }

    /**
     * @return GameClient
     */
    protected function getAuthToken()
    {
        $authKey = Cache::get('auth_token');
        if ($authKey === null) {
            $request = new GameRequest();
            $request->addCommand(new GetAuthTokenCommand(), $this->requestId++);
            $authKey = $this->executeRequest($request)->result;
            Cache::put('auth_token', $authKey, 60);
        }
        $this->authKey = $authKey;
        return $this;
    }

    /**
     * @return GameClient
     */
    protected function login()
    {
        $lastLoginTime = Cache::get('last_login');
        if ($lastLoginTime === null) {
            $request = new GameRequest($this->authKey);
            $request->addCommand(new LoginCommand(), $this->requestId++);
            $this->executeRequest($request);
            $lastLoginTime = $this->time;
            Cache::put('last_login', $lastLoginTime, 60);
        }
        $this->lastLoginTime = $lastLoginTime;

        return $this;
    }

}
