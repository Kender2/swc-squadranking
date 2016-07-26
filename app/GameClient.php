<?php

namespace App;

use App\Commands\Args;
use App\Commands\Auth\GetAuthTokenArgs;
use App\Commands\Auth\GetAuthTokenCommand;
use App\Commands\Auth\PreAuth\GeneratePlayerArgs;
use App\Commands\Auth\PreAuth\GeneratePlayerCommand;
use App\Commands\CommandInterface;
use App\Commands\Guild\GetCommand;
use App\Commands\Guild\GetPublicArgs;
use App\Commands\Guild\GetPublicCommand;
use App\Commands\Guild\SearchByNameArgs;
use App\Commands\Guild\SearchByNameCommand;
use App\Commands\Player\LoginArgs;
use App\Commands\Player\LoginCommand;
use App\Commands\Player\Neighbor\VisitArgs;
use App\Commands\Player\Neighbor\VisitCommand;
use App\Exceptions\CommandException;
use App\Exceptions\PlayerBannedException;
use App\Exceptions\PlayerLoggedOutException;

class GameClient
{
    protected $client;
    protected $time = 0;
    protected $authKey;
    protected $requestId = 2;
    protected $player;

    private $initialized = false;

    const DESYNC_BANNED = 1999;

    /**
     * GameClient constructor.
     * @param ClientRequest $client
     * @param Player $player
     */
    public function __construct(ClientRequest $client, Player $player)
    {
        $this->client = $client;
        $this->player = $player;
    }

    /**
     * @param GameRequest $request
     *
     * @return array
     *
     * @throws CommandException
     */
    protected function executeMultipleRequest(GameRequest $request)
    {
        $response = $this->client->makeRequest($request);

        // @TODO: refactor side-effect usage.
        $this->time = $response->getServerTimestamp();

        $result = [];
        foreach ($response->getData() as $responseData) {
            $commandResponse = new CommandResponse($responseData);
            $this->checkResponse($request, $commandResponse);
            $result[$responseData->requestId] = $commandResponse;
        }

        return $result;
    }

    /**
     * @param GameRequest $request
     *
     * @return CommandResponse
     *
     * @throws \App\Exceptions\CommandException
     */
    protected function executeRequest(GameRequest $request)
    {
        $result = $this->executeMultipleRequest($request);
        return current($result);
    }


    public function guildGet()
    {
        $args = new Args($this->player);
        $command = new GetCommand($args);
        return $this->runCommand($command);
    }

    public function guildGetPublic($guildId)
    {
        $args = new GetPublicArgs($this->player, $guildId);
        $command = new GetPublicCommand($args);
        $response = $this->runCommand($command);

        // Exception if requesting data for own squad.
        if ($response->result === null) {
            return $this->guildGet()->result;
        }

        return $response->result;
    }

    /**
     * Search for squads.
     *
     * @param string $searchTerm
     *
     * @return array
     */
    public function guildSearchByName($searchTerm)
    {
        $args = new SearchByNameArgs($this->player, $searchTerm);
        $command = new SearchByNameCommand($args);
        return $this->runCommand($command)->result;
    }

    public function visitNeighbor($neighborId)
    {
        $args = new VisitArgs($this->player, $neighborId);
        $command = new VisitCommand($args);
        return $this->runCommand($command)->result;
    }

    /**
     * @return GameClient
     */
    protected function getAuthToken()
    {
        $authKey = $this->player->getAuthKey();
        if ($authKey === '') {
            $args = new GetAuthTokenArgs($this->player);
            $command = new GetAuthTokenCommand($args);
            $authKey = $this->runCommand($command)->result;
        }
        return $authKey;
    }

    /**
     * @return GameClient
     */
    protected function login()
    {
        if (!$this->player->isLoggedIn()) {
            $args = new LoginArgs($this->player);
            $command = new LoginCommand($args);
            $messages = $this->runCommand($command)->getMessages();
            $time = current($messages->login)->message->loginTime;
            $this->player->setLastLogin($time);
        }
        return $this;
    }

    /**
     * @param GameRequest $request
     * @param CommandResponse $commandResponse
     * @throws CommandException
     */
    protected function checkResponse(GameRequest $request, CommandResponse $commandResponse)
    {
        switch ($commandResponse->status) {
            case 0:
                return;
            case 802:
                throw new PlayerLoggedOutException($request, $commandResponse);
            case 1999:
                throw new PlayerBannedException($request, $commandResponse);
                break;
            default:
                throw new CommandException($request, $commandResponse);

        }
    }

    protected function createNewPlayer()
    {
        $command = new GeneratePlayerCommand(new GeneratePlayerArgs());
        $result = $this->runCommand($command)->getResult();
        $this->player->createNew($result->playerId, $result->secret);
    }

    /**
     * @param CommandInterface $command
     * @return CommandResponse
     */
    protected function runCommand(CommandInterface $command)
    {
        if (!$this->initialized) {
            $this->initialize();
        }
        $request = new GameRequest($this->player);
        $request->addCommand($command, $this->requestId++);
        try {
            $this->executeRequest($request);
        } catch (PlayerLoggedOutException $e) {
            $this->initialize();
        }
    }

    protected function initialize()
    {
        $this->initialized = true;
        if ($this->player->getPlayerId() === null) {
            $this->createNewPlayer();
        }
        $authKey = $this->getAuthToken();
        $this->player->setAuthKey($authKey);
        try {
            $this->login();
        } catch (PlayerBannedException $e) {
            $this->createNewPlayer();
            $this->login();
        }

    }

}
