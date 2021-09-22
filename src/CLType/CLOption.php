<?php

namespace Casper\CLType;

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
        elseif ($data === null && $innerType !== null) {
            $this->innerType = $innerType;
        }
        else {
            $this->innerType = $data->clType();
        }
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
}
