<?php

namespace Casper\Util;

class ArrayUtil
{
    public static function isMap(array $arr): bool
    {
        if ([] === $arr) {
            return false;
        }

        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
