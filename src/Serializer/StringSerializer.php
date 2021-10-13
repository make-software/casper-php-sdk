<?php

namespace Casper\Serializer;

abstract class StringSerializer
{
    abstract public static function toString($object): string;

    abstract public static function fromString(string $string);

    public static function toStringArray(array $array): array
    {
        return array_map(function ($object) {
            return static::toString($object);
        }, $array);
    }

    public static function fromStringArray(array $array): array
    {
        return array_map(function ($string) {
            return static::fromString($string);
        }, $array);
    }
}
