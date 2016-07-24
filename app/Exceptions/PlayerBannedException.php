<?php
namespace App\Exceptions;

use App\CommandResponse;

class PlayerBannedException extends CommandException
{

    private $reason;

    /**
     * PlayerBannedException constructor.
     * @param \App\GameRequest $request
     * @param CommandResponse $commandResponse
     */
    public function __construct($request, $commandResponse)
    {
        parent::__construct($request, $commandResponse);
        $this->reason = $commandResponse->getData()->reason;
    }

    /**
     * @return mixed
     */
    public function getReason()
    {
        return $this->reason;
    }
}
