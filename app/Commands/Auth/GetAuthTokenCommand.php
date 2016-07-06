<?php
namespace App\Commands\Auth;

use App\Commands\Command;

class GetAuthTokenCommand extends Command
{

    /**
     * GetAuthTokenCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->action = 'auth.getAuthToken';
        $this->args = new GetAuthTokenArgs();
    }
}
