<?php

namespace Casper\Serializer;

use Casper\Entity\SeigniorageAllocation;
use Casper\Entity\SeigniorageAllocationDelegator;
use Casper\Entity\SeigniorageAllocationValidator;

class SeigniorageAllocationJsonSerializer extends JsonSerializer
{
    /**
     * @param SeigniorageAllocation $seigniorageAllocation
     */
    public static function toJson($seigniorageAllocation): array
    {
        if ($delegator = $seigniorageAllocation->getDelegator()) {
            $result['Delegator'] = array(
                'delegator_public_key' => CLPublicKeyStringSerializer::toString($delegator->getDelegatorPublicKey()),
                'validator_public_key' => CLPublicKeyStringSerializer::toString($delegator->getValidatorPublicKey()),
                'amount' => (string) $delegator->getAmount(),
            );
        }

        if ($validator = $seigniorageAllocation->getValidator()) {
            $result['Validator'] = array(
                'validator_public_key' => CLPublicKeyStringSerializer::toString($validator->getValidatorPublicKey()),
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
                CLPublicKeyStringSerializer::fromString($delegatorJson['delegator_public_key']),
                CLPublicKeyStringSerializer::fromString($delegatorJson['validator_public_key']),
                gmp_init($delegatorJson['amount'])
            );
        }

        if ($validatorJson) {
            $validator = new SeigniorageAllocationValidator(
                CLPublicKeyStringSerializer::fromString($validatorJson['validator_public_key']),
                gmp_init($validatorJson['amount'])
            );
        }

        return new SeigniorageAllocation(
            $delegator ?? null,
            $validator ?? null
        );
    }
}
