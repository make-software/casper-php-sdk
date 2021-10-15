<?php

namespace Casper\Serializer;

use Casper\Entity\Account;

class AccountSerializer extends JsonSerializer
{
    /**
     * @param Account $account
     */
    public static function toJson($account): array
    {
        return array(
            'account_hash' => CLAccountHashSerializer::toString($account->getAccountHash()),
            'main_purse' => CLURefSerializer::toString($account->getMainPurse()),
            'named_keys' => $account->getNamedKeys(),
            'associated_keys' => AssociatedKeySerializer::toJsonArray($account->getAssociatedKeys()),
            'action_thresholds' => ActionThresholdsSerializer::toJson($account->getActionThresholds()),
        );
    }

    public static function fromJson(array $json): Account
    {
        return new Account(
            CLAccountHashSerializer::fromString($json['account_hash']),
            CLURefSerializer::fromString($json['main_purse']),
            $json['named_keys'],
            AssociatedKeySerializer::fromJsonArray($json['associated_keys']),
            ActionThresholdsSerializer::fromJson($json['action_thresholds'])
        );
    }
}
