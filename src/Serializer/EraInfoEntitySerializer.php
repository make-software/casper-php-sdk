<?php

namespace Casper\Serializer;

use Casper\Entity\EraInfo;

class EraInfoEntitySerializer extends EntitySerializer
{
    /**
     * @param EraInfo $eraInfo
     * @return array
     */
    public static function toJson($eraInfo): array
    {
        return array(
            'seigniorage_allocations' =>
                SeigniorageAllocationEntitySerializer::toJsonArray($eraInfo->getSeigniorageAllocations()),
        );
    }

    public static function fromJson(array $json): EraInfo
    {
        return new EraInfo(
            SeigniorageAllocationEntitySerializer::fromJsonArray($json['seigniorage_allocations'])
        );
    }
}
