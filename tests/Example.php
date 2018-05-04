<?php
declare(strict_types=1);

namespace Northwoods\EntityProxy;

class Example
{
    /** @var int */
    private $id;

    /** @var string */
    private $username;

    public function __construct()
    {
        throw new \LogicException('Should never be called');
    }

    public function id(): int
    {
        return $this->id;
    }

    public function username(): string
    {
        return $this->username;
    }
}
