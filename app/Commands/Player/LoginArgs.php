<?php
namespace App\Commands\Player;

use App\Args;

class LoginArgs extends Args
{

    public $locale = 'en_US';
    public $deviceToken;
    public $deviceType = 'a';
    public $timeZoneOffset = 2;
    
    /**
     * LoginArgs constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->deviceToken = config('sod.device_token');
    }
}
