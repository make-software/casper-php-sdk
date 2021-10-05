<?php

namespace Casper\CLType;

use Casper\Util\ByteUtil;

final class CLMap extends CLValue
{
    /**
     * Couple CLType objects in array. Example: [CLBoolType, CLBoolType]
     * @var array
     */
    private array $refType;

    /**
     * $data array can contain couple CLValue objects in array or just couple CLType objects .
     * Example:
     *  CLValue example: [[CLBool(true), CLBool(false)]]
     *  CLType example: [CLBoolType, CLBoolType]
     *
     * @param array $data
     * @throws \Exception
     */
    public function __construct(array $data)
    {
        if ($this->isCLValueMap($data)) {
            $this->assertCLValueMapIsValid($data);

            $this->refType = [$data[0][0]->clType(), $data[0][1]->clType()];
            $this->data = $data;
        }
        elseif ($data[0] instanceof CLType && $data[1] instanceof CLType) {
            $this->refType = $data;
            $this->data = [];
        }
        else {
            throw new \Exception('Invalid data type(s) provided');
        }
    }

    /**
     * @param array $bytes
     * @param CLMapType|null $mapType
     * @return CLValueWithRemainder
     * @throws \Exception
     */
    public static function fromBytesWithRemainder(array $bytes, ?CLType $mapType = null): CLValueWithRemainder
    {
        $u32Result = CLU32::fromBytesWithRemainder($bytes);
        $size = (int) $u32Result->getClValue()->value();
        $remainder = $u32Result->getRemainder();

        if ($size === 0) {
            return new CLValueWithRemainder(
                new CLMap([$mapType->getInnerKey(), $mapType->getInnerValue()]),
                $remainder
            );
        }

        $vector = [];
        for ($i = 0; $i < $size; $i++) {
            if (!$remainder) {
                self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_EARLY_END_OF_STREAM);
            }

            $keyClass = $mapType->getInnerKey()->getLinkTo();
            $parsedKeyWithRemainder = $keyClass::fromBytesWithRemainder($remainder, $mapType->getInnerKey());

            $key = $parsedKeyWithRemainder->getClValue();
            $remainder = $parsedKeyWithRemainder->getRemainder();

            if (!$remainder) {
                self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_EARLY_END_OF_STREAM);
            }

            $valueClass = $mapType->getInnerValue()->getLinkTo();
            $parsedValueWithRemainder = $valueClass::fromBytesWithRemainder($remainder, $mapType->getInnerValue());

            $value = $parsedValueWithRemainder->getClValue();
            $remainder = $parsedValueWithRemainder->getRemainder();

            $vector[] = [$key, $value];
        }

        return new CLValueWithRemainder(new CLMap($vector), $remainder);
    }

    public function value(): array
    {
        return $this->data;
    }

    public function clType(): CLMapType
    {
        return new CLMapType($this->refType);
    }

    /**
     * @throws \Exception
     */
    public function toBytes(): array
    {
        $bytes = [];

        /** @var CLValue[] $keyValue */
        foreach ($this->data as $keyValue) {
            $bytes = array_merge($bytes, $keyValue[0]->toBytes());
            $bytes = array_merge($bytes, $keyValue[1]->toBytes());
        }

        return array_merge(
            ByteUtil::toBytesU32(count($this->data)),
            $bytes
        );
    }

    public function parsedValue(): string
    {
        // TODO: Implement parsedValue() method
        return '';
    }

    public function get(CLValue $key): ?CLValue
    {
        foreach ($this->data as $keyValue) {
            if ($keyValue[0]->value() === $key->value()) {
                return $keyValue[1];
            }
        }

        return null;
    }

    /**
     * @throws \Exception
     */
    public function set(CLValue $key, CLValue $value): void
    {
        if ($key->clType()->toString() !== $this->refType[0]->toString() ||
            $value->clType()->toString() !== $this->refType[1]->toString()
        ) {
            throw new \Exception('Invalid data provided');
        }

        foreach ($this->data as $index => $keyValue) {
            if ($keyValue[0]->value() === $key->value()) {
                $this->data[$index][1] = $value;
                return;
            }
        }

        $this->data[] = [$key, $value];
    }

    public function delete(CLValue $key): void
    {
        foreach ($this->data as $index => $keyValue) {
            if ($keyValue[0]->value() === $key->value()) {
                unset($this->data[$index]);
                $this->data = array_values($this->data);
            }
        }
    }

    public function size(): int
    {
        return count($this->data);
    }

    private function isCLValueMap(array $data): bool
    {
        return is_array($data[0]) &&
            count($data[0]) === 2 &&
            $data[0][0] instanceof CLValue &&
            $data[0][1] instanceof CLValue;
    }

    /**
     * @param array $clValueMap
     * @throws \Exception
     */
    private function assertCLValueMapIsValid(array $clValueMap): void
    {
        $refType = [$clValueMap[0][0]->clType(), $clValueMap[0][1]->clType()];

        foreach ($clValueMap as $clValuePair) {
            /**
             * @var CLValue $first
             * @var CLValue $second
             */
            $first = $clValuePair[0];
            $second = $clValuePair[1];

            if ($first->clType()->toString() !== $refType[0]->toString() || $second->clType()->toString() !== $refType[1]->toString()) {
                throw new \Exception('Invalid data provided');
            }
        }
    }
}
