<?php
namespace App\Commands\Auth\PreAuth;

use App\Commands\Command;

class GeneratePlayerCommand extends Command
{

    /**
     * GeneratePlayerCommand constructor.
     * @param GeneratePlayerArgs $args
     */
    public function __construct(GeneratePlayerArgs $args)
    {
        parent::__construct('auth.preauth.generatePlayer', $args);
    }

}
