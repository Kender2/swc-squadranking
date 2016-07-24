<?php
namespace App\Commands\Auth\PreAuth;


class GeneratePlayerArgs
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
