<?php
namespace App\Commands\Player\Battle;

use App\Commands\Args;
use App\Player;

class ReplayGetArgs extends Args
{
    public $battleId;
    public $participantId;

    /**
     * ReplayGetArgs constructor.
     * @param Player $player
     * @param string $battleId
     * @param string $participantId
     */
    public function __construct(Player $player, $battleId, $participantId)
    {
        parent::__construct($player);
        $this->battleId = $battleId;
        $this->participantId = $participantId;
    }
}
