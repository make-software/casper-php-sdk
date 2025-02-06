<?php

namespace Casper\Types\Serializer;

use Casper\Types\Serializer\EraReportSerializer;
use Casper\Types\Serializer\ValidatorWeightSerializer;
use Casper\Types\EraEnd;

class EraEndSerializer extends JsonSerializer
{
    /** @param EraEnd $eraEnd  */
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
