<?php

namespace Casper\Types\Serializer;

use Casper\Types\Approval;
use Casper\Types\CLValue\CLPublicKey;

class ApprovalSerializer extends JsonSerializer
{
    /**
     * @param Approval $deployApproval
     */
    public static function toJson($deployApproval): array
    {
        return [
            'signer' => $deployApproval->getSigner()->toHex(),
            'signature' => $deployApproval->getSignature(),
        ];
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): Approval
    {
        return new Approval(
            CLPublicKey::fromHex($json['signer']),
            $json['signature']
        );
    }
}
