<?php

namespace Casper\Validation;

trait EntityValidationAware
{
    protected function assertArrayContainsProperEntities(array $entityArray, string $properEntityClassName): void
    {
        foreach ($entityArray as $entity) {
            if (!$entity instanceof $properEntityClassName) {
                throw new \Exception('Invalid entity array. Should contains only ' . $properEntityClassName . ' entities');
            }
        }
    }
}
