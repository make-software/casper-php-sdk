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
        return array(
            'account_hash' => $account->getAccountHash(),
            'main_purse' => $account->getMainPurse(),
            'named_keys' => NamedKeySerializer::toJsonArray($account->getNamedKeys()),
            'associated_keys' => AssociatedKeySerializer::toJsonArray($account->getAssociatedKeys()),
            'action_thresholds' => ActionThresholdsSerializer::toJson($account->getActionThresholds()),
        );
    }

    public static function fromJson(array $json): Account
    {
        return new Account(
            $json['account_hash'],
            $json['main_purse'],
            NamedKeySerializer::fromJsonArray($json['named_keys']),
            AssociatedKeySerializer::fromJsonArray($json['associated_keys']),
            ActionThresholdsSerializer::fromJson($json['action_thresholds'])
        );
    }
}
