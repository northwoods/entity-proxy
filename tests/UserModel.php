<?php
declare(strict_types=1);

namespace Northwoods\EntityProxy;

class UserModel
{
    /** @var int */
    private $id;

    /** @var string */
    private $username;

    public function __construct(
        string $username
    ) {
        $this->username = $username;
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
