<?php

namespace Laramate\FacadeMapper\Traits;

use Laramate\FacadeMapper\Exceptions\InvalidParameterException;
use ReflectionException;

trait HasFacadeMappedCalls
{
    /**
     * Call a class method using parameter mapping.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @throws InvalidParameterException
     * @throws ReflectionException
     *
     * @return object
     */
    public static function forwardMappedCall(string $method, array $arguments = [])
    {
        $className = static::getAccessorClassName();

        return static::mappedCall($className, $method, $arguments);
    }

    /**
     * Get the accessor class name.
     *
     * @return string
     */
    protected static function getAccessorClassName(): string
    {
        $accessor = static::getFacadeAccessor();

        return is_object($accessor) ? get_class($accessor) : $accessor;
    }

    /**
     * Handle dynamic, static calls to the object.
     *
     * @param string $method
     * @param array  $args
     *
     * @throws InvalidParameterException
     * @throws ReflectionException
     *
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        if (1 === count($args) && is_array($args[0])) {
            return static::forwardMappedCall($method, $args[0]);
        }

        return parent::__callStatic($method, $args);
    }
}
