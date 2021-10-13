<?php

namespace Casper\Serializer;

use Casper\Entity\Account;

class AccountJsonSerializer extends JsonSerializer
{
    /**
     * @param Account $account
     */
    public static function toJson($account): array
    {
        return array(
            'account_hash' => CLAccountHashStringSerializer::toString($account->getAccountHash()),
            'main_purse' => CLURefStringSerializer::toString($account->getMainPurse()),
            'named_keys' => $account->getNamedKeys(),
            'associated_keys' => AssociatedKeyJsonSerializer::toJsonArray($account->getAssociatedKeys()),
            'action_thresholds' => ActionThresholdsJsonSerializer::toJson($account->getActionThresholds()),
        );
    }

    public static function fromJson(array $json): Account
    {
        return new Account(
            CLAccountHashStringSerializer::fromString($json['account_hash']),
            CLURefStringSerializer::fromString($json['main_purse']),
            $json['named_keys'],
            AssociatedKeyJsonSerializer::fromJsonArray($json['associated_keys']),
            ActionThresholdsJsonSerializer::fromJson($json['action_thresholds'])
        );
    }
}
