<?php
declare(strict_types=1);

namespace Tarantool\Connector\Socket;

use Tarantool\Connector\{
    SocketFactory,
    Socket\SocketException,
    Socket\StreamOptions
};

final class StreamFactory implements SocketFactory
{
    /** @var StreamOptions */
    private $options;

    public function __construct(StreamOptions $options = null)
    {
        $this->options = $options ?? new StreamOptions();
    }

    public function create(string $url) //: resource
    {
        $options = $this->options;

        $stream = @\stream_socket_client(
            $url,
            $errorCode,
            $errorMessage,
            $options->timeout(),
            $options->flags()
        );

        if (false === $stream) {
            throw SocketException::unableConnect($url, $errorMessage, $errorCode);
        }

        \stream_set_timeout(
            $stream,
            $options->readWriteTimeout(),
            $options->readWriteTimeoutMs()
        );

        $noDelay = $this->options->noDelay();
        if (is_int($noDelay) && \function_exists('socket_import_stream')) {
            $socket = \socket_import_stream($stream);
            \socket_set_option($socket, \SOL_TCP, \TCP_NODELAY, $noDelay);
        }

        return $stream;
    }
}
