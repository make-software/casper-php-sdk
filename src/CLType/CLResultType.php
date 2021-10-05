<?php

namespace Casper\CLType;

final class CLResultType extends CLType
{
    private CLType $innerOk;

    private CLType $innerErr;

    public function __construct(CLType $innerOk, CLType $innerErr)
    {
        $this->tag = new CLTypeTag(CLTypeTag::RESULT);
        $this->linkTo = CLResult::class;

        $this->innerOk = $innerOk;
        $this->innerErr = $innerErr;
    }

    public function getInnerOk(): CLType
    {
        return $this->innerOk;
    }

    public function getInnerErr(): CLType
    {
        return $this->innerErr;
    }

    public function toString(): string
    {
        return $this->tag->getTagName()
            . ' (OK: ' . $this->innerOk->toString() . ', ERR: ' . $this->innerErr->toString() . ')';
    }

    public function toJson(): array
    {
        return array(
            $this->tag->getTagName() => array(
                'ok' => $this->innerOk->toJson(),
                'err' => $this->innerErr->toJson(),
            )
        );
    }

    public function toBytes(): array
    {
        return array_merge(
            parent::toBytes(),
            $this->innerOk->toBytes(),
            $this->innerErr->toBytes()
        );
    }
}
