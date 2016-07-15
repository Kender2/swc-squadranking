<?php
namespace App\Commands\Guild;

use App\Commands\Args;

class GetPublicArgs extends Args
{
    public $guildId;

    /**
     * GetPublicArgs constructor.
     * @param $guildId
     */
    public function __construct($guildId)
    {
        parent::__construct();
        $this->guildId = $guildId;
    }
}
