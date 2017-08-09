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

final class UnixSocket extends AbstractConnection
{
    use CanListen;

    /** @var string */
    private $socketPath;

    /** @var SocketOptions */
    private $options;

    public function __construct(
        string $socketPath,
        SocketOptions $options
    ) {
        $this->socketPath = $socketPath;
        $this->options = $options;
        $this->signal = new Standart();
    }

    public function open(): void
    {
        $stream = @\stream_socket_client(
            "unix://{$this->socketPath}",
            $errorCode,
            $errorMessage,
            $this->options->timeout(),
            $this->options->flags()
        );

        if (false === $stream) {
            throw ConnectionException::unableConnect($this->socketPath, $errorMessage, $errorCode);
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
