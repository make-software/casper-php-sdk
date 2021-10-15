<?php

namespace Casper\Serializer;

use Casper\Entity\ValidatorWeight;

class ValidatorWeightSerializer extends JsonSerializer
{
    /**
     * @param ValidatorWeight $validatorWeight
     */
    public static function toJson($validatorWeight): array
    {
        return array(
            'public_key' => CLPublicKeySerializer::toHex($validatorWeight->getPublicKey()),
            'weight' => (string) $validatorWeight->getWeight(),
        );
    }

    public static function fromJson(array $json): ValidatorWeight
    {
        return new ValidatorWeight(
            CLPublicKeySerializer::fromHex($json['public_key']),
            gmp_init($json['weight'])
        );
    }
}
