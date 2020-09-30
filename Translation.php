<?php

namespace Kodbazis;

class Translation
{
    public static function get($string)
    {
        return [
            'required' => 'Ez a mező kötelező',
            'unique' => 'Ez a mező egyedi'
        ][$string];
    }
}
