<?php

namespace Laramate\FacadeMapper\Traits;

use Illuminate\Container\Container;
use Illuminate\Support\Str;
use Laramate\FacadeMapper\Exceptions\InvalidParameterException;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

trait HasFacadeMapper
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
    public static function mappedCall(string $method, array $arguments = [])
    {
        $className = static::getAccessorClassName();

        try {
            $reflection = new ReflectionClass($className);
        } catch (\Throwable $error) {
            throw new \Exception('Unable to reflect parameters', 0, $error);
        }

        if ('make' == $method && ! $reflection->hasMethod('make')) {
            return static::mappedConstructorCall($className, $arguments, $reflection);
        } else {
            return static::mappedMethodCall($className, $method, $arguments, $reflection);
        }
    }

    /**
     * @param string          $className
     * @param array           $arguments
     * @param ReflectionClass $reflection
     *
     * @throws InvalidParameterException
     * @throws ReflectionException
     *
     * @return object
     */
    protected static function mappedConstructorCall(string $className, array $arguments, ReflectionClass $reflection): object
    {
        $parameters = $reflection->getConstructor()->getParameters();

        return new $className(...static::composeParameters($parameters, $arguments));
    }

    /**
     * @param string          $className
     * @param string          $method
     * @param array           $arguments
     * @param ReflectionClass $reflection
     *
     * @throws InvalidParameterException
     * @throws ReflectionException
     *
     * @return object
     */
    protected static function mappedMethodCall(string $className, string $method, array $arguments, ReflectionClass $reflection): object
    {
        $parameters = $reflection->getMethod($method)->getParameters();

        return Container::getInstance()
            ->make($className)
            ->$method(...static::composeParameters($parameters, $arguments));
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
     * Compose method parameters.
     *
     * @param ReflectionParameter[] $parameters
     * @param array                 $arguments
     *
     * @throws InvalidParameterException
     * @throws ReflectionException
     *
     * @return array
     */
    protected static function composeParameters(array $parameters, array $arguments = []): array
    {
        foreach ($parameters as $key=>$parameter) {
            $result[$parameter->getPosition()] = static::resolveParameterValue($parameter, $arguments);
        }

        return $result ?? [];
    }

    /**
     * @param ReflectionParameter $parameter
     * @param array               $arguments
     *
     * @throws InvalidParameterException
     * @throws ReflectionException
     *
     * @return mixed
     */
    protected static function resolveParameterValue(ReflectionParameter $parameter, array &$arguments = [])
    {
        $name = $parameter->getName();

        if (array_key_exists($name, $arguments)) {
            $value = $arguments[$name];
        } elseif (array_key_exists(Str::snake($name), $arguments)) {
            $value = $arguments[Str::snake($name)];
        } elseif ($parameter->isDefaultValueAvailable()) {
            $value = $parameter->getDefaultValue();
        } elseif ($parameter->getType() && ! $parameter->getType()->isBuiltin()) {
            $value = Container::getInstance()->make($parameter->getType()->getName());
        } else {
            throw new InvalidParameterException('Invalid parameters!');
        }

        return $value;
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
            return static::mappedCall($method, $args[0]);
        }

        return parent::__callStatic($method, $args);
    }
}
