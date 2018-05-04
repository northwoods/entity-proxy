<?php

namespace Northwoods\EntityProxy;

use PHPUnit\Framework\TestCase;

class ProxyTest extends TestCase
{
    /** @var ProxyFactory */
    private $factory;

    public function setUp()
    {
        $this->factory = new ProxyFactory();
    }

    public function testreveal()
    {
        $a = $this->factory->proxy(Example::class)->reveal();
        $b = $this->factory->proxy(Example::class)->reveal();

        $this->assertInstanceOf(Example::class, $a);
        $this->assertInstanceOf(Example::class, $b);
        $this->assertNotSame($a, $b);
    }

    public function testSet()
    {
        $instance = $this->factory->proxy(Example::class)
            ->set('id', $id = rand())
            ->set('username', $username = uniqid())
            ->reveal();

        $this->assertSame($id, $instance->id());
        $this->assertSame($username, $instance->username());
    }

    public function testSetArray()
    {
        $instance = $this->factory->proxy(Example::class)
            ->setArray([
                'id' => $id = rand(),
                'username' => $username = uniqid(),
            ])
            ->reveal();

        $this->assertSame($id, $instance->id());
        $this->assertSame($username, $instance->username());
    }
}
