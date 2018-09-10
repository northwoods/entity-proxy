<?php
declare(strict_types=1);

namespace Northwoods\EntityProxy;

use ReflectionClass;
use ReflectionProperty;

class ProxyFactory
{
    /** @var array<string,ReflectionProperty[]> */
    private $properties;

    /** @var array<string,ReflectionClass> */
    private $reflections = [];

    /**
     * Create a proxy for a new object
     */
    public function create(string $className): Proxy
    {
        $instance = $this->reflect($className)->newInstanceWithoutConstructor();

        return $this->modify($instance);
    }

    /**
     * Create a proxy for an existing object
     */
    public function modify(object $instance): Proxy
    {
        $properties = $this->properties(get_class($instance));

        return new Proxy($instance, $properties);
    }

    /** @var ReflectionProperty[] */
    private function properties(string $className): array
    {
        if (isset($this->properties[$className])) {
            return $this->properties[$className];
        }

        $reflection = $this->reflect($className);

        $properties = [];
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $properties[$property->getName()] = $property;
        }

        return $this->properties[$className] = $properties;
    }

    private function reflect(string $className): ReflectionClass
    {
        if (isset($this->reflections[$className])) {
            return $this->reflections[$className];
        }

        return $this->reflections[$className] = new ReflectionClass($className);
    }
}
