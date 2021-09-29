<?php

namespace Casper\Serializer;

use Casper\Entity\Account;

class AccountSerializer extends Serializer
{
    /**
     * @param Account $account
     * @return array
     */
    public static function toJson($account): array
    {
        // TODO: Implement toJson() method.
        return [];
    }

    public static function fromJson(array $json): Account
    {
        return new Account(
            $json['account_hash'],
            $json['main_purse'],
            NamedKeySerializer::fromArray($json['named_keys']),
            AssociatedKeySerializer::fromArray($json['associated_keys']),
            ActionThresholdsSerializer::fromJson($json['action_thresholds'])
        );
    }
}
