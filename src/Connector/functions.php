<?php
declare(strict_types=1);

namespace Tarantool\Connector;

function pack_length(int $length): string
{
    return \pack('CN', 0xce, $length);
}

function unpack_length(string $data): int
{
    ['length' => $length] = \unpack('C_/Nlength', $data);

    return $length;
}

function socket_set_nodelay($stream, int $noDelayMs): void
{
    if (\function_exists('socket_import_stream')) {
        $socket = \socket_import_stream($stream);
        \socket_set_option($socket, \SOL_TCP, \TCP_NODELAY, $noDelayMs);
    }
}
