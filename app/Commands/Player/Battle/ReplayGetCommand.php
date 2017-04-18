<?php
namespace App\Commands\Player\Battle;

use App\Commands\Command;

class ReplayGetCommand extends Command
{

    /**
     * ReplayGetCommand constructor.
     * @param ReplayGetArgs $args
     */
    public function __construct(ReplayGetArgs $args)
    {
        parent::__construct('player.battle.replay.get', $args);
    }
}
