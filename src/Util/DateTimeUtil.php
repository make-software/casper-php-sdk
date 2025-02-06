<?php

namespace Casper\Util;

class DateTimeUtil
{
    const MS_IN_SEC = 1000;
    const MS_IN_MIN = 60000;
    const MS_IN_HOUR = 3600000;
    const MS_IN_DAY = 86400000;

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

    public static function ttlToString(int $ttl): string
    {
        if ($ttl < self::MS_IN_SEC) {
            return $ttl . 'ms';
        }
        else if ($ttl < self::MS_IN_MIN) {
            return (int) ($ttl / self::MS_IN_SEC) . 's';
        }
        else if ($ttl < self::MS_IN_HOUR) {
            return (int) ($ttl / self::MS_IN_MIN) . 'm';
        }
        else if ($ttl < self::MS_IN_DAY) {
            return (int) ($ttl / self::MS_IN_HOUR) . 'h';
        }
        else {
            return (int) ($ttl / self::MS_IN_DAY) . 'day';
        }
    }

    /**
     * @throws \Exception
     */
    public static function ttlToInt(string $ttl): int
    {
        if (strpos($ttl, 'ms')) {
            return (int) $ttl;
        }
        else if (strpos($ttl, 's')) {
            return (int) $ttl * self::MS_IN_SEC;
        }
        else if (strpos($ttl, 'm')) {
            return (int) $ttl * self::MS_IN_MIN;
        }
        else if (strpos($ttl, 'h')) {
            return (int) $ttl * self::MS_IN_HOUR;
        }
        else if (strpos($ttl, 'day')) {
            return (int) $ttl * self::MS_IN_DAY;
        }

        throw new \Exception('Unsupported TTL unit');
    }
}
