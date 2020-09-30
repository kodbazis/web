<?php

namespace Kodbazis;

class Utils
{
    public static function aggregateBy($key, $arr)
    {
        $ret = [];
        foreach ($arr as $item) {
            if (!isset($ret[$item[$key]])) {
                $ret[$item[$key]] = [$item];
                continue;
            }
            $ret[$item[$key]][] = $item;
        }
        return $ret;
    }
}
