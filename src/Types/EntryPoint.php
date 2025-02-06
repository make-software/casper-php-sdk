<?php

namespace Casper\Types;

use Casper\Types\CLValue\CLType\CLType;

class EntryPoint
{
    private string $access;

    private string $entryPointType;

    private string $name;

    private CLType $ret;

    /**
     * @var NamedCLTypeArg[]
     */
    private array $args;

    /**
     * @throws \Exception
     */
    public function __construct(string $access, string $entryPointType, string $name, CLType $ret, array $args)
    {
        $this->access = $access;
        $this->entryPointType = $entryPointType;
        $this->name = $name;
        $this->ret = $ret;
        $this->args = $args;
    }

    public function getAccess(): string
    {
        return $this->access;
    }

    public function getEntryPointType(): string
    {
        return $this->entryPointType;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRet(): CLType
    {
        return $this->ret;
    }

    public function getArgs(): array
    {
        return $this->args;
    }
}
