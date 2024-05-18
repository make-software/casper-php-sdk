<?php

namespace Casper\Util;

class NumUtil
{
    public static function padNumberLeft($number, int $base = 16, int $length = 64, string $padString = '0'): string
    {
        if (!is_resource($number) && !($number instanceof \GMP)) {
            $number = gmp_init($number);
        }

        $numberString = gmp_strval($number, $base);
        $paddedString = str_pad($numberString, $length, $padString, STR_PAD_LEFT);

        return $paddedString;
    }
}
