<?php

namespace Casper\Serializer;

use Casper\Entity\EraInfo;

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
