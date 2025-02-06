<?php

namespace Casper\Types\Serializer;

use Casper\Types\PaymentLimitedMode;

class PaymentLimitedModeSerializer extends JsonSerializer
{
    /**
     * @param PaymentLimitedMode $paymentLimitedMode
     */
    public static function toJson($paymentLimitedMode): array
    {
        return array(
            'payment_amount' => gmp_strval($paymentLimitedMode->getPaymentAmount()),
            'gas_price_tolerance' => gmp_strval($paymentLimitedMode->getGasPriceTolerance()),
            'standard_payment' => $paymentLimitedMode->isStandardPayment(),
        );
    }

    public static function fromJson(array $json): PaymentLimitedMode
    {
        return new PaymentLimitedMode(
            gmp_init($json['payment_amount']),
            gmp_init($json['gas_price_tolerance']),
            $json['standard_payment']
        );
    }
}
