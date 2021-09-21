<?php

namespace Casper\CLType;

use Casper\Util\ByteUtil;

class CLByteArray extends CLValue
{
    protected const CL_BYTE_ARRAY_MAX_LENGTH = 32;

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
            $message = 'Incorrect byte array: ' . join(',', $byteArray);
        }
        elseif ($length = count($byteArray) > self::CL_BYTE_ARRAY_MAX_LENGTH) {
            $message = 'Provided value has length ' . $length . ' which exceeded the limit ' . self::CL_BYTE_ARRAY_MAX_LENGTH;
        }

        if (isset($message)) {
            throw new \Exception($message);
        }
    }

    /**
     * @return int[]
     */
    public function value(): array
    {
        return $this->data;
    }

    public function clType(): CLType
    {
        return new CLByteArrayType(count($this->data));
    }

    /**
     * @return int[]
     */
    public function toBytes(): array
    {
        return $this->data;
    }
}
