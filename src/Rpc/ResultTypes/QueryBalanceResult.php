<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\CLValue\CLU512;

class QueryBalanceResult extends AbstractResult
{
    private CLU512 $balance;

    public static function fromJSON(array $json): self
    {
        return new self($json, new CLU512($json['balance']));
    }

    public function __construct(array $rawJSON, CLU512 $balance)
    {
        parent::__construct($rawJSON);
        $this->balance = $balance;
    }

    public function getBalance(): CLU512
    {
        return $this->balance;
    }
}
