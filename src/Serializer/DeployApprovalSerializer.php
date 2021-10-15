<?php

namespace Casper\Serializer;

use Casper\Entity\DeployApproval;

class DeployApprovalSerializer extends JsonSerializer
{
    /**
     * @param DeployApproval $deployApproval
     */
    public static function toJson($deployApproval): array
    {
        return [
            'signer' => CLPublicKeySerializer::toHex($deployApproval->getSigner()),
            'signature' => $deployApproval->getSignature(),
        ];
    }

    public static function fromJson(array $json): DeployApproval
    {
        return new DeployApproval(
            CLPublicKeySerializer::fromHex($json['signer']),
            $json['signature']
        );
    }
}
