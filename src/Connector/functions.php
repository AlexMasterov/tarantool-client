<?php
declare(strict_types=1);

namespace Tarantool\Connector;

function stream_socket_set_nodelay(/** resource */ $stream, int $noDelayMs): void
{
    if (\function_exists('socket_import_stream')) {
        $socket = \socket_import_stream($stream);
        \socket_set_option($socket, \SOL_TCP, \TCP_NODELAY, $noDelayMs);
    }
}
