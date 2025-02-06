<?php

namespace Casper\Types\Serializer;

use Casper\Types\CLValue\CLPublicKey;
use Casper\Types\ValidatorWeight;

class ValidatorWeightSerializer extends JsonSerializer
{
    /** @param ValidatorWeight $validatorWeight  */
    public static function toJson($validatorWeight): array
    {
        return array(
            'public_key' => $validatorWeight->getPublicKey()->toHex(),
            'weight' => (string) $validatorWeight->getWeight(),
        );
    }

    public static function fromJson(array $json): ValidatorWeight
    {
        return new ValidatorWeight(
            CLPublicKey::fromHex($json['public_key']),
            gmp_init($json['weight'])
        );
    }
}
