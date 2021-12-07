<?php

namespace Casper\Entity;

abstract class DeployExecutableItemInternal implements ToBytesConvertible
{
    /**
     * @var DeployNamedArg[]
     */
    protected array $args = array();

    public function setArg(DeployNamedArg $deployNamedArg): self
    {
        $this->args[] = $deployNamedArg;
        return $this;
    }

    /**
     * @return DeployNamedArg[]
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    public function getArgByName(string $name): ?DeployNamedArg
    {
        foreach ($this->args as $arg) {
            if ($arg->getName() === $name) {
                return $arg;
            }
        }

        return null;
    }

    /**
     * @throws \Exception
     */
    public function getArgParsedValueByName(string $name)
    {
        $arg = $this->getArgByName($name);

        if (!$arg) {
            throw new \Exception('Argument not found');
        }

        return $arg->getValue()
            ->parsedValue();
    }
}
