<?php

namespace Casper\Types\CLValue;

use Casper\Types\CLValue\CLType\CLOptionType;
use Casper\Types\CLValue\CLType\CLType;

final class CLOption extends CLValue
{
    private const NONE = 0;
    private const SOME = 1;

    private CLType $innerType;

    /**
     * @param CLValue|null $data  Can be null that equals "None", or some CLValue that equals to "Some" (See: https://doc.rust-lang.org/std/option/)
     * @param CLType|null $innerType
     * @throws \Exception
     */
    public function __construct(?CLValue $data, ?CLType $innerType = null)
    {
        $this->data = $data;

        if ($data === null && $innerType === null) {
            throw new \Exception('You had to assign innerType for None');
        }
        else if ($data === null && $innerType !== null) {
            $this->innerType = $innerType;
        }
        else {
            $this->innerType = $data->clType();
        }
    }

    /**
     * @throws \Exception
     */
    public static function fromBytesWithRemainder(array $bytes, ?CLType $innerType = null): CLValueWithRemainder
    {
        $u8Result = CLU8::fromBytesWithRemainder($bytes);
        $optionTag = (int) $u8Result->getClValue()->value();

        if ($optionTag === self::NONE) {
            $value = new self(null, $innerType);
        }
        else if ($optionTag === self::SOME) {
            if (!$u8Result->getRemainder()) {
                self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_EARLY_END_OF_STREAM);
            }

            $clValueClass = $innerType->getLinkTo();
            $value = new self($clValueClass::fromBytes($u8Result->getRemainder()));
        }

        if (isset($value)) {
            return new CLValueWithRemainder($value, []);
        }

        self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_FORMATTING);
    }

    public function value(): ?CLValue
    {
        return $this->data;
    }

    public function clType(): CLOptionType
    {
        return new CLOptionType($this->innerType);
    }

    public function toBytes(): array
    {
        return $this->data === null
            ? [self::NONE]
            : array_merge([self::SOME], $this->data->toBytes());
    }

    public function parsedValue()
    {
        return $this->data === null ? '' : $this->data->parsedValue();
    }
}
