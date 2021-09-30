<?php

namespace Casper\Entity;

use Casper\CLType\CLValue;

//TODO: Add all fields to StoredValue object (ContractWASM, Contract, ContractPackage, Transfer, DeployInfo)
class StoredValue
{
    private ?CLValue $CLValue = null;

    private ?Account $Account = null;

    private ?EraInfo $EraInfo = null;

    /**
     * @param ?CLValue $CLValue
     * @param ?Account $Account
     * @param ?EraInfo $EraInfo
     */
    public function __construct(
        ?CLValue $CLValue,
        ?Account $Account,
        ?EraInfo $EraInfo
    )
    {
        $this->CLValue = $CLValue;
        $this->Account = $Account;
        $this->EraInfo = $EraInfo;
    }

    public function getCLValue(): ?CLValue
    {
        return $this->CLValue;
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
