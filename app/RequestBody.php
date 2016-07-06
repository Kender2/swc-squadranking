<?php

namespace App;

use App\Commands\Command;

class RequestBody
{

    public $authKey;
    public $pickupMessages = true;
    public $lastLoginTime = 0;
    public $commands = [];
    protected $requestId;

    /**
     * RequestBody constructor.
     * @param int $requestId
     */
    public function __construct($requestId = 2)
    {
        $this->authKey = '';
        $this->requestId = $requestId;
    }

    public function addCommand(Command $command)
    {
        $command->requestId = $this->requestId++;
        $this->commands[] = $command;
    }
}
