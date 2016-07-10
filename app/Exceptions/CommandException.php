<?php

namespace app\Exceptions;

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
