<?php

namespace Casper\Model;

use Casper\Interfaces\ToBytesInterface;

abstract class DeployExecutableItemInternal implements ToBytesInterface
{
    /**
     * @var DeployNamedArg[]
     */
    protected array $args = array();

    public function setArg(DeployNamedArg $deployNamedArg): self
    {
        $this->args[] = $deployNamedArg;
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
}
