<?php

namespace Casper\CLType;

use Casper\Util\ByteUtil;

final class CLByteArrayType extends CLType
{
    private int $size;

    public function __construct(int $size)
    {
        $this->tag = new CLTypeTag(CLTypeTag::BYTE_ARRAY);
        $this->linkTo = CLByteArray::class;
        $this->size = $size;
    }

    public function toJSON(): array
    {
        $tagName = $this->tag->getTagName();
        return array($tagName => $this->size);
    }

    /**
     * @return int[]
     * @throws \Exception
     */
    public function toBytes(): array
    {
        return array_merge(
            [$this->tag->getTagValue()],
            ByteUtil::toBytesU32($this->size)
        );
    }
}
