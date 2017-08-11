<?php
declare(strict_types=1);

namespace Tarantool\Connector\Socket;

use Tarantool\Connector\{
    SocketFactory,
    Socket\SocketException,
    Socket\StreamOptions
};
use function Tarantool\Connector\socket_set_nodelay;

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

        \stream_set_timeout($stream, $options->readWriteTimeout(), $options->readWriteTimeoutMs());

        if ($options->hasNoDelay()) {
            socket_set_nodelay($stream, $options->noDelay());
        }

        return $stream;
    }
}
