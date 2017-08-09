<?php
declare(strict_types=1);

namespace Tarantool\Connector\Sensor;

use Closure;

trait CanListen
{
    /** @var Signal */
    private $signal;

    public function listen(string $name, Closure $callback): void
    {
        $this->signal->addlistener($name, $callback);
    }
}
