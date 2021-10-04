<?php

namespace Casper\Serializer;

abstract class Serializer
{
    abstract public static function toJson($object): array;

    abstract public static function fromJson(array $json);

    public static function toJsonArray(array $array): array
    {
        return array_map(
            function ($json) {
                return static::toJson($json);
            },
            $array
        );
    }

    public static function fromJsonArray(array $array): array
    {
        return array_map(
            function ($json) {
                return static::fromJson($json);
            },
            $array
        );
    }
}
