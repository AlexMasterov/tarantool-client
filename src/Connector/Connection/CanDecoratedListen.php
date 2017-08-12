<?php
declare(strict_types=1);

namespace Tarantool\Connector\Connection;

use Closure;

trait CanDecoratedListen
{
    public function listen(string $name, Closure $callback): void
    {
        $this->decoratedConnection->listen($name, $callback);
    }
}
