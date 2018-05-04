<?php
declare(strict_types=1);

namespace Northwoods\EntityProxy;

use ReflectionClass;
use ReflectionProperty;

class ProxyFactory
{
    /** @var Proxy[] */
    private $proxies = [];

    public function proxy(string $className): Proxy
    {
        if (isset($this->proxies[$className]) === false) {
            $this->proxies[$className] = $this->generateProxy(new ReflectionClass($className));
        }

        return clone $this->proxies[$className];
    }

    private function generateProxy(ReflectionClass $class): Proxy
    {
        $properties = [];
        foreach ($class->getProperties() as $property) {
            $properties[$property->getName()] = $property;
            $property->setAccessible(true);
        }

        return new Proxy(
            $class->newInstanceWithoutConstructor(),
            $properties
        );
    }
}
