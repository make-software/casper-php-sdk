<?php

namespace Casper\CLType;

final class CLPublicKeyTag
{
    public const ED25519 = 1;
    public const SECP256K1 = 2;

    private const TAGS = [
        self::ED25519,
        self::SECP256K1,
    ];

    private const TAG_NAME_MAP = array(
        self::ED25519 => 'ED25519',
        self::SECP256K1 => 'SECP256K1',
    );

    private int $tagValue;

    public function __construct(int $tagValue)
    {
        if (!in_array($tagValue, self::TAGS)) {
            throw new \Exception($tagValue . ' is invalid CLPublicKeyTag tag. Available tags: ' . join(', ', self::TAGS));
        }

        $this->tagValue = $tagValue;
    }

    public function getTagValue(): int
    {
        return $this->tagValue;
    }

    public function getTagName(): string
    {
        return self::TAG_NAME_MAP[$this->getTagValue()];
    }
}
