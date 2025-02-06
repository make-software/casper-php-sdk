<?php

namespace Casper\Types\Serializer;

use Casper\Types\PricingMode;

class PricingModeSerializer extends JsonSerializer
{
    /**
     * @param PricingMode $pricingMode
     * @throws \Exception
     */
    public static function toJson($pricingMode): array
    {
        if ($pricingMode->getPaymentLimitedMode()) {
            return array(
                'PaymentLimited' => PaymentLimitedModeSerializer::toJson($pricingMode->getPaymentLimitedMode()),
            );
        }
        else if ($pricingMode->getFixed()) {
            return array(
                'Fixed' => FixedModeSerializer::toJson($pricingMode->getFixed()),
            );
        }
        else if ($pricingMode->getPrepaid()) {
            return array (
                'Prepaid' => PrepaidModeSerializer::toJson($pricingMode->getPrepaid()),
            );
        }

        throw new \Exception('Unable to deserialize PricingMode');
    }

    public static function fromJson(array $json): PricingMode
    {
        return new PricingMode(
            isset($json['PaymentLimited']) ? PaymentLimitedModeSerializer::fromJson($json['PaymentLimited']) : null,
            isset($json['Fixed']) ? FixedModeSerializer::fromJson($json['Fixed']) : null,
            isset($json['Prepaid']) ? PrepaidModeSerializer::fromJson($json['Prepaid']) : null,
        );
    }
}
