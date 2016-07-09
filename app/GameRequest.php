<?php

namespace App;

use App\Commands\Command;

class GameRequest
{

    public $authKey;
    public $pickupMessages = true;
    public $lastLoginTime = 0;
    public $commands = [];

    /**
     * GameRequest constructor.
     * @param string $authKey
     * @param int $lastLoginTime
     * @param bool $pickupMessages
     */
    public function __construct($authKey = '', $lastLoginTime = 0, $pickupMessages = true)
    {
        $this->authKey = '';
        $this->lastLoginTime = $lastLoginTime;
        $this->pickupMessages = $pickupMessages;
    }

    public function addCommand(Command $command)
    {
        $this->commands[] = $command;
    }
}
