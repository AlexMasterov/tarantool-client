<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Stub;

use Tarantool\Connector\Sensor;

final class SpyLogger
{
    /** @var array */
    private $log = [];

    public function log($message): void
    {
        $this->log[] = $message;
    }

    public function journal(): array
    {
        return $this->log;
    }

    public function clear(): void
    {
        $this->log = [];
    }

    public function logSignal(
        Sensor $sensor,
        array $signals = []
    ) {
        foreach ($signals as $signal) {
            $callback = function () use ($signal) {
                $this->log($signal);
            };

            $sensor->listen($signal, $callback);
        }
    }
}
