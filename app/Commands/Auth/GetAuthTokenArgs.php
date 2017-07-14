<?php
namespace App\Commands\Auth;

use App\Commands\Args;
use App\Player;

class GetAuthTokenArgs extends Args
{

    public $requestToken;

    /**
     * GetAuthTokenArgs constructor.
     * @param Player $player
     */
    public function __construct(Player $player)
    {
        parent::__construct($player);
        $this->requestToken = static::generateRequestToken($player->secret, $player->playerId);
    }

    private static function generateRequestToken($secret, $playerId)
    {
        $timestamp = round(microtime(true) * 1000);
        $string = '{"userId":"' . $playerId . '","expires":' . $timestamp . '}';
        $hex = strtoupper(hash_hmac('sha256', $string, $secret));
        return base64_encode($hex . '.' . $string);
    }
}
