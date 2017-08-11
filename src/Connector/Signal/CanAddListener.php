<?php
declare(strict_types=1);

namespace Tarantool\Connector\Signal;

use Closure;

trait CanAddListener
{
    /** @var iterable */
    private $listeners = [];

    public function addlistener(string $name, Closure $callback): void
    {
        $this->listeners[$name][] = $callback;
    }
}
