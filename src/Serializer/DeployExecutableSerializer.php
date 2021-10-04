<?php

namespace Casper\Serializer;

use Casper\Entity\DeployExecutable;
use Casper\Entity\DeployExecutableModuleBytes;
use Casper\Entity\DeployExecutableStoredContractByHash;
use Casper\Entity\DeployExecutableTransfer;
use Casper\Entity\DeployNamedArg;

class DeployExecutableSerializer extends Serializer
{
    /**
     * @param DeployExecutable $deployExecutable
     * @return array
     */
    public static function toJson($deployExecutable): array
    {
        // TODO: Implement toJson() method.
        return [];
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): DeployExecutable
    {
        $deployExecutable = new DeployExecutable();

        foreach ($json as $key => $data) {
            $executableInternalClass = 'Casper\Entity\DeployExecutable' . $key;

            switch ($executableInternalClass) {
                case DeployExecutableModuleBytes::class:
                    $executableInternalInstance = new DeployExecutableModuleBytes($data['module_bytes']);
                    $deployExecutable->setModuleBytes($executableInternalInstance);
                    break;
                case DeployExecutableTransfer::class:
                    $executableInternalInstance = new DeployExecutableTransfer();
                    $deployExecutable->setTransfer($executableInternalInstance);
                    break;
                case DeployExecutableStoredContractByHash::class:
                    $executableInternalInstance = new DeployExecutableStoredContractByHash(
                        $data['hash'],
                        $data['entry_point']
                    );
                    $deployExecutable->setStoredContractByHash($executableInternalInstance);
                    break;
                default:
                    throw new \Exception('Unknown executable type: ' . $executableInternalClass);
            }

            foreach ($data['args'] as $arg) {
                $executableInternalInstance->setArg(
                    new DeployNamedArg($arg[0], CLValueSerializer::fromJson($arg[1]))
                );
            }
        }

        return $deployExecutable;
    }
}
