<?php

namespace Casper\Serializer;

use Casper\Entity\EraInfo;

class EraInfoJsonSerializer extends JsonSerializer
{
    /**
     * @param EraInfo $eraInfo
     */
    public static function toJson($eraInfo): array
    {
        return array(
            'seigniorage_allocations' =>
                SeigniorageAllocationJsonSerializer::toJsonArray($eraInfo->getSeigniorageAllocations()),
        );
    }

    public static function fromJson(array $json): EraInfo
    {
        return new EraInfo(
            SeigniorageAllocationJsonSerializer::fromJsonArray($json['seigniorage_allocations'])
        );
    }
}
