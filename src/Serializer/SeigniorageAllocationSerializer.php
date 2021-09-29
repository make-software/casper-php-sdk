<?php

namespace Casper\Serializer;

use Casper\Entity\SeigniorageAllocation;
use Casper\Entity\SeigniorageAllocationDelegator;
use Casper\Entity\SeigniorageAllocationValidator;

class SeigniorageAllocationSerializer extends Serializer
{
    /**
     * @param SeigniorageAllocation $seigniorageAllocation
     * @return array
     */
    public static function toJson($seigniorageAllocation): array
    {
        // TODO: Implement toJson() method.
        return [];
    }

    public static function fromJson(array $json): SeigniorageAllocation
    {
        $delegatorJson = $json['Delegator'] ?? null;
        $validatorJson = $json['Validator'] ?? null;

        if ($delegatorJson) {
            $delegator = new SeigniorageAllocationDelegator(
                $delegatorJson['delegator_public_key'],
                $delegatorJson['validator_public_key'],
                gmp_init($delegatorJson['amount'])
            );
        }

        if ($validatorJson) {
            $validator = new SeigniorageAllocationValidator(
                $validatorJson['validator_public_key'],
                gmp_init($validatorJson['amount'])
            );
        }

        return new SeigniorageAllocation(
            $delegator ?? null,
            $validator ?? null
        );
    }
}
