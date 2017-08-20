<?php
declare(strict_types=1);

namespace Tarantool\Connector\Connection;

use Closure;
use Tarantool\Connector\{
    Connection,
    Connection\ConnectionException,
    Sensor,
    SocketFactory
};

final class StreamSocket implements Connection
{
    /** @var resource|null */
    private $stream = null;

    /** @var string */
    private $url;

    /** @var SocketFactory */
    private $factory;

    /** @var Sensor */
    private $sensor;

    public function __construct(
        string $url,
        SocketFactory $factory,
        Sensor $sensor
    ) {
        $this->url = $url;
        $this->factory = $factory;
        $this->sensor = $sensor;
    }

    public function __destruct()
    {
        $this->close();
    }

    public function on(string $event, Closure $listener): void
    {
        $this->sensor->on($event, $listener);
    }

    public function off(string $event, Closure $listener): void
    {
        $this->sensor->off($event, $listener);
    }

    public function open(): void
    {
        if (null !== $this->stream) {
            return;
        }

        $this->stream = $this->factory->create($this->url);
        $this->sensor->emit('open');
    }

    public function close(): void
    {
        if (null === $this->stream) {
            return;
        }

        $stream = $this->stream;
        $this->stream = null;
        \fclose($stream);
    }

    public function send(string $data): int
    {
        $this->verifyConnection();

        $bytesWritten = \fwrite($this->stream, $data);

        if (false === $bytesWritten || 0 === $bytesWritten) {
            throw ConnectionException::cannotWrite();
        }

        $this->verifyAlive();

        return $bytesWritten;
    }

    public function receive(int $bytes): string
    {
        $this->verifyConnection();

        $data = \stream_get_contents($this->stream, $bytes);

        if (false === $data) {
            throw ConnectionException::unableReadBytes($bytes);
        }

        $this->verifyAlive();

        return $data;
    }

    private function verifyConnection(): void
    {
        if (null === $this->stream) {
            throw ConnectionException::cannotCommunicate();
        }
    }

    private function verifyAlive(): void
    {
        ['timed_out' => $timeout] = \stream_get_meta_data($this->stream);

        if ($timeout) {
            throw ConnectionException::timeout();
        }
    }
}
