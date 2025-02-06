<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\CLValue\CLU512;

class StateGetBalanceResult extends AbstractResult
{
    private CLU512 $balanceValue;

    public static function fromJSON(array $json): self
    {
        return new self($json, new CLU512($json['balance_value']));
    }

    public function __construct(array $rawJSON, CLU512 $balanceValue)
    {
        parent::__construct($rawJSON);
        $this->balanceValue = $balanceValue;
    }

    public function getBalanceValue(): CLU512
    {
        return $this->balanceValue;
    }
}
