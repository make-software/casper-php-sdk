<?php

namespace Casper\Types;

class BlockTransaction
{
    const CATEGORY_MINT = 0;
    const CATEGORY_AUCTION = 1;
    const CATEGORY_INSTALL_UPGRADE = 2;
    const CATEGORY_LARGE = 4;
    const CATEGORY_MEDIUM = 5;
    const CATEGORY_SMALL = 6;
    const CATEGORIES = [
        self::CATEGORY_MINT,
        self::CATEGORY_AUCTION,
        self::CATEGORY_INSTALL_UPGRADE,
        self::CATEGORY_LARGE,
        self::CATEGORY_MEDIUM,
        self::CATEGORY_SMALL,
    ];

    const VERSION_V1 = 'Version1';
    const VERSION_DEPLOY = 'Deploy';
    const VERSIONS = [
        self::VERSION_V1,
        self::VERSION_DEPLOY,
    ];

    private int $category;

    private string $version;

    private string $hash;

    public function __construct(int $category, string $version, string $hash)
    {
        $this->category = $category;
        $this->version = $version;
        $this->hash = $hash;
    }

    public function getCategory(): int
    {
        return $this->category;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getHash(): string
    {
        return $this->hash;
    }
}
