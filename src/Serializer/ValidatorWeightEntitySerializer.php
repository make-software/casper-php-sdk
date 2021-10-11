<?php

namespace Casper\Serializer;

use Casper\Entity\ValidatorWeight;

class ValidatorWeightEntitySerializer extends EntitySerializer
{
    /**
     * @param ValidatorWeight $validatorWeight
     * @return array
     */
    public static function toJson($validatorWeight): array
    {
        return array(
            'public_key' => $validatorWeight->getPublicKey(),
            'weight' => (string) $validatorWeight->getWeight(),
        );
    }

    public static function fromJson(array $json): ValidatorWeight
    {
        return new ValidatorWeight(
            $json['public_key'],
            gmp_init($json['weight'])
        );
    }
}
