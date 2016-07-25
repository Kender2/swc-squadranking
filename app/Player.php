<?php
namespace App;


use Cache;
use Ramsey\Uuid\Uuid;

class Player
{
    protected $playerId;
    protected $secret;
    protected $lastLogin;
    protected $authKey;
    protected $deviceToken;
    const SESSION_TIMEOUT_MINUTES = 60;

    /**
     * Player constructor.
     */
    public function __construct()
    {
        $this->playerId = Cache::get('playerId');
        $this->secret = Cache::get('secret');
        $this->deviceToken = Cache::get('deviceToken');
        $this->lastLogin = Cache::get('lastLogin', 0);
        $this->authKey = Cache::get('authKey', '');
    }

    public function createNew($playerId, $secret)
    {
        $this->playerId = $playerId;
        $this->secret = $secret;
        $this->deviceToken = Uuid::uuid4()->toString();

        Cache::forever('playerId', $this->playerId);
        Cache::forever('secret', $this->secret);
        Cache::forever('deviceToken', $this->deviceToken);

        $this->setLastLogin(0);
        $this->setAuthKey();
        return $this;
    }


    /**
     * @return mixed
     */
    public function getPlayerId()
    {
        return $this->playerId;
    }

    /**
     * @return mixed
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @return mixed
     */
    public function getDeviceToken()
    {
        return $this->deviceToken;
    }


    /**
     * @return int
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param int $lastLogin
     * @return $this
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
        Cache::put('lastLogin', $lastLogin, self::SESSION_TIMEOUT_MINUTES);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @param mixed $authKey
     * @return $this
     */
    public function setAuthKey($authKey = '')
    {
        $this->authKey = $authKey;
        Cache::put('authKey', $authKey, self::SESSION_TIMEOUT_MINUTES);
        return $this;
    }


}
