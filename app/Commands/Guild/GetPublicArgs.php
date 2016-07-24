<?php
namespace App\Commands\Guild;

use App\Commands\Args;
use App\Player;

class GetPublicArgs extends Args
{
    public $guildId;

    /**
     * GetPublicArgs constructor.
     * @param Player $player
     * @param $guildId
     */
    public function __construct(Player $player, $guildId)
    {
        parent::__construct($player);
        $this->guildId = $guildId;
    }
}
