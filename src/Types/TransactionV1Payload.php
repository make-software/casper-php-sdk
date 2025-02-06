<?php

namespace Casper\Types;

class TransactionV1Payload
{
    private InitiatorAddr $initiatorAddr;

    private int $timestamp;

    private int $ttl;

    private PricingMode $pricingMode;

    private string $chainName;

    private PayloadFields $fields;

    public function __construct(
        InitiatorAddr $initiatorAddr,
        int $timestamp,
        int $ttl,
        PricingMode $pricingMode,
        string $chainName,
        PayloadFields $fields
    )
    {
        $this->initiatorAddr = $initiatorAddr;
        $this->timestamp = $timestamp;
        $this->ttl = $ttl;
        $this->pricingMode = $pricingMode;
        $this->chainName = $chainName;
        $this->fields = $fields;
    }

    public function getInitiatorAddr(): InitiatorAddr
    {
        return $this->initiatorAddr;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getTtl(): int
    {
        return $this->ttl;
    }

    public function getPricingMode(): PricingMode
    {
        return $this->pricingMode;
    }

    public function getChainName(): string
    {
        return $this->chainName;
    }

    public function getFields(): PayloadFields
    {
        return $this->fields;
    }
}
