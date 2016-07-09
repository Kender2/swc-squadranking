<?php
namespace App\Commands\Auth;

use App\Commands\Args;

class GetAuthTokenArgs extends Args
{

    public $requestToken;

    /**
     * GetAuthTokenArgs constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->requestToken = static::generateRequestToken(config('sod.secret'), config('sod.player_id'));
    }

    private static function generateRequestToken($secret, $playerId)
    {
        $timestamp = round(microtime(true) * 1000);
        $string = '{"userId":"' . $playerId . '","expires":' . $timestamp . '}';
        $hex = strtoupper(hash_hmac('sha256', $string, $secret));
        $result = base64_encode($hex . '.' . $string);
        return $result;
    }
}
