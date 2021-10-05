<?php

namespace Casper\CLType;

use Casper\Util\ByteUtil;

final class CLList extends CLValue
{
    private CLType $vectorType;

    /**
     * @param CLValue[]|CLType $data
     * @throws \Exception
     */
    public function __construct($data)
    {
        if (is_array($data) && $data[0] instanceof CLValue) {
            $refType = $data[0]->clType();

            foreach ($data as $clValue) {
                if ($clValue->clType()->toString() !== $refType->toString()) {
                    throw new \Exception('Invalid data provided.');
                }
            }

            $this->data = $data;
            $this->vectorType = $refType;
        }
        elseif ($data instanceof CLType) {
            $this->data = [];
            $this->vectorType = $data;
        }
        else {
            throw new \Exception('Invalid data type(s) provided.');
        }
    }

    /**
     * @throws \Exception
     */
    public static function fromBytesWithRemainder(array $bytes, ?CLType $listType = null): CLValueWithRemainder
    {
        $u32Result = CLU32::fromBytesWithRemainder($bytes);
        $size = (int) $u32Result->getClValue()->value();
        $remainder = $u32Result->getRemainder();
        $vector = [];

        for ($i = 0; $i < $size; $i++) {
            if (!$remainder) {
                self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_EARLY_END_OF_STREAM);
            }

            $clValueClass = $listType->getInner()->getLinkTo();
            $result = $clValueClass::fromBytesWithRemainder($remainder, $listType->getInner());

            $vector[] = $result->getClValue();
            $remainder = $result->getRemainder();
        }

        $value = count($vector) === 0
            ? new self($listType->getInner())
            : new self($vector);

        return new CLValueWithRemainder($value, $remainder);
    }

    /**
     * @return CLType|CLValue[]
     */
    public function value()
    {
        return $this->data;
    }

    public function clType(): CLListType
    {
        return new CLListType($this->vectorType);
    }

    /**
     * @return int[]
     * @throws \Exception
     */
    public function toBytes(): array
    {
        return ByteUtil::vectorToBytesU32($this->data);
    }

    public function parsedValue(): string
    {
        // TODO: Implement parsedValue() method
        return '';
    }

    /**
     * @throws \Exception
     */
    public function get(int $index): CLValue
    {
        $this->assertListIndexIsNotOutOfBounds($index);
        return $this->data[$index];
    }

    /**
     * @throws \Exception
     */
    public function set(int $index, CLValue $item): void
    {
        $this->assertListIndexIsNotOutOfBounds($index);
        $this->assertItemHasValidType($item);
        $this->data[$index] = $item;
    }

    /**
     * @throws \Exception
     */
    public function push(CLValue $item): void
    {
        $this->assertItemHasValidType($item);
        $this->data[] = $item;
    }

    /**
     * @throws \Exception
     */
    public function remove(int $index): void
    {
        $this->assertListIndexIsNotOutOfBounds($index);
        unset($this->data[$index]);
        $this->data = array_values($this->data);
    }

    public function pop(): ?CLValue
    {
        return array_pop($this->data);
    }

    public function size(): int
    {
        return count($this->data);
    }

    /**
     * @throws \Exception
     */
    private function assertListIndexIsNotOutOfBounds(int $index): void
    {
        if ($index < 0 || $index >= count($this->data)) {
            throw new \Exception('List index out of bounds.');
        }
    }

    /**
     * @throws \Exception
     */
    private function assertItemHasValidType(CLValue $item): void
    {
        if (get_class($item->clType()) !== get_class($this->vectorType)) {
            throw new \Exception('Inconsistent data type, use ' . $this->vectorType->toString());
        }
    }
}
