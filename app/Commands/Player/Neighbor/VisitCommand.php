<?php
namespace App\Commands\Player\Neighbor;

use App\Commands\Command;

class VisitCommand extends Command
{

    /**
     * VisitCommand constructor.
     * @param VisitArgs $args
     */
    public function __construct(VisitArgs $args)
    {
        parent::__construct('player.neighbor.visit', $args);
    }
}
