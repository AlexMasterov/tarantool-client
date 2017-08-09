<?php
declare(strict_types=1);

namespace Tarantool\Connector\Connection;

trait CanCopy
{
    // Conceptually, cloning is not just copying,
    //  but that word is reserved by PHP.
    public function copy(string $name, $value): self
    {
        $clone = clone $this;
        $clone->{$name} = $value;

        return $clone;
    }
}
