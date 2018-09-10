<?php
declare(strict_types=1);

namespace Northwoods\EntityProxy;

use ReflectionProperty;

class Proxy
{
    /** @var object */
    private $instance;

    /** @var ReflectionProperty[] */
    private $properties;

    /**
     * @param ReflectionProperty[] $properties
     */
    public function __construct(object $instance, array $properties)
    {
        $this->instance = $instance;
        $this->properties = $properties;
    }

    /** @return mixed */
    public function get(string $name)
    {
        return $this->properties[$name]->getValue($this->instance);
    }

    /**
     * @param mixed $value
     */
    public function set(string $name, $value): self
    {
        $this->properties[$name]->setValue($this->instance, $value);

        return $this;
    }

    public function setArray(array $values): self
    {
        foreach ($values as $name => $value) {
            $this->set($name, $value);
        }

        return $this;
    }

    public function reveal(): object
    {
        return $this->instance;
    }
}
