<?php

namespace Casper\Serializer;

use Casper\Entity\DeployApproval;

class DeployApprovalJsonSerializer extends JsonSerializer
{
    /**
     * @param DeployApproval $deployApproval
     */
    public static function toJson($deployApproval): array
    {
        return [
            'signer' => CLPublicKeyStringSerializer::toString($deployApproval->getSigner()),
            'signature' => $deployApproval->getSignature(),
        ];
    }

    public static function fromJson(array $json): DeployApproval
    {
        return new DeployApproval(
            CLPublicKeyStringSerializer::fromString($json['signer']),
            $json['signature']
        );
    }
}
