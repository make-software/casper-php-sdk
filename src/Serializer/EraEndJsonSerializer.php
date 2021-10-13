<?php

namespace Casper\Serializer;

use Casper\Entity\EraEnd;

class EraEndJsonSerializer extends JsonSerializer
{
    /**
     * @param EraEnd $eraEnd
     * @return array
     */
    public static function toJson($eraEnd): array
    {
        return array(
            'era_report' => EraReportJsonSerializer::toJson($eraEnd->getEraReport()),
            'next_era_validator_weights' => ValidatorWeightJsonSerializer::toJsonArray($eraEnd->getNextEraValidatorWeights()),
        );
    }

    public static function fromJson(array $json)
    {
        return new EraEnd(
            EraReportJsonSerializer::fromJson($json['era_report']),
            ValidatorWeightJsonSerializer::fromJsonArray($json['next_era_validator_weights']),
        );
    }
}
