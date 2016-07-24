<?php
namespace App\Commands\Guild;

use App\Commands\Args;
use App\Commands\Command;

class GetCommand extends Command
{

    /**
     * GetCommand constructor.
     * @param Args $args
     */
    public function __construct(Args $args)
    {
        parent::__construct('guild.get', $args);
    }
}
