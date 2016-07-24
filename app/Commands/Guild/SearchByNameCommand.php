<?php
namespace App\Commands\Guild;

use App\Commands\Command;

class SearchByNameCommand extends Command
{
    /**
     * SearchByNameCommand constructor.
     * @param SearchByNameArgs $args
     */
    public function __construct(SearchByNameArgs $args)
    {
        parent::__construct('guild.search.byName', $args);
    }
}
