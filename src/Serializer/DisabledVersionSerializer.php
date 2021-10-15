<?php

namespace Casper\Serializer;

use Casper\Entity\DisabledVersion;

class DisabledVersionSerializer extends JsonSerializer
{
    /**
     * @param DisabledVersion $disabledVersion
     */
    public static function toJson($disabledVersion): array
    {
        return array(
            'protocol_version_major' => $disabledVersion->getAccessKey(),
            'contract_version' => $disabledVersion->getContractVersion(),
        );
    }

    public static function fromJson(array $json): DisabledVersion
    {
        return new DisabledVersion(
            $json['protocol_version_major'],
            $json['contract_version']
        );
    }
}
