<?php

namespace Casper\CLType;

final class CLResult extends CLValue
{
    public const RESULT_ERR = 0;
    public const RESULT_OK = 1;

    private int $result;

    private CLType $innerOk;

    private CLType $innerErr;

    /**
     * @throws \Exception
     */
    public function __construct(int $result, CLValue $value, CLType $innerOk, CLType $innerErr)
    {
        $this->assertResultIsValid($result);

        $this->result = $result;
        $this->data = $value;
        $this->innerOk = $innerOk;
        $this->innerErr  = $innerErr;
    }

    /**
     * @param array $bytes
     * @param CLResultType|null $clResultType
     * @return CLValueWithRemainder
     * @throws \Exception
     */
    public static function fromBytesWithRemainder(array $bytes, ?CLType $clResultType = null): CLValueWithRemainder
    {
        $u8Result = CLU8::fromBytesWithRemainder($bytes);

        if (!$remainder = $u8Result->getRemainder()) {
            self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_EARLY_END_OF_STREAM);
        }

        $tag = (int) $u8Result->getClValue()->value();

        if (!in_array($tag, [self::RESULT_ERR, self::RESULT_OK]) || !$clResultType instanceof CLResultType) {
            self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_FORMATTING);
        }

        $innerClType = $tag === self::RESULT_ERR
            ? $clResultType->getInnerErr()
            : $clResultType->getInnerOk();

        $clValueClass = $innerClType->getLinkTo();
        $value = $clValueClass::fromBytesWithRemainder($remainder, $innerClType);

        return new CLValueWithRemainder(
            new self($tag, $value->getClValue(), $clResultType->getInnerOk(), $clResultType->getInnerErr()),
            $value->getRemainder()
        );
    }

    public function value(): CLValue
    {
        return $this->data;
    }

    public function result(): int
    {
        return $this->result;
    }

    public function isError(): bool
    {
        return $this->result === self::RESULT_ERR;
    }

    public function isOk(): bool
    {
        return $this->result === self::RESULT_OK;
    }

    public function clType(): CLType
    {
        return new CLResultType($this->innerOk, $this->innerErr);
    }

    public function toBytes(): array
    {
        return array_merge([$this->result], $this->data->toBytes());
    }

    public function parsedValue(): string
    {
        // TODO: Implement parsedValue() method.
        return '';
    }

    /**
     * @throws \Exception
     */
    private function assertResultIsValid(int $result): void
    {
        if (!in_array($result, [self::RESULT_ERR, self::RESULT_OK])) {
            throw new \Exception('Invalid result value');
        }
    }
}

