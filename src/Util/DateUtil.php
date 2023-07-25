<?php

namespace Casper\Util;

class DateUtil
{
    public static function nowTimestampMs(): int
    {
        return (int) round(microtime(true) * 1000);
    }

    public static function getFormattedDateFromTimestampMs(int $timestampMs): string
    {
        return \DateTime::createFromFormat('U.u', number_format($timestampMs / 1000, '3', '.', ''))
            ->format('Y-m-d\TH:i:s.v\Z');
    }

    public static function getTimestampMsFromDateString(string $date): int
    {
        return (int) \DateTime::createFromFormat('Y-m-d\TH:i:s.v\Z', $date)
            ->format('Uv');
    }
}
