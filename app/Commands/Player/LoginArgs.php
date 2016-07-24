<?php
namespace App\Commands\Player;

use App\Commands\Args;
use App\Player;

class LoginArgs extends Args
{

    public $locale = 'en_US';
    public $deviceToken;
    public $deviceType = 'a';
    public $timeZoneOffset = 2;

    /**
     * LoginArgs constructor.
     * @param Player $player
     */
    public function __construct(Player $player)
    {
        parent::__construct($player);
        $this->deviceToken = $player->getDeviceToken();
    }
}
