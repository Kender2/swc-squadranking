<?php
namespace App\Commands\Guild;

use App\Commands\Args;
use App\Player;

class SearchByNameArgs extends Args
{
    public $searchTerm;

    /**
     * SearchByNameArgs constructor.
     * @param Player $player
     * @param string $searchTerm
     */
    public function __construct(Player $player, $searchTerm)
    {
        parent::__construct($player);
        $this->searchTerm = $searchTerm;
    }
}
