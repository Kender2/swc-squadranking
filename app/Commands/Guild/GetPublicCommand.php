<?php
namespace App\Commands\Guild;

use App\Commands\Command;

class GetPublicCommand extends Command
{

    /**
     * GetCommand constructor.
     * @param string $guildId
     */
    public function __construct($guildId)
    {
        parent::__construct();
        $this->action = 'guild.get.public';
        $this->args = new GetPublicArgs($guildId);
    }
}
