<?php

namespace App;

use App\Commands\Command;

class GameRequest
{

    public $authKey;
    public $pickupMessages = true;
    public $lastLoginTime = 0;
    public $commands = [];
    
    protected $time = 0;

    /**
     * GameRequest constructor.
     * @param string $authKey
     * @param int $lastLoginTime
     * @param bool $pickupMessages
     */
    public function __construct($authKey = '', $lastLoginTime = 0, $time = 0, $pickupMessages = true)
    {
        $this->authKey = $authKey;
        $this->lastLoginTime = $lastLoginTime;
        $this->time = $time;
        $this->pickupMessages = $pickupMessages;
    }

    public function addCommand(Command $command, $requestId)
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
