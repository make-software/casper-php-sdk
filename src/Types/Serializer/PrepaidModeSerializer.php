<?php

namespace Casper\Types\Serializer;

use Casper\Types\PrepaidMode;

class PrepaidModeSerializer extends JsonSerializer
{
    /**
     * @param PrepaidMode $prepaidMode
     */
    public static function toJson($prepaidMode): array
    {
        return array('receipt' => $prepaidMode->getReceipt());
    }

    public static function fromJson(array $json): PrepaidMode
    {
        return new PrepaidMode($json['receipt']);
    }
}
