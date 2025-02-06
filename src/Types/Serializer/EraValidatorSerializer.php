<?php

namespace Casper\Types\Serializer;

use Casper\Types\EraValidator;

class EraValidatorSerializer extends JsonSerializer
{
    /**
     * @param EraValidator $eraValidator
     */
    public static function toJson($eraValidator): array
    {
        return array(
            'era_id' => $eraValidator->getEraId(),
            'validator_weights' => ValidatorWeightSerializer::toJsonArray($eraValidator->getValidatorWeights()),
        );
    }

    public static function fromJson(array $json): EraValidator
    {
        return new EraValidator(
            $json['era_id'],
            ValidatorWeightSerializer::fromJsonArray($json['validator_weights'])
        );
    }
}
