<?php

namespace Casper\Serializer;

use Casper\Entity\SeigniorageAllocation;
use Casper\Entity\SeigniorageAllocationDelegator;
use Casper\Entity\SeigniorageAllocationValidator;

class SeigniorageAllocationSerializer extends JsonSerializer
{
    /**
     * @param SeigniorageAllocation $seigniorageAllocation
     */
    public static function toJson($seigniorageAllocation): array
    {
        if ($delegator = $seigniorageAllocation->getDelegator()) {
            $result['Delegator'] = array(
                'delegator_public_key' => CLPublicKeySerializer::toHex($delegator->getDelegatorPublicKey()),
                'validator_public_key' => CLPublicKeySerializer::toHex($delegator->getValidatorPublicKey()),
                'amount' => (string) $delegator->getAmount(),
            );
        }

        if ($validator = $seigniorageAllocation->getValidator()) {
            $result['Validator'] = array(
                'validator_public_key' => CLPublicKeySerializer::toHex($validator->getValidatorPublicKey()),
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
                CLPublicKeySerializer::fromHex($delegatorJson['delegator_public_key']),
                CLPublicKeySerializer::fromHex($delegatorJson['validator_public_key']),
                gmp_init($delegatorJson['amount'])
            );
        }

        if ($validatorJson) {
            $validator = new SeigniorageAllocationValidator(
                CLPublicKeySerializer::fromHex($validatorJson['validator_public_key']),
                gmp_init($validatorJson['amount'])
            );
        }

        return new SeigniorageAllocation(
            $delegator ?? null,
            $validator ?? null
        );
    }
}
