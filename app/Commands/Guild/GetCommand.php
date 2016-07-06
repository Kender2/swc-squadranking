<?php
namespace App\Commands\Guild;

use App\Args;
use App\Commands\Command;

class GetCommand extends Command
{

    /**
     * GetCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->action = 'guild.get';
        $this->args = new Args();
    }
}
