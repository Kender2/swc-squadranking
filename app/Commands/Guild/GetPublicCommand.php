<?php
namespace App\Commands\Guild;

use App\Commands\Command;

class GetPublicCommand extends Command
{

    /**
     * GetCommand constructor.
     * @param GetPublicArgs $args
     */
    public function __construct(GetPublicArgs $args)
    {
        parent::__construct('guild.get.public', $args);
    }
}
