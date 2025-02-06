<?php

namespace Casper\Types;

class PricingMode
{
    private ?PaymentLimitedMode $paymentLimitedMode;

    private ?FixedMode $fixed;

    private ?PrepaidMode $prepaid;

    public function __construct(?PaymentLimitedMode $paymentLimitedMode, ?FixedMode $fixed, ?PrepaidMode $prepaid)
    {
        $this->paymentLimitedMode = $paymentLimitedMode;
        $this->fixed = $fixed;
        $this->prepaid = $prepaid;
    }

    public function getPaymentLimitedMode(): ?PaymentLimitedMode
    {
        return $this->paymentLimitedMode;
    }

    public function getFixed(): ?FixedMode
    {
        return $this->fixed;
    }

    public function getPrepaid(): ?PrepaidMode
    {
        return $this->prepaid;
    }
}
