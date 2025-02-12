<?php

namespace Casper\Types\Serializer;

use Casper\Types\Account;
use Casper\Types\CLValue\CLAccountHash;
use Casper\Types\CLValue\CLURef;

class AccountSerializer extends JsonSerializer
{
    /**
     * @param Account $account
     */
    public static function toJson($account): array
    {
        return array(
            'account_hash' => $account->getAccountHash()->parsedValue(),
            'main_purse' => $account->getMainPurse()->parsedValue(),
            'named_keys' => $account->getNamedKeys(),
            'associated_keys' => AssociatedKeySerializer::toJsonArray($account->getAssociatedKeys()),
            'action_thresholds' => ActionThresholdsSerializer::toJson($account->getActionThresholds()),
        );
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): Account
    {
        return new Account(
            CLAccountHash::fromString($json['account_hash']),
            CLURef::fromString($json['main_purse']),
            $json['named_keys'],
            AssociatedKeySerializer::fromJsonArray($json['associated_keys']),
            ActionThresholdsSerializer::fromJson($json['action_thresholds'])
        );
    }
}
