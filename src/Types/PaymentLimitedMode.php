<?php

namespace Casper\Types;

class PaymentLimitedMode
{
    private \GMP $paymentAmount;

    private \GMP $gasPriceTolerance;

    private bool $standardPayment;

    public function __construct(\GMP $paymentAmount, \GMP $gasPriceTolerance, bool $standardPayment)
    {
        $this->paymentAmount = $paymentAmount;
        $this->gasPriceTolerance = $gasPriceTolerance;
        $this->standardPayment = $standardPayment;
    }

    public function getPaymentAmount(): \GMP
    {
        return $this->paymentAmount;
    }

    public function getGasPriceTolerance(): \GMP
    {
        return $this->gasPriceTolerance;
    }

    public function isStandardPayment(): bool
    {
        return $this->standardPayment;
    }
}
