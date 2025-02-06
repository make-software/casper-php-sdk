<?php

namespace Casper\Types\Serializer;

use Casper\Types\FixedMode;

class FixedModeSerializer extends JsonSerializer
{
    /**
     * @param FixedMode $fixedMode
     */
    public static function toJson($fixedMode): array
    {
        return array(
            'gas_price_tolerance' => gmp_strval($fixedMode->getGasPriceTolerance()),
            'additional_computation_factor' => $fixedMode->getAdditionalComputationFactor(),
        );
    }

    public static function fromJson(array $json): FixedMode
    {
        return new FixedMode(
            gmp_init($json['gas_price_tolerance']),
            $json['additional_computation_factor']
        );
    }
}
