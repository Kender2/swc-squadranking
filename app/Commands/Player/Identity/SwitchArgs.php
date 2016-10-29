<?php
namespace App\Commands\Player\Identity;

use App\Commands\Args;
use App\Player;

class SwitchArgs extends Args
{
    public $identityIndex;

    /**
     * VisitArgs constructor.
     * @param Player $player
     * @param string $identityIndex
     */
    public function __construct(Player $player, $identityIndex)
    {
        parent::__construct($player);
        $this->identityIndex = $identityIndex;
    }
}
