<?php

namespace Casper\Serializer;

use Casper\Entity\EraReport;

class EraReportSerializer extends JsonSerializer
{
    /**
     * @param EraReport $eraReport
     */
    public static function toJson($eraReport): array
    {
        return array(
            'equivocators' => CLPublicKeySerializer::toStringArray($eraReport->getEquivocators()),
            'inactive_validators' => CLPublicKeySerializer::toStringArray($eraReport->getInactiveValidators()),
            'rewards' => RewardSerializer::fromJsonArray($eraReport->getRewards()),
        );
    }

    public static function fromJson(array $json)
    {
        return new EraReport(
            CLPublicKeySerializer::fromStringArray($json['equivocators']),
            CLPublicKeySerializer::fromStringArray($json['inactive_validators']),
            RewardSerializer::fromJsonArray($json['rewards'])
        );
    }
}
