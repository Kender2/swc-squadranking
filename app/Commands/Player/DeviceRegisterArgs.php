<?php
namespace App\Commands\Player;

use App\Commands\Args;

class DeviceRegisterArgs extends Args
{
    public $deviceToken;
    public $deviceType = 'a';

    /**
     * DeviceRegisterArgs constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->deviceToken = config('sod.device_token');
    }
}
