<?php

namespace Casper\CLType;

final class CLKey extends CLValue
{
    private const KEY_TYPE_ACCOUNT = 0;
    private const KEY_TYPE_HASH = 1;
    private const KEY_TYPE_UREF = 2;

    private const KEY_TYPES_MAP = array(
        CLAccountHash::class => self::KEY_TYPE_ACCOUNT,
        CLByteArray::class => self::KEY_TYPE_HASH,
        CLURef::class => self::KEY_TYPE_UREF,
    );

    /**
     * @param CLByteArray|CLURef|CLAccountHash $keyParam
     * @throws \Exception
     */
    public function __construct($keyParam)
    {
        $this->assertCLKeyParametersAreValid($keyParam);
        $this->data = $keyParam;
    }

    /**
     * @param mixed $keyParam
     * @throws \Exception
     */
    private function assertCLKeyParametersAreValid($keyParam): void
    {
        $availableParams = [
            CLByteArray::class,
            CLURef::class,
            CLAccountHash::class,
        ];

        if (!is_object($keyParam) || !in_array(get_class($keyParam), $availableParams)) {
            throw new \Exception('Invalid key param');
        }
    }

    /**
     * @return CLByteArray|CLURef|CLAccountHash
     */
    public function value()
    {
        return $this->data;
    }

    public function clType(): CLKeyType
    {
        return new CLKeyType();
    }

    public function toBytes(): array
    {
        return array_merge(
            [self::KEY_TYPES_MAP[get_class($this->data)]],
            $this->data->toBytes()
        );
    }

    public function isHash(): bool
    {
        return $this->data instanceof CLByteArray;
    }

    public function isURef(): bool
    {
        return $this->data instanceof CLURef;
    }

    public function isAccount(): bool
    {
        return $this->data instanceof CLAccountHash;
    }
}
