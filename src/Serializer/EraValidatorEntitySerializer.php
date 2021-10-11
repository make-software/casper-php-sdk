<?php

namespace Casper\Serializer;

use Casper\Entity\EraValidator;

class EraValidatorEntitySerializer extends EntitySerializer
{
    /**
     * @param EraValidator $eraValidator
     * @return array
     */
    public static function toJson($eraValidator): array
    {
        return array(
            'era_id' => $eraValidator->getEraId(),
            'validator_weights' => ValidatorWeightEntitySerializer::toJsonArray($eraValidator->getValidatorWeights()),
        );
    }

    public static function fromJson(array $json): EraValidator
    {
        return new EraValidator(
            $json['era_id'],
            ValidatorWeightEntitySerializer::fromJsonArray($json['validator_weights'])
        );
    }
}
