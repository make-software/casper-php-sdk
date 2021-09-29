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
        // TODO: Implement toJson() method.
        return [];
    }

    public static function fromJson(array $json): EraValidator
    {
        return new EraValidator(
            $json['era_id'],
            ValidatorWeightSerializer::fromArray($json['validator_weights'])
        );
    }
}
