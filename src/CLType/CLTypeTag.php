<?php

namespace Casper\CLType;

class CLTypeTag
{
    public const BOOL = 0;          // A boolean value
    public const I32 = 1;           // A 32-bit signed integer
    public const I64 = 2;           // A 64-bit signed integer
    public const U8 = 3;            // An 8-bit unsigned integer (a byte)
    public const U32 = 4;           // A 32-bit unsigned integer
    public const U64 = 5;           // A 64-bit unsigned integer
    public const U128 = 6;          // A 128-bit unsigned integer
    public const U256 = 7;          // A 256-bit unsigned integer
    public const U512 = 8;          // A 512-bit unsigned integer
    public const UNIT = 9;          // A unit type, i.e. type with no values (analogous to `void` in C and `()` in Rust)
    public const STRING = 10;       // A string of characters
    public const KEY = 11;          // A key in the global state - URef/hash/etc.
    public const UREF = 12;         // An Unforgetable Reference (URef)
    public const OPTION = 13;       // An [[Option]], i.e. a type that can contain a value or nothing at all
    public const LIST = 14;         // A list of values
    public const BYTE_ARRAY = 15;   // A fixed-length array of bytes
    public const RESULT = 16;       // A [[Result]], i.e. a type that can contain either a value representing success or one representing failure
    public const MAP = 17;          // A key-value map
    public const TUPLE1 = 18;       // A 1-value tuple
    public const TUPLE2 = 19;       // A 2-value tuple, i.e. a pair of values
    public const TUPLE3 = 20;       // A 3-value tuple
    public const ANY = 21;          // A value of any type
    public const PUBLIC_KEY = 22;   // A value of public key type

    private const TAGS = [
        self::BOOL,
        self::I32,
        self::I64,
        self::U8,
        self::U32,
        self::U64,
        self::U128,
        self::U256,
        self::U512,
        self::UNIT,
        self::STRING,
        self::KEY,
        self::UREF,
        self::OPTION,
        self::LIST,
        self::BYTE_ARRAY,
        self::RESULT,
        self::MAP,
        self::TUPLE1,
        self::TUPLE2,
        self::TUPLE3,
        self::ANY,
        self::PUBLIC_KEY,
    ];

    /**
     * @throws \Exception
     */
    public static function new(int $tagValue): self
    {
        if (!in_array($tagValue, self::TAGS)) {
            throw new \Exception($tagValue . ' is invalid CLType tag. Available tags: ' . join(', ', self::TAGS));
        }

        return new static($tagValue);
    }

    private int $tagValue;

    private function __construct(int $tagValue)
    {
        $this->tagValue = $tagValue;
    }

    public function getTagValue(): int
    {
        return $this->tagValue;
    }
}
