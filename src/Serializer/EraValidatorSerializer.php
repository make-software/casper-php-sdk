<?php

namespace Casper\Serializer;

use Casper\Entity\EraValidator;

class EraValidatorSerializer extends Serializer
{
    /**
     * @param EraValidator $eraValidator
     * @return array
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
