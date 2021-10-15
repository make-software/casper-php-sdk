<?php

namespace Casper\Serializer;

use Casper\Entity\EraEnd;

class EraEndSerializer extends JsonSerializer
{
    /**
     * @param EraEnd $eraEnd
     * @return array
     */
    public static function toJson($eraEnd): array
    {
        return array(
            'era_report' => EraReportSerializer::toJson($eraEnd->getEraReport()),
            'next_era_validator_weights' => ValidatorWeightSerializer::toJsonArray($eraEnd->getNextEraValidatorWeights()),
        );
    }

    public static function fromJson(array $json): EraEnd
    {
        return new EraEnd(
            EraReportSerializer::fromJson($json['era_report']),
            ValidatorWeightSerializer::fromJsonArray($json['next_era_validator_weights']),
        );
    }
}
