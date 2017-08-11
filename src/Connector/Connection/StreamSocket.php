<?php
declare(strict_types=1);

namespace Tarantool\Connector\Connection;

use Tarantool\Connector\{
    Connection,
    Connection\ConnectionException,
    Sensor\CanListen,
    Signal,
    Signal\Standart,
    SocketFactory
};

final class StreamSocket implements Connection
{
    use CanListen;

    /** @var resource|null */
    private $stream = null;

    /** @var string */
    private $url;

    /** @var SocketFactory */
    private $factory;

    /** @var Signal */
    private $signal;

    public function __construct(
        string $url,
        SocketFactory $factory,
        Signal $signal = null
    ) {
        $this->url = $url;
        $this->factory = $factory;
        $this->signal = $signal ?? new Standart();
    }

    public function __destruct()
    {
        $this->close();
    }

    public function open(): void
    {
        if (null === $this->stream) {
            $this->stream = $this->factory->create($this->url);
            $this->signal->beep('open');
        }
    }

    public function close(): void
    {
        if (null !== $this->stream) {
            $stream = $this->stream;
            $this->stream = null;
            \fclose($stream);
        }
    }

    public function send(string $data): int
    {
        $this->verifyConnection();

        $bytesWritten = \fwrite($this->stream, $data);

        if (false === $bytesWritten) {
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
