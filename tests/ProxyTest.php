<?php
declare(strict_types=1);

namespace Northwoods\EntityProxy;

use PHPUnit\Framework\TestCase;

class ProxyTest extends TestCase
{
    public function testReveal()
    {
        $a = ProxyFactory::create(UserModel::class)->reveal();
        $b = ProxyFactory::create(UserModel::class)->reveal();

        $this->assertInstanceOf(UserModel::class, $a);
        $this->assertInstanceOf(UserModel::class, $b);
        $this->assertNotSame($a, $b);
    }

    public function testExisting()
    {
        $user = new UserModel($username = 'jane.doe');

        $proxy = ProxyFactory::modify($user);
        $proxy->set('id', $id = rand());

        $this->assertSame($id, $user->id());
        $this->assertSame($username, $user->username());
        $this->assertSame($username, $proxy->get('username'));
        $this->assertSame($user, $proxy->reveal());
    }

    public function testSet()
    {
        $proxy = ProxyFactory::create(UserModel::class)
            ->set('id', $id = rand())
            ->set('username', $username = uniqid());

        /** @var UserModel */
        $user = $proxy->reveal();

        $this->assertSame($id, $user->id());
        $this->assertSame($username, $user->username());
    }

    public function testSetArray()
    {
        $values = [
            'id' => $id = rand(),
            'username' => $username = uniqid(),
        ];

        $proxy = ProxyFactory::create(UserModel::class)
            ->setArray($values);

        /** @var UserModel */
        $user = $proxy->reveal();

        $this->assertSame($id, $user->id());
        $this->assertSame($username, $user->username());
    }
}
