<?php

namespace App\Exceptions;

use App\CommandResponse;
use App\GameRequest;
use Exception;

class CommandException extends Exception
{
    /**
     * @var GameRequest
     */
    private $request;
    /**
     * @var CommandResponse
     */
    private $commandResponse;

    /**
     * @return GameRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return CommandResponse
     */
    public function getCommandResponse()
    {
        return $this->commandResponse;
    }

    /**
     * CommandException constructor.
     * @param GameRequest $request
     * @param CommandResponse $commandResponse
     */
    public function __construct($request, $commandResponse)
    {
        parent::__construct('The request failed.');
        $this->request = $request;
        $this->commandResponse = $commandResponse;
    }
}
