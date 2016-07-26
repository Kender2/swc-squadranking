<?php
namespace App\Commands\Player\Neighbor;

use App\Commands\Args;
use App\Player;

class VisitArgs extends Args
{
    public $neighborId;

    /**
     * VisitArgs constructor.
     * @param Player $player
     * @param string $neighborId
     */
    public function __construct(Player $player, $neighborId)
    {
        parent::__construct($player);
        $this->neighborId = $neighborId;
    }
}
