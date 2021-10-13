<?php

namespace Casper\Serializer;

use Casper\Entity\EraValidator;

class EraValidatorJsonSerializer extends JsonSerializer
{
    /**
     * @param EraValidator $eraValidator
     */
    public static function toJson($eraValidator): array
    {
        return array(
            'era_id' => $eraValidator->getEraId(),
            'validator_weights' => ValidatorWeightJsonSerializer::toJsonArray($eraValidator->getValidatorWeights()),
        );
    }

    public static function fromJson(array $json): EraValidator
    {
        return new EraValidator(
            $json['era_id'],
            ValidatorWeightJsonSerializer::fromJsonArray($json['validator_weights'])
        );
    }
}
