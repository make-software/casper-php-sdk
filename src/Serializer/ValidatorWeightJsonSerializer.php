<?php

namespace Casper\Serializer;

use Casper\Entity\ValidatorWeight;

class ValidatorWeightJsonSerializer extends JsonSerializer
{
    /**
     * @param ValidatorWeight $validatorWeight
     */
    public static function toJson($validatorWeight): array
    {
        return array(
            'public_key' => CLPublicKeyStringSerializer::toHex($validatorWeight->getPublicKey()),
            'weight' => (string) $validatorWeight->getWeight(),
        );
    }

    public static function fromJson(array $json): ValidatorWeight
    {
        return new ValidatorWeight(
            CLPublicKeyStringSerializer::fromHex($json['public_key']),
            gmp_init($json['weight'])
        );
    }
}
