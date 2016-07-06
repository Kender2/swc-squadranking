<?php
namespace App\Commands\Player;

use App\Commands\Command;

class LoginCommand extends Command
{

    /**
     * GetCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->action = 'player.login';
        $this->args = new LoginArgs();
    }
}
