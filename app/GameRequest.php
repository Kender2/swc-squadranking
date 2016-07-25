<?php

namespace App;

use App\Commands\CommandInterface;

class GameRequest
{

    public $authKey;
    public $pickupMessages = true;
    public $lastLoginTime = 0;
    public $commands = [];
    
    protected $time = 0;

    /**
     * GameRequest constructor.
     * @param Player $player
     * @param int $time
     * @param bool $pickupMessages
     */
    public function __construct(Player $player, $time = 0, $pickupMessages = true)
    {
        $this->authKey = $player->getAuthKey();
        $this->lastLoginTime = $player->getLastLogin();
        $this->time = $time;
        $this->pickupMessages = $pickupMessages;
    }

    public function addCommand(CommandInterface $command, $requestId)
    {
        $command->time = $this->time;
        $command->requestId = $requestId;
        $this->commands[] = $command;
    }

    public function getActions()
    {
        $actions = [];
        foreach ($this->commands as $command) {
            $actions[] = $command->requestId . ': ' . $command->action;
        }
        return implode(',', $actions);
    }
}
