<?php

namespace PetrKnap\Php\ServiceManager;

use PetrKnap\Php\ServiceManager\Exception\ConfigurationException;

trait ConfigCheckerTrait
{
    protected function checkInvokable($serviceName, $invokable)
    {
        if (!(is_string($invokable) && class_exists($invokable))) {
            throw $this->exceptionFactory("invokable", $serviceName, "class name as string", gettype($invokable));
        }
    }

    protected function checkFactory($serviceName, $factory)
    {
        if (!(is_string($factory) && class_exists($factory)) && !is_callable($factory)) {
            throw $this->exceptionFactory("factory", $serviceName, "callable or class name as string", gettype($factory));
        }
    }

    protected function checkShared($serviceName, $isShared)
    {
        if (!is_bool($isShared)) {
            throw $this->exceptionFactory("shared", $serviceName, "boolean", gettype($isShared));
        }
    }

    protected function checkSharedByDefault($isShared)
    {
        if (!is_bool($isShared)) {
            throw new ConfigurationException(
                sprintf(
                    "Shared by default must be boolean, %s given",
                    gettype($isShared)
                )
            );
        }
    }

    private function exceptionFactory($subject, $serviceName, $expectedType, $givenType)
    {
        return new ConfigurationException(
            sprintf(
                "Wrong %s for service `%s` - must be %s, %s given",
                $subject,
                $serviceName,
                $expectedType,
                $givenType
            )
        );
    }
}