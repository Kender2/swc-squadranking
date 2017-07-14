<?php
namespace App\Commands\Player;

use App\Commands\Args;
use App\Player;

class DeviceRegisterArgs extends Args
{
    public $deviceToken;
    public $deviceType = 'a';

    /**
     * DeviceRegisterArgs constructor.
     * @param Player $player
     */
    public function __construct(Player $player)
    {
        parent::__construct($player);
        $this->deviceToken = $player->deviceToken;
    }
}
