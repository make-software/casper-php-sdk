<?php

namespace Casper\Entity;

use Casper\CLType\CLValue;

//TODO: Add all fields to StoredValue object (Contract, ContractPackage, Transfer, DeployInfo)
class StoredValue
{
    private ?CLValue $cLValue;

    private ?Account $account;

    private ?string $contractWASM;

    private ?EraInfo $eraInfo;

    /**
     * @param ?CLValue $cLValue
     * @param ?Account $account
     * @param string|null $contractWASM
     * @param ?EraInfo $eraInfo
     */
    public function __construct(
        ?CLValue $cLValue,
        ?Account $account,
        ?string  $contractWASM,
        ?EraInfo $eraInfo
    )
    {
        $this->cLValue = $cLValue;
        $this->account = $account;
        $this->contractWASM = $contractWASM;
        $this->eraInfo = $eraInfo;
    }

    public function getCLValue(): ?CLValue
    {
        return $this->cLValue;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function getContractWASM(): ?string
    {
        return $this->contractWASM;
    }

    public function getEraInfo(): ?EraInfo
    {
        return $this->eraInfo;
    }
}
