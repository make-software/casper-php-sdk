<?php

namespace Casper\Serializer;

use Casper\Entity\Account;

class AccountEntitySerializer extends EntitySerializer
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
            'named_keys' => NamedKeyEntitySerializer::toJsonArray($account->getNamedKeys()),
            'associated_keys' => AssociatedKeyEntitySerializer::toJsonArray($account->getAssociatedKeys()),
            'action_thresholds' => ActionThresholdsEntitySerializer::toJson($account->getActionThresholds()),
        );
    }

    public static function fromJson(array $json): Account
    {
        return new Account(
            $json['account_hash'],
            $json['main_purse'],
            NamedKeyEntitySerializer::fromJsonArray($json['named_keys']),
            AssociatedKeyEntitySerializer::fromJsonArray($json['associated_keys']),
            ActionThresholdsEntitySerializer::fromJson($json['action_thresholds'])
        );
    }
}
