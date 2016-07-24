<?php
namespace App\Commands\Auth;

use App\Commands\Command;

class GetAuthTokenCommand extends Command
{

    /**
     * GetAuthTokenCommand constructor.
     * @param GetAuthTokenArgs $args
     */
    public function __construct(GetAuthTokenArgs $args)
    {
        parent::__construct('auth.getAuthToken', $args);
    }

}
