<?php

namespace Casper\Serializer;

use Casper\Entity\EraReport;

class EraReportJsonSerializer extends JsonSerializer
{
    /**
     * @param EraReport $eraReport
     */
    public static function toJson($eraReport): array
    {
        return array(
            'equivocators' => CLPublicKeyStringSerializer::toStringArray($eraReport->getEquivocators()),
            'inactive_validators' => CLPublicKeyStringSerializer::toStringArray($eraReport->getInactiveValidators()),
            'rewards' => RewardJsonSerializer::fromJsonArray($eraReport->getRewards()),
        );
    }

    public static function fromJson(array $json)
    {
        return new EraReport(
            CLPublicKeyStringSerializer::fromStringArray($json['equivocators']),
            CLPublicKeyStringSerializer::fromStringArray($json['inactive_validators']),
            RewardJsonSerializer::fromJsonArray($json['rewards'])
        );
    }
}
