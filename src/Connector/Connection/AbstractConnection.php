<?php
declare(strict_types=1);

namespace Tarantool\Connector\Connection;

use Closure;
use Tarantool\Connector\{
    Connection,
    Connection\ConnectionException
};

abstract class AbstractConnection implements Connection
{
    /** @var resource|null */
    protected $stream = null;

    final public function __destruct()
    {
        $this->close();
    }

    abstract public function listen(string $name, Closure $callback): void;

    abstract public function open(): void;

    final public function close(): void
    {
        if (null !== $this->stream) {
            $stream = $this->stream;
            $this->stream = null;
            \fclose($stream);
        }
    }

    final public function send(string $data): int
    {
        $this->verifyConnection();

        $bytesWritten = \fwrite($this->stream, $data);

        if (false === $bytesWritten) {
            throw ConnectionException::cannotWrite();
        }

        $this->verifyAlive();

        return $bytesWritten;
    }

    final public function receive(int $bytes): string
    {
        $this->verifyConnection();

        $data = \stream_get_contents($this->stream, $bytes);

        if (false === $data) {
            throw ConnectionException::unableReadBytes($bytes);
        }

        $this->verifyAlive();

        return $data;
    }

    private function verifyAlive(): void
    {
        ['timed_out' => $timeout] = \stream_get_meta_data($this->stream);

        if ($timeout) {
            throw ConnectionException::timeout();
        }
    }

    private function verifyConnection(): void
    {
        if (null === $this->stream) {
            throw ConnectionException::cannotCommunicate();
        }
    }
}
