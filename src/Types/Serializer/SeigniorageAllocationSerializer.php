<?php

namespace Casper\Types\Serializer;

use Casper\Types\CLValue\CLPublicKey;
use Casper\Types\SeigniorageAllocation;
use Casper\Types\SeigniorageAllocationDelegator;
use Casper\Types\SeigniorageAllocationValidator;

class SeigniorageAllocationSerializer extends JsonSerializer
{
    /**
     * @param SeigniorageAllocation $seigniorageAllocation
     */
    public static function toJson($seigniorageAllocation): array
    {
        if ($delegator = $seigniorageAllocation->getDelegator()) {
            $result['Delegator'] = array(
                'delegator_public_key' => $delegator->getDelegatorPublicKey()->toHex(),
                'validator_public_key' => $delegator->getValidatorPublicKey()->toHex(),
                'amount' => (string) $delegator->getAmount(),
            );
        }

        if ($validator = $seigniorageAllocation->getValidator()) {
            $result['Validator'] = array(
                'validator_public_key' => $validator->getValidatorPublicKey()->toHex(),
                'amount' => (string) $validator->getAmount(),
            );
        }

        return $result ?? [];
    }

    public static function fromJson(array $json): SeigniorageAllocation
    {
        $delegatorJson = $json['Delegator'] ?? null;
        $validatorJson = $json['Validator'] ?? null;

        if ($delegatorJson) {
            $delegator = new SeigniorageAllocationDelegator(
                CLPublicKey::fromHex($delegatorJson['delegator_public_key']),
                CLPublicKey::fromHex($delegatorJson['validator_public_key']),
                gmp_init($delegatorJson['amount'])
            );
        }

        if ($validatorJson) {
            $validator = new SeigniorageAllocationValidator(
                CLPublicKey::fromHex($validatorJson['validator_public_key']),
                gmp_init($validatorJson['amount'])
            );
        }

        return new SeigniorageAllocation(
            $delegator ?? null,
            $validator ?? null
        );
    }
}
