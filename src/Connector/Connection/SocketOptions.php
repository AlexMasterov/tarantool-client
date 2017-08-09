<?php
declare(strict_types=1);

namespace Tarantool\Connector\Connection;

use Tarantool\Connector\Connection\CanCopy;

final class SocketOptions
{
    use CanCopy;

    /** @var int */
    private $flags = \STREAM_CLIENT_CONNECT;

    /** @var float */
    private $timeout;

    /** @var int */
    private $readWriteTimeoutSeconds = 10;

    /** @var int */
    private $readWriteTimeoutMicroseconds = 0;

    /** @var int */
    private $noDelay = 2;

    public function __construct(float $timeout = 10.0)
    {
        $this->timeout = $timeout;
    }

    public function withAsync(): self
    {
        $newFlags = $this->flags | \STREAM_CLIENT_ASYNC_CONNECT;

        return $this->copy('flags', $newFlags);
    }

    public function withPersistent(): self
    {
        $newFlags = $this->flags | \STREAM_CLIENT_PERSISTENT;

        return $this->copy('flags', $newFlags);
    }

    public function flags(): int
    {
        return $this->flags;
    }

    public function withTimeout(float $timeout): self
    {
        return $this->copy('timeout', $timeout);
    }

    public function timeout(): float
    {
        return $this->timeout;
    }

    public function withReadWriteTimeoutSeconds(int $timeoutSeconds): self
    {
        return $this->copy('readWriteTimeoutSeconds', $timeoutSeconds);
    }

    public function readWriteTimeoutSeconds(): int
    {
        return $this->readWriteTimeoutSeconds;
    }

    public function withReadWriteTimeoutMicroseconds(int $timeoutMicroseconds): self
    {
        return $this->copy('readWriteTimeoutMicroseconds', $timeoutMicroseconds);
    }

    public function readWriteTimeoutMicroseconds(): int
    {
        return $this->readWriteTimeoutMicroseconds;
    }

    public function withNoDelay(int $delayMicroseconds): self
    {
        return $this->copy('noDelay', $delayMicroseconds);
    }

    public function noDelay(): ?int
    {
        return $this->noDelay;
    }
}
