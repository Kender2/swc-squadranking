<?php
namespace App\Commands\Player;

use App\Commands\Command;

class DeviceRegisterCommand extends Command
{

    /**
     * DeviceRegisterCommand constructor.
     * @param DeviceRegisterArgs $args
     */
    public function __construct(DeviceRegisterArgs $args)
    {
        parent::__construct('player.device.register', $args);
    }
}
