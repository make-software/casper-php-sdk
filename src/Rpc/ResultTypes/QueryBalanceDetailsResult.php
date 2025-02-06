<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\CLValue\CLU512;

class QueryBalanceDetailsResult extends AbstractResult
{
    private CLU512 $totalBalance;

    private CLU512 $availableBalance;

    private string $totalBalanceProof;

    private array $holds;

    public static function fromJSON(array $json): self
    {
        return new self(
            $json,
            new CLU512($json['total_balance']),
            new CLU512($json['available_balance']),
            $json['total_balance_proof'],
            $json['holds']
        );
    }

    public function __construct(
        array $rawJSON,
        CLU512 $totalBalance,
        CLU512 $availableBalance,
        string $totalBalanceProof,
        array $holds
    )
    {
        parent::__construct($rawJSON);
        $this->totalBalance = $totalBalance;
        $this->availableBalance = $availableBalance;
        $this->totalBalanceProof = $totalBalanceProof;
        $this->holds = $holds;
    }

    public function getTotalBalance(): CLU512
    {
        return $this->totalBalance;
    }

    public function getAvailableBalance(): CLU512
    {
        return $this->availableBalance;
    }

    public function getTotalBalanceProof(): string
    {
        return $this->totalBalanceProof;
    }

    public function getHolds(): array
    {
        return $this->holds;
    }
}
