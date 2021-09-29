<?php

namespace Casper\Entity;

use Casper\CLType\CLValue;

//TODO: Add all fields to StoredValue object (CLValue, ContractWASM, Contract, ContractPackage, Transfer, DeployInfo)
class StoredValue
{
    private ?Account $Account = null;

    private ?EraInfo $EraInfo = null;

    /**
     * @param ?Account $Account
     * @param ?EraInfo $EraInfo
     */
    public function __construct(?Account $Account, ?EraInfo $EraInfo)
    {
        $this->Account = $Account;
        $this->EraInfo = $EraInfo;
    }

    public function getAccount(): ?Account
    {
        return $this->Account;
    }

    public function getEraInfo(): ?EraInfo
    {
        return $this->EraInfo;
    }
}
