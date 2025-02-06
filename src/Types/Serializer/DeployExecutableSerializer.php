<?php

namespace Casper\Types\Serializer;

use Casper\Types\DeployExecutable;
use Casper\Types\DeployExecutableModuleBytes;
use Casper\Types\DeployExecutableStoredContractByHash;
use Casper\Types\DeployExecutableStoredContractByName;
use Casper\Types\DeployExecutableStoredVersionedContractByHash;
use Casper\Types\DeployExecutableStoredVersionedContractByName;
use Casper\Types\DeployExecutableTransfer;

class DeployExecutableSerializer extends JsonSerializer
{
    /**
     * @param DeployExecutable $deployExecutable
     */
    public static function toJson($deployExecutable): array
    {
        if ($deployExecutable instanceof DeployExecutableModuleBytes) {
            $result['ModuleBytes'] = array(
                'module_bytes' => $deployExecutable->getHexModuleBytes(),
                'args' => NamedArgSerializer::toJsonArray(
                    $deployExecutable->getArgs()
                )
            );
        }
        else if ($deployExecutable instanceof DeployExecutableStoredVersionedContractByHash) {
            $result['StoredVersionedContractByHash'] = array(
                'hash' => $deployExecutable->getHash(),
                'version' => $deployExecutable->getVersion(),
                'entry_point' => $deployExecutable->getEntryPoint(),
                'args' => NamedArgSerializer::toJsonArray(
                    $deployExecutable->getArgs()
                ),
            );
        }
        else if ($deployExecutable instanceof DeployExecutableStoredContractByHash) {
            $result['StoredContractByHash'] = array(
                'hash' => $deployExecutable->getHash(),
                'entry_point' => $deployExecutable->getEntryPoint(),
                'args' => NamedArgSerializer::toJsonArray(
                    $deployExecutable->getArgs()
                ),
            );
        }
        else if ($deployExecutable instanceof DeployExecutableStoredVersionedContractByName) {
            $result['StoredVersionedContractByName'] = array(
                'name' => $deployExecutable->getName(),
                'version' => $deployExecutable->getVersion(),
                'entry_point' => $deployExecutable->getEntryPoint(),
                'args' => NamedArgSerializer::toJsonArray(
                    $deployExecutable->getArgs()
                ),
            );
        }
        else if ($deployExecutable instanceof DeployExecutableStoredContractByName) {
            $result['StoredContractByName'] = array(
                'name' => $deployExecutable->getName(),
                'entry_point' => $deployExecutable->getEntryPoint(),
                'args' => NamedArgSerializer::toJsonArray(
                    $deployExecutable->getArgs()
                ),
            );
        }
        else if ($deployExecutable instanceof DeployExecutableTransfer) {
            $result['Transfer'] = array(
                'args' => NamedArgSerializer::toJsonArray(
                    $deployExecutable->getArgs()
                ),
            );
        }

        return $result ?? [];
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): DeployExecutable
    {
        foreach ($json as $key => $data) {
            $executableInternalClass = 'Casper\Types\DeployExecutable' . $key;

            switch ($executableInternalClass) {
                case DeployExecutableModuleBytes::class:
                    $executableInternalInstance = new DeployExecutableModuleBytes($data['module_bytes']);
                    break;
                case DeployExecutableTransfer::class:
                    $executableInternalInstance = new DeployExecutableTransfer();
                    break;
                case DeployExecutableStoredContractByHash::class:
                    $executableInternalInstance = new DeployExecutableStoredContractByHash(
                        $data['hash'],
                        $data['entry_point']
                    );
                    break;
                case DeployExecutableStoredContractByName::class:
                    $executableInternalInstance = new DeployExecutableStoredContractByName(
                        $data['name'],
                        $data['entry_point']
                    );
                    break;
                case DeployExecutableStoredVersionedContractByHash::class:
                    $executableInternalInstance = new DeployExecutableStoredVersionedContractByHash(
                        $data['hash'],
                        $data['entry_point'],
                        $data['version'] ?? null
                    );
                    break;
                case DeployExecutableStoredVersionedContractByName::class:
                    $executableInternalInstance = new DeployExecutableStoredVersionedContractByName(
                        $data['name'],
                        $data['entry_point'],
                        $data['version'] ?? null
                    );
                    break;
                default:
                    throw new \Exception('Unknown executable type: ' . $executableInternalClass);
            }

            foreach ($data['args'] as $arg) {
                $executableInternalInstance->setArg(NamedArgSerializer::fromJson($arg));
            }
        }

        return $executableInternalInstance;
    }
}
