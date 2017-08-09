<?php
declare(strict_types=1);

namespace Tarantool\Connector\Connection;

use Tarantool\Connector\{
    Connection\AbstractConnection,
    Connection\ConnectionException,
    Connection\SocketOptions,
    Sensor\CanListen,
    Signal\Standart
};

final class TcpSocket extends AbstractConnection
{
    use CanListen;

    /** @var string */
    private $host;

    /** @var int */
    private $port;

    /** @var SocketOptions */
    private $options;

    public function __construct(
        string $host,
        int $port,
        SocketOptions $options
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->options = $options;
        $this->signal = new Standart();
    }

    public function open(): void
    {
        $stream = @\stream_socket_client(
            "tcp://{$this->host}:{$this->port}",
            $errorCode,
            $errorMessage,
            $this->options->timeout(),
            $this->options->flags()
        );

        if (false === $stream) {
            throw ConnectionException::unableConnect($this->host, $errorMessage, $errorCode);
        }

        $this->stream = $stream;

        \stream_set_timeout(
            $this->stream,
            $this->options->readWriteTimeoutSeconds(),
            $this->options->readWriteTimeoutMicroseconds()
        );

        $noDelay = $this->options->noDelay();
        if (is_int($noDelay)) {
            $socket = \socket_import_stream($this->stream);
            \socket_set_option($socket, \SOL_TCP, \TCP_NODELAY, $noDelay);
        }

        $this->signal->beep('open');
    }
}
