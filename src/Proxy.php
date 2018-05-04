<?php
declare(strict_types=1);

namespace Northwoods\EntityProxy;

class Proxy
{
    /** @var object */
    private $instance;

    /** @var \ReflectionProperty[] */
    private $properties;

    /**
     * @param object $instance
     */
    public function __construct($instance, array $properties)
    {
        $this->instance = $instance;
        $this->properties = $properties;
    }

    public function __clone()
    {
        $this->instance = clone $this->instance;
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

    /**
     * @return object
     */
    public function reveal()
    {
        return $this->instance;
    }
}
