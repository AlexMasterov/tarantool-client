<?php
declare(strict_types=1);

namespace Tarantool\Connector\Connection;

use Closure;
use DateInterval;
use DateTimeImmutable;
use Tarantool\Connector\Connection;

final class AutomaticConnection implements Connection
{
    /** @var bool */
    private $connecting = false;

    /** @var DateTimeImmutable|null */
    private $connectedAt = null;

    /** @var Connection */
    private $decoratedConnection;

    /** @var DateInterval */
    private $interval;

    public function __construct(
        Connection $decoratedConnection,
        DateInterval $interval
    ) {
        $this->decoratedConnection = $decoratedConnection;
        $this->interval = $interval;
    }

    public function on(string $event, Closure $listener): void
    {
        $this->decoratedConnection->on($event, $listener);
    }

    public function off(string $event, Closure $listener): void
    {
        $this->decoratedConnection->off($event, $listener);
    }

    public function open(): void
    {
        if ($this->connecting) {
            return;
        }

        try {
            $this->connecting = true;
            $this->decoratedConnection->open();
            $this->connectedAt = new DateTimeImmutable('now');
        } finally {
            $this->connecting = false;
        }
    }

    public function close(): void
    {
        $this->decoratedConnection->close();
        $this->connectedAt = null;
    }

    public function send(string $data): int
    {
        $this->connectIfNotConnected();

        return $this->decoratedConnection->send($data);
    }

    public function receive(int $bytes): string
    {
        $this->connectIfNotConnected();

        return $this->decoratedConnection->receive($bytes);
    }

    private function connectIfNotConnected(): void
    {
        $this->connectedAt ?? $this->open();

        if ($this->connecting) {
            return;
        }

        if ($this->connectedAt->add($this->interval) < new DateTimeImmutable('now')) {
            $this->close();
            $this->open();
        }
    }
}
