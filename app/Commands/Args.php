<?php
namespace App\Commands;

use App\Player;

class Args implements ArgsInterface
{
    public $playerId;

    /**
     * Args constructor.
     * @param Player $player
     */
    public function __construct(Player $player)
    {
        $this->playerId = $player->getPlayerId();
    }


}
