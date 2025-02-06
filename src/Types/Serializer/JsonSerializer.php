<?php

namespace Casper\Types\Serializer;

abstract class JsonSerializer
{
    abstract public static function toJson($object);

    abstract public static function fromJson(array $json);

    public static function toJsonArray(array $array): array
    {
        return array_map(function ($object) { return static::toJson($object); }, $array);
    }

    public static function fromJsonArray(array $array): array
    {
        return array_map(function ($json, $key) { return static::fromJson($json, $key); }, $array, array_keys($array));
    }
}
