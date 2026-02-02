<?php

namespace Casper\Types\Serializer;

use Casper\Types\CLValue\CLPublicKey;
use Casper\Types\CLValue\CLURef;
use Casper\Types\Delegator;

class DelegatorSerializer extends JsonSerializer
{
    private static function normalizePublicKey($value): ?string
    {
        if (is_string($value)) {
            return $value;
        }
        if (is_array($value)) {
            return $value['PublicKey'] ?? $value['public_key'] ?? null;
        }

        return null;
    }

    /**
     * @param Delegator $delegator
     */
    public static function toJson($delegator): array
    {
        return array(
            'public_key' => $delegator->getPublicKey()->toHex(),
            'staked_amount' => (string) $delegator->getStakedAmount(),
            'bonding_purse' => $delegator->getBondingPurse()->parsedValue(),
            'delegatee' => $delegator->getDelegatee()->toHex(),
        );
    }

    public static function fromJson(array $json): Delegator
    {
        $publicKeyHex = self::normalizePublicKey($json['public_key'] ?? $json['delegator_public_key'] ?? $json['delegator'] ?? null);
        $delegateeHex = self::normalizePublicKey($json['delegatee'] ?? $json['validator_public_key'] ?? $json['validator'] ?? null);
        $stakedAmount = $json['staked_amount'] ?? $json['bonding_amount'] ?? '0';
        $bondingPurse = $json['bonding_purse'] ?? $json['bonding_purse_uref'] ?? null;

        if (is_array($bondingPurse)) {
            $bondingPurse = $bondingPurse['URef'] ?? $bondingPurse['uref'] ?? null;
        }

        if (null === $publicKeyHex || null === $delegateeHex || '' === $bondingPurse) {
            throw new \RuntimeException('Invalid delegator data: missing required fields');
        }

        return new Delegator(
            CLPublicKey::fromHex($publicKeyHex),
            gmp_init($stakedAmount),
            CLURef::fromString($bondingPurse),
            CLPublicKey::fromHex($delegateeHex)
        );
    }

    public static function fromJsonArray(array $array): array
    {
        $result = [];

        foreach ($array as $item) {
            if (!is_array($item)) {
                continue;
            }
            try {
                $result[] = self::fromJson($item);
            } catch (\RuntimeException $e) {
                continue;
            }
        }

        return $result;
    }
}
