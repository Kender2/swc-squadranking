<?php
namespace App\Commands\Auth\PreAuth;

use App\Commands\ArgsInterface;

class GeneratePlayerArgs implements ArgsInterface
{
    public $locale = 'en_US';

    /**
     * GeneratePlayerArgs constructor.
     * @param string $locale
     */
    public function __construct($locale = 'en_US')
    {
        $this->locale = $locale;
    }

}
