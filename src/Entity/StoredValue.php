<?php

namespace Casper\Entity;

use Casper\CLType\CLValue;

//TODO: Add all fields to StoredValue object (CLValue, ContractWASM, Contract, ContractPackage, Transfer, DeployInfo, EraInfo)
class StoredValue
{
    private ?Account $Account = null;

    /**
     * @param Account|null $Account
     */
    public function __construct(?Account $Account)
    {
        $this->Account = $Account;
    }

    public function getAccount(): ?Account
    {
        return $this->Account;
    }
}
