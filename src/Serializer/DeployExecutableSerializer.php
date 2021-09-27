<?php

namespace Casper\Serializer;

use Casper\CLType\CLByteArray;
use Casper\CLType\CLByteArrayType;
use Casper\CLType\CLOption;
use Casper\Entity\DeployExecutable;
use Casper\Entity\DeployExecutableModuleBytes;
use Casper\Entity\DeployExecutableTransfer;
use Casper\Entity\DeployNamedArg;
use Casper\Interfaces\Serializer;
use Casper\Util\ByteUtil;

class DeployExecutableSerializer implements Serializer
{
    protected const DEPLOY_EXECUTABLE_MAP = array(
        'ModuleBytes' => DeployExecutableModuleBytes::class,
        'Transfer' => DeployExecutableTransfer::class,
    );

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
                $clValueData = $arg[1];
                $clClassNameSpace = 'Casper\CLType';

                if (is_array($clValueData['cl_type'])) {
                    $clValueClass = $clClassNameSpace . '\CL' . array_key_first($clValueData['cl_type']);
                    $clTypeParam = $clValueData['cl_type'][array_key_first($clValueData['cl_type'])];

                    //TODO: Add all types
                    switch ($clValueClass) {
                        case CLByteArray::class:
                            $clType = new CLByteArrayType($clTypeParam);
                            break;
                        case CLOption::class:
                            $clTypeClass = $clClassNameSpace . '\CL' . $clTypeParam . 'Type';
                            $clType = new $clTypeClass;
                            break;
                        default:
                            throw new \Exception('The complex type ' . $clValueClass . 'Type' . ' is not supported');
                    }
                }
                else {
                    $clValueClass = $clClassNameSpace . '\CL' . $clValueData['cl_type'];
                }

                $value = $clValueClass::fromBytes(
                    ByteUtil::hexToByteArray($clValueData['bytes']),
                    $clType ?? null
                );

                $clType = null;
                $executableInternalInstance->setArg(new DeployNamedArg($arg[0], $value));
            }
        }

        return $deployExecutable;
    }
}
