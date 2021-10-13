<?php

namespace Casper\Serializer;

abstract class JsonSerializer
{
    abstract public static function toJson($object): array;

    abstract public static function fromJson(array $json);

    public static function toJsonArray(array $array): array
    {
        return array_map(function ($object) {
            return static::toJson($object);
        }, $array);
    }

    public static function fromJsonArray(array $array): array
    {
        return array_map(function ($json) {
            return static::fromJson($json);
        }, $array);
    }
}
