<?php

namespace Casper\Serializer;

use Casper\Entity\BlockProof;

class BlockProofEntitySerializer extends EntitySerializer
{
    /**
     * @param BlockProof $blockProof
     * @return string[]
     */
    public static function toJson($blockProof): array
    {
        return array(
            'public_key' => $blockProof->getPublicKey(),
            'signature' => $blockProof->getSignature(),
        );
    }

    public static function fromJson(array $json): BlockProof
    {
        return new BlockProof(
            $json['public_key'],
            $json['signature']
        );
    }
}
