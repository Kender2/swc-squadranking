<?php
namespace App\Commands\Player\Identity;

use App\Commands\Command;

class SwitchCommand extends Command
{

    /**
     * SwitchCommand constructor.
     * @param SwitchArgs $args
     */
    public function __construct(SwitchArgs $args)
    {
        parent::__construct('player.identity.switch', $args);
    }
}
