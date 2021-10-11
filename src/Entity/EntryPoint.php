<?php

namespace Casper\Entity;

use Casper\Validation\EntityValidationAware;

class EntryPoint
{
    use EntityValidationAware;

    private string $access;

    private string $entryPointType;

    private string $name;

    private string $ret;

    /**
     * @var NamedCLTypeArg[]
     */
    private array $args;

    /**
     * @throws \Exception
     */
    public function __construct(string $access, string $entryPointType, string $name, string $ret, array $args)
    {
        $this->assertArrayContainsProperEntities($args, NamedCLTypeArg::class);

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

    public function getRet(): string
    {
        return $this->ret;
    }

    public function getArgs(): array
    {
        return $this->args;
    }
}
