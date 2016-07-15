<?php
namespace App\Commands\Guild;

use App\Commands\Args;

class SearchByNameArgs extends Args
{
    public $searchTerm;

    /**
     * SearchByNameArgs constructor.
     * @param string $searchTerm
     */
    public function __construct($searchTerm)
    {
        parent::__construct();
        $this->searchTerm = $searchTerm;
    }
}
