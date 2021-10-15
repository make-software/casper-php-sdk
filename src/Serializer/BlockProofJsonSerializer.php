<?php

namespace Casper\Serializer;

use Casper\Entity\BlockProof;

class BlockProofJsonSerializer extends JsonSerializer
{
    /**
     * @param BlockProof $blockProof
     */
    public static function toJson($blockProof): array
    {
        return array(
            'public_key' => CLPublicKeyStringSerializer::toHex($blockProof->getPublicKey()),
            'signature' => $blockProof->getSignature(),
        );
    }

    public static function fromJson(array $json): BlockProof
    {
        return new BlockProof(
            CLPublicKeyStringSerializer::fromHex($json['public_key']),
            $json['signature']
        );
    }
}
