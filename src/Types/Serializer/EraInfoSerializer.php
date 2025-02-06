<?php

namespace Casper\Types\Serializer;

use Casper\Types\Serializer\JsonSerializer;
use Casper\Types\Serializer\SeigniorageAllocationSerializer;
use Casper\Types\EraInfo;

class EraInfoSerializer extends JsonSerializer
{
    /**
     * @param EraInfo $eraInfo
     */
    public static function toJson($eraInfo): array
    {
        return array(
            'seigniorage_allocations' =>
                SeigniorageAllocationSerializer::toJsonArray($eraInfo->getSeigniorageAllocations()),
        );
    }

    public static function fromJson(array $json): EraInfo
    {
        return new EraInfo(
            SeigniorageAllocationSerializer::fromJsonArray($json['seigniorage_allocations'])
        );
    }
}
