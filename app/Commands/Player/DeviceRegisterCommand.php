<?php
namespace App\Commands\Player;

use App\Commands\Command;

class DeviceRegisterCommand extends Command
{

    /**
     * DeviceRegisterCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->action = 'player.device.register';
        $this->args = new DeviceRegisterArgs();
    }
}
