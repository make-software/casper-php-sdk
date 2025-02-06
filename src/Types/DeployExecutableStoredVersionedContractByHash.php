<?php

namespace Casper\Types;

use Casper\Util\ByteUtil;

use Casper\Types\CLValue\CLOption;
use Casper\Types\CLValue\CLU32;
use Casper\Types\CLValue\CLType\CLU32Type;

final class DeployExecutableStoredVersionedContractByHash extends DeployExecutableStoredContractByHash
{
    protected const TAG = 3;

    protected ?int $version;

    public function __construct(string $hash, string $entryPoint, ?int $version)
    {
        parent::__construct($hash, $entryPoint);
        $this->version = $version;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * @throws \Exception
     */
    public function toBytes(): array
    {
        $serializedVersion = $this->version
            ? new CLOption(new CLU32($this->version))
            : new CLOption(null, new CLU32Type());

        return array_merge(
            [self::TAG],
            ByteUtil::hexToByteArray($this->hash),
            $serializedVersion->toBytes(),
            ByteUtil::stringToBytesU32($this->entryPoint),
            ByteUtil::vectorToBytesU32($this->args)
        );
    }
}
