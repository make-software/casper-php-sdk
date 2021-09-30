<?php

namespace Casper\Serializer;

use Casper\Util\ByteUtil;

use Casper\Entity\DeployExecutable;
use Casper\Entity\DeployExecutableModuleBytes;
use Casper\Entity\DeployExecutableTransfer;
use Casper\Entity\DeployNamedArg;

class DeployExecutableSerializer extends Serializer
{
    protected const DEPLOY_EXECUTABLE_MAP = array(
        'ModuleBytes' => DeployExecutableModuleBytes::class,
        'Transfer' => DeployExecutableTransfer::class,
    );

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
            $executableInternalClass = self::DEPLOY_EXECUTABLE_MAP[$key] ?? null;

            switch ($executableInternalClass) {
                case DeployExecutableModuleBytes::class:
                    $executableInternalInstance = new DeployExecutableModuleBytes(
                        ByteUtil::hexToByteArray($data['module_bytes'])
                    );
                    $deployExecutable->setModuleBytes($executableInternalInstance);
                    break;
                case DeployExecutableTransfer::class:
                    $executableInternalInstance = new DeployExecutableTransfer();
                    $deployExecutable->setTransfer($executableInternalInstance);
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
