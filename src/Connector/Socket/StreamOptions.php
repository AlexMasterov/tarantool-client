<?php
declare(strict_types=1);

namespace Tarantool\Connector\Socket;

use Tarantool\Connector\Socket\CanCopy;

final class StreamOptions
{
    use CanCopy;

    /** @var int */
    private $flags = \STREAM_CLIENT_CONNECT;

    /** @var float */
    private $timeout;

    /** @var int */
    private $readWriteTimeout = 3;

    /** @var int */
    private $readWriteTimeoutMs = 0;

    /** @var int|null */
    private $noDelay = null;

    public function __construct(float $timeout = 3.0)
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

    public function withReadWriteTimeout(int $timeout): self
    {
        return $this->copy('readWriteTimeout', $timeout);
    }

    public function readWriteTimeout(): int
    {
        return $this->readWriteTimeout;
    }

    public function withReadWriteTimeoutMs(int $timeoutMs): self
    {
        return $this->copy('readWriteTimeoutMs', $timeoutMs);
    }

    public function readWriteTimeoutMs(): int
    {
        return $this->readWriteTimeoutMs;
    }

    public function withNoDelay(int $delayMs): self
    {
        return $this->copy('noDelay', $delayMs);
    }

    public function noDelay(): ?int
    {
        return $this->noDelay;
    }
}
