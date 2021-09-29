<?php

namespace Casper\Serializer;

use Casper\Entity\ValidatorWeight;

class ValidatorWeightSerializer extends Serializer
{
    /**
     * @param ValidatorWeight $validatorWeight
     * @return array
     */
    public static function toJson($validatorWeight): array
    {
        // TODO: Implement toJson() method.
        return [];
    }

    public static function fromJson(array $json): ValidatorWeight
    {
        return new ValidatorWeight($json['public_key'], gmp_init($json['weight']));
    }
}
