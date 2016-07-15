<?php
namespace App\Commands\Guild;

use App\Commands\Command;

class SearchByNameCommand extends Command
{
    /**
     * SearchByNameCommand constructor.
     * @param string $searchTerm
     */
    public function __construct($searchTerm)
    {
        parent::__construct();
        $this->action = 'guild.search.byName';
        $this->args = new SearchByNameArgs($searchTerm);
    }
}
