<?php

namespace Casper\CLType;

use Casper\Util\ByteUtil;

abstract class Numeric extends CLValue
{
    /**
     * @var \GMP
     */
    protected $data;

    protected int $bitSize;

    protected bool $signed;

    /**
     * @param int|string|\GMP $value
     * @param int $bitSize
     * @param bool $isSigned
     *
     * @throws \Exception
     */
    public function __construct($value, int $bitSize, bool $isSigned)
    {
        $this->bitSize = $bitSize;
        $this->signed = $isSigned;
        $this->data = gettype($value) === 'object' && get_class($value) === 'GMP'
            ? $value
            : gmp_init($value);

        if ($isSigned === false && gmp_cmp($this->data, 0) === -1) {
            throw new \Exception('Can\'t provide negative numbers with isSigned=false');
        }
    }

    public function value(): \GMP
    {
        return $this->data;
    }

    /**
     * @return int[]
     * @throws \Exception
     */
    public function toBytes(): array
    {
        return ByteUtil::toBytesNumber($this->bitSize, $this->signed, $this->data);
    }
}
