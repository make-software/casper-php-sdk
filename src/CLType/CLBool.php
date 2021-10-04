<?php

namespace Casper\CLType;

final class CLBool extends CLValue
{
    public function __construct(bool $data)
    {
        $this->data = $data;
    }

    /**
     * @param int[] $bytes
     * @throws \Exception
     */
    public static function fromBytesWithRemainder(array $bytes, ?CLType $innerType = null): CLValueWithRemainder
    {
        if (count($bytes) < 1) {
            self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_EARLY_END_OF_STREAM);
        }

        return new CLValueWithRemainder(new self((bool) $bytes[0]), array_slice($bytes, 1));
    }

    public function value(): bool
    {
        return $this->data;
    }

    public function clType(): CLBoolType
    {
        return new CLBoolType();
    }

    public function toBytes(): array
    {
        return [(int) $this->data];
    }

    public function toString(): string
    {
        return (string)(int) $this->data;
    }
}
