<?php

namespace Casper\Types\Serializer;

use Casper\Types\CLValue\CLPublicKey;
use Casper\Types\ValidatorChanges;

class ValidatorChangesSerializer extends JsonSerializer
{
    /**
     * @param ValidatorChanges $validatorChanges
     */
    public static function toJson($validatorChanges): array
    {
        return array(
            'public_key' => $validatorChanges->getPublicKey()->toHex(),
            'status_changes' => $validatorChanges->getStatusChanges()
        );
    }

    public static function fromJson(array $json): ValidatorChanges
    {
        return new ValidatorChanges(
            CLPublicKey::fromHex($json['public_key']),
            $json['status_changes']
        );
    }
}
