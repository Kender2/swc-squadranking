<?php

namespace App;


trait ColoredName
{
    /**
     * @return string
     */
    public function renderName()
    {
        return static::colorName($this->name);
    }

    /**
     * @return string
     */
    public function renderNamePlain()
    {
        return static::plainName($this->name);
    }

    /**
     * @param $name
     * @return string
     */
    public static function colorName($name)
    {
        $safe_name = htmlentities(urldecode($name));
        return preg_replace('/\[([0-9A-Fa-f]{6})\]/', '<span style="color: #$1">', $safe_name) . '</span>';
    }

    /**
     * @param $name
     * @return string
     */
    public static function plainName($name)
    {
        $safe_name = htmlentities(urldecode($name));
        return preg_replace('/\[[0-9A-Fa-f]{6}\]/', '', $safe_name);
    }
}
