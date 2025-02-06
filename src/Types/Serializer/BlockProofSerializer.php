<?php

namespace Casper\Types\Serializer;

use Casper\Types\BlockProof;
use Casper\Types\CLValue\CLPublicKey;

class BlockProofSerializer extends JsonSerializer
{
    /**
     * @param BlockProof $blockProof
     */
    public static function toJson($blockProof): array
    {
        return array(
            'public_key' => $blockProof->getPublicKey()->toHex(),
            'signature' => $blockProof->getSignature(),
        );
    }

    public static function fromJson(array $json): BlockProof
    {
        return new BlockProof(
            CLPublicKey::fromHex($json['public_key']),
            $json['signature']
        );
    }
}
