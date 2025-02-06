<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\Account;
use Casper\Types\Serializer\AccountSerializer;

class StateGetAccountInfoResult extends AbstractResult
{
    private Account $account;

    public static function fromJSON(array $json): self
    {
        return new self($json, AccountSerializer::fromJson($json['account']));
    }

    public function __construct(array $rawJSON, Account $account)
    {
        parent::__construct($rawJSON);
        $this->account = $account;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }
}
