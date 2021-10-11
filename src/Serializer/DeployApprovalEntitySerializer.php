<?php

namespace Casper\Serializer;

use Casper\Entity\DeployApproval;

class DeployApprovalEntitySerializer extends EntitySerializer
{
    /**
     * @param DeployApproval $deployApproval
     * @return array
     */
    public static function toJson($deployApproval): array
    {
        return [
            'signer' => $deployApproval->getSigner(),
            'signature' => $deployApproval->getSignature(),
        ];
    }

    public static function fromJson(array $json): DeployApproval
    {
        return new DeployApproval(
            $json['signer'],
            $json['signature']
        );
    }
}
