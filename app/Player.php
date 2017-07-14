<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * App\Player
 *
 * @mixin \Eloquent
 * @property string $playerId
 * @property string $secret
 * @property string $deviceToken
 * @property string $authKey
 * @property \Carbon\Carbon $lastLoginTime
 * @property bool $banned
 * @property bool $reserved
 * @property int $reserved_at
 * @method static \Illuminate\Database\Query\Builder|\App\Player wherePlayerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereSecret($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereDeviceToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereAuthKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereLastLoginTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereBanned($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereReserved($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereReservedAt($value)
 */
class Player extends Model
{
    const SESSION_TIMEOUT_MINUTES = 60;

    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = 'playerId';

    protected $guarded = [];

    protected $dates = [
        'lastLoginTime',
    ];

    protected $loggedIn;


    //const SESSION_TIMEOUT_MINUTES = 60;

    public function createNew($playerId, $secret)
    {
        $this->playerId = $playerId;
        $this->secret = $secret;
        $this->deviceToken = Uuid::uuid4()->toString();

        return $this;
    }

    /**
     * @param int $lastLoginTime
     *
     * @return $this
     */
    public function setLastLogin($lastLoginTime)
    {
        $this->lastLoginTime = $lastLoginTime;
        //Cache::put('lastLogin', $lastLogin, self::SESSION_TIMEOUT_MINUTES);
        $this->loggedIn = ($lastLoginTime > 0);
        return $this;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function getLastLogin()
    {
        return $this->lastLoginTime;
    }

    /**
     * @return mixed
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }


    public function isLoggedIn()
    {
        return $this->loggedIn;
    }

    public function logout()
    {
        $this->loggedIn = false;
        $this->setAuthKey();
    }

    /**
     * @param mixed $authKey
     *
     * @return $this
     */
    public function setAuthKey($authKey = '')
    {
        $this->authKey = $authKey;
        //Cache::put('authKey', $authKey, self::SESSION_TIMEOUT_MINUTES);
        return $this;
    }

}
