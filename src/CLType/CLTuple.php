<?php

namespace Casper\CLType;

abstract class CLTuple extends CLValue
{
    protected int $tupleSize;

    /**
     * @param int $size
     * @param CLValue[] $values
     * @throws \Exception
     */
    public function __construct(int $size, array $values)
    {
        if (count($values) > $size) {
            throw new \Exception('Too many elements');
        }

        foreach ($values as $item) {
            if (!$item instanceof CLValue) {
                throw new \Exception('Invalid data type(s) provided');
            }
        }

        $this->data = $values;
        $this->tupleSize = $size;
    }

    /**
     * @throws \Exception
     */
    public static function fromBytesWithRemainder(array $bytes, ?CLType $innerType = null): CLValueWithRemainder
    {
        if ($innerType === null) {
            self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_FORMATTING);
        }

        $values = [];
        $remainder = $bytes;

        foreach ($innerType->getInner() as $inner) {
            $clValueClass = $inner->getLinkTo();
            $result = $clValueClass::fromBytesWithRemainder($remainder);

            $remainder = $result->getRemainder();
            $values[] = $result->getClValue();
        }

        $valuesCount = count($values);
        if ($valuesCount < 1 || $valuesCount > 3) {
            self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_FORMATTING);
        }

        $clTupleClass = "Casper\CLType\CLTuple$valuesCount";
        return new CLValueWithRemainder(new $clTupleClass($values), []);
    }

    /**
     * @return CLValue[]
     */
    public function value(): array
    {
        return $this->data;
    }

    public function toBytes(): array
    {
        $result = [];

        foreach ($this->data as $item) {
            $result = array_merge($result, $item->toBytes());
        }

        return $result;
    }

    public function toString(): string
    {
        // TODO: Implement toString() method.
        return '';
    }

    public function clType(): CLType
    {
        $CLTupleTypeClass = __NAMESPACE__ . '\CLTuple' . $this->tupleSize . 'Type';

        return new $CLTupleTypeClass(array_map(function (CLValue $item) {
            return $item->clType();
        }, $this->data));
    }

    public function get(int $index): CLValue
    {
        return $this->data[$index];
    }

    /**
     * @throws \Exception
     */
    public function set(int $index, CLValue $item): void
    {
        if ($index > $this->tupleSize) {
            throw new \Exception('Tuple index out of bounds');
        }

        $this->data[$index] = $item;
    }

    /**
     * @throws \Exception
     */
    public function push(CLValue $item): void
    {
        if (count($this->data) < $this->tupleSize) {
            $this->data[] = $item;
        }
        else {
            throw new \Exception('No more space in this tuple');
        }
    }
}
