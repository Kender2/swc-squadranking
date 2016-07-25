<?php
namespace App\Commands\Player;

use App\Commands\Command;

class LoginCommand extends Command
{

    /**
     * LoginCommand constructor.
     * @param LoginArgs $args
     */
    public function __construct(LoginArgs $args)
    {
        parent::__construct('player.login', $args);
    }
}
