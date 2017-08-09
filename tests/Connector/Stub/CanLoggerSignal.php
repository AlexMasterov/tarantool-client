<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Stub;

use Tarantool\Connector\Sensor;

trait CanLoggerSignal
{
    private function logger()
    {
        return new class() {
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
        };
    }

    private function logSignal(
        $logger,
        Sensor $sensor,
        array $signals = []
    ) {
        foreach ($signals as $signal) {
            $spyLogger = function ($result) use ($logger, $signal) {
                $logger->log($signal);
            };

            $sensor->listen($signal, $spyLogger);
        }
    }
}
