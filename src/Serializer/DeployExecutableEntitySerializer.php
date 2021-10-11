<?php

namespace Casper\Serializer;

use Casper\Entity\DeployExecutable;
use Casper\Entity\DeployExecutableModuleBytes;
use Casper\Entity\DeployExecutableStoredContractByHash;
use Casper\Entity\DeployExecutableStoredContractByName;
use Casper\Entity\DeployExecutableStoredVersionedContractByHash;
use Casper\Entity\DeployExecutableStoredVersionedContractByName;
use Casper\Entity\DeployExecutableTransfer;

class DeployExecutableEntitySerializer extends EntitySerializer
{
    /**
     * @param DeployExecutable $deployExecutable
     * @return array
     */
    public static function toJson($deployExecutable): array
    {
        if ($deployExecutable->isModuleBytes()) {
            $result['ModuleBytes'] = array(
                'module_bytes' => $deployExecutable->getModuleBytes()->getModuleBytes(),
                'args' => DeployNamedArgEntitySerializer::toJsonArray(
                    $deployExecutable->getModuleBytes()->getArgs()
                )
            );
        }
        elseif ($deployExecutable->isStoredContractByHash()) {
            $result['StoredContractByHash'] = array(
                'hash' => $deployExecutable->getStoredContractByHash()->getHash(),
                'entry_point' => $deployExecutable->getStoredContractByHash()->getEntryPoint(),
                'args' => DeployNamedArgEntitySerializer::toJsonArray(
                    $deployExecutable->getStoredContractByHash()->getArgs()
                ),
            );
        }
        elseif ($deployExecutable->isStoredContractByName()) {
            $result['StoredContractByName'] = array(
                'name' => $deployExecutable->getStoredContractByName()->getName(),
                'entry_point' => $deployExecutable->getStoredContractByName()->getEntryPoint(),
                'args' => DeployNamedArgEntitySerializer::toJsonArray(
                    $deployExecutable->getStoredContractByName()->getArgs()
                ),
            );
        }
        elseif ($deployExecutable->isStoredVersionedContractByHash()) {
            $result['StoredVersionedContractByHash'] = array(
                'hash' => $deployExecutable->getStoredVersionedContractByHash()->getHash(),
                'version' => $deployExecutable->getStoredVersionedContractByHash()->getVersion(),
                'entry_point' => $deployExecutable->getStoredVersionedContractByHash()->getEntryPoint(),
                'args' => DeployNamedArgEntitySerializer::toJsonArray(
                    $deployExecutable->getStoredVersionedContractByHash()->getArgs()
                ),
            );
        }
        elseif ($deployExecutable->isStoredVersionedContractByName()) {
            $result['StoredVersionedContractByName'] = array(
                'name' => $deployExecutable->getStoredVersionedContractByName()->getName(),
                'version' => $deployExecutable->getStoredVersionedContractByName()->getVersion(),
                'entry_point' => $deployExecutable->getStoredVersionedContractByName()->getEntryPoint(),
                'args' => DeployNamedArgEntitySerializer::toJsonArray(
                    $deployExecutable->getStoredVersionedContractByName()->getArgs()
                ),
            );
        }
        elseif ($deployExecutable->isTransfer()) {
            $result['Transfer'] = array(
                'args' => DeployNamedArgEntitySerializer::toJsonArray(
                    $deployExecutable->getTransfer()->getArgs()
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
                case DeployExecutableStoredContractByName::class:
                    $executableInternalInstance = new DeployExecutableStoredContractByName(
                        $data['name'],
                        $data['entry_point']
                    );
                    $deployExecutable->setStoredContractByName($executableInternalInstance);
                    break;
                case DeployExecutableStoredVersionedContractByHash::class:
                    $executableInternalInstance = new DeployExecutableStoredVersionedContractByHash(
                        $data['hash'],
                        $data['entry_point'],
                        $data['version'] ?? null
                    );
                    $deployExecutable->setStoredVersionedContractByHash($executableInternalInstance);
                    break;
                case DeployExecutableStoredVersionedContractByName::class:
                    $executableInternalInstance = new DeployExecutableStoredVersionedContractByName(
                        $data['name'],
                        $data['entry_point'],
                        $data['version'] ?? null
                    );
                    $deployExecutable->setStoredVersionedContractByName($executableInternalInstance);
                    break;
                default:
                    throw new \Exception('Unknown executable type: ' . $executableInternalClass);
            }

            foreach ($data['args'] as $arg) {
                $executableInternalInstance->setArg(DeployNamedArgEntitySerializer::fromJson($arg));
            }
        }

        return $deployExecutable;
    }
}
