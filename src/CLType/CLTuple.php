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
