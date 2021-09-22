<?php

namespace Casper\CLType;

use Casper\Util\ByteUtil;

final class CLAccountHash extends CLValue
{
    /**
     * @param int[] $byteArray
     * @throws \Exception
     */
    public function __construct(array $byteArray)
    {
        $this->assertByteArrayIsValid($byteArray);
        $this->data = $byteArray;
    }

    /**
     * @param int[] $byteArray
     * @throws \Exception
     */
    private function assertByteArrayIsValid(array $byteArray): void
    {
        if (!ByteUtil::isByteArray($byteArray)) {
            throw new \Exception('Incorrect byte array: ' . join(',', $byteArray));
        }
    }

    public function value(): array
    {
        return $this->data;
    }

    public function clType(): CLAccountHashType
    {
        return new CLAccountHashType();
    }

    public function toBytes(): array
    {
        return $this->data;
    }
}
