<?php
declare(strict_types=1);

namespace Northwoods\EntityProxy;

use ReflectionClass;
use ReflectionProperty;

final class ProxyFactory
{
    /** @var array<string,ReflectionProperty[]> */
    private static $properties = [];

    /** @var array<string,ReflectionClass> */
    private static $reflections = [];

    /**
     * Create a proxy for a new object
     */
    public static function create(string $className): Proxy
    {
        $instance = self::reflect($className)->newInstanceWithoutConstructor();

        return self::modify($instance);
    }

    /**
     * Create a proxy for an existing object
     */
    public static function modify(object $instance): Proxy
    {
        $properties = self::properties(get_class($instance));

        return new Proxy($instance, $properties);
    }

    /** @var ReflectionProperty[] */
    private static function properties(string $className): array
    {
        if (isset(self::$properties[$className])) {
            return self::$properties[$className];
        }

        $reflection = self::reflect($className);

        $properties = [];
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $properties[$property->getName()] = $property;
        }

        return self::$properties[$className] = $properties;
    }

    private static function reflect(string $className): ReflectionClass
    {
        if (isset(self::$reflections[$className])) {
            return self::$reflections[$className];
        }

        return self::$reflections[$className] = new ReflectionClass($className);
    }

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }
}
